<?php

namespace Geccomedia\Weclapp\Tests\Swagger;

use GuzzleHttp\Client;
use ReflectionClass;

/**
 * Process-level cache for the live Weclapp swagger spec.
 *
 * All Swagger*Test files call methods on this class.  The spec is fetched
 * exactly once per PHP process regardless of how many test classes use it.
 */
final class Spec
{
    // -------------------------------------------------------------------------
    // Constants shared by every test file
    // -------------------------------------------------------------------------

    public const MODEL_NS = 'Geccomedia\\Weclapp\\Models\\';

    /**
     * Swagger path roots handled by a dedicated class rather than a plain Model.
     * Value = FQCN of the covering class.
     *
     * @var array<string, string>
     */
    public const UTILITY_ROOTS = [
        'job' => 'Geccomedia\\Weclapp\\JobApi',
        'meta' => 'Geccomedia\\Weclapp\\Models\\Meta',
        'propertyTranslation' => 'Geccomedia\\Weclapp\\Models\\PropertyTranslation',
        'salesChannel' => 'Geccomedia\\Weclapp\\Models\\SalesChannel',
        'system' => 'Geccomedia\\Weclapp\\SystemApi',
    ];

    /**
     * Models whose getTable() does NOT equal lcfirst(ClassName).
     *
     * @var array<string, string> ClassName => swagger root
     */
    public const TABLE_OVERRIDES = [
        'Contact' => 'party',
        'Customer' => 'party',
        'Lead' => 'party',
        'Supplier' => 'party',
    ];

    // -------------------------------------------------------------------------
    // Process-level spec cache
    // -------------------------------------------------------------------------

    /** @var array<string, array<string, mixed>>|null */
    private static ?array $paths = null;

    /** @var array<string, array{crud: bool, post: bool, put: bool, delete: bool}>|null */
    private static ?array $crudSpec = null;

    /** @var array<string, array<string, mixed>>|null definitionName => definition object */
    private static ?array $definitions = null;

    // -------------------------------------------------------------------------
    // Spec accessors
    // -------------------------------------------------------------------------

    /**
     * Fetch the full swagger spec once and populate both $paths and $definitions.
     */
    private static function fetchSpec(): void
    {
        $client = new Client(['timeout' => 30]);
        $spec = json_decode(
            (string) $client->get('https://www.weclapp.com/api/swagger.json')->getBody(),
            true,
            flags: JSON_THROW_ON_ERROR
        );
        self::$paths = $spec['paths'];
        self::$definitions = $spec['definitions'];
    }

    /**
     * Raw paths object from the swagger spec, fetched once per process.
     *
     * @return array<string, array<string, mixed>>
     */
    public static function paths(): array
    {
        if (self::$paths === null) {
            self::fetchSpec();
        }

        return self::$paths;
    }

    /**
     * Full definitions map from the swagger spec, fetched once per process.
     *
     * @return array<string, array<string, mixed>> definitionName => definition object (with 'properties', etc.)
     */
    public static function definitions(): array
    {
        if (self::$definitions === null) {
            self::fetchSpec();
        }

        return self::$definitions;
    }

    /**
     * CRUD capability map: pathRoot => {crud, post, put, delete}.
     * Only roots that expose GET /root/id/{id} are included (i.e. real CRUD
     * models, not action-only roots like /system or /meta).
     *
     * @return array<string, array{crud: bool, post: bool, put: bool, delete: bool}>
     */
    public static function crudRoots(): array
    {
        if (self::$crudSpec !== null) {
            return self::$crudSpec;
        }

        $roots = [];

        foreach (self::paths() as $path => $definition) {
            $parts = explode('/', ltrim($path, '/'));
            $root = $parts[0];
            $methods = array_keys($definition);

            $roots[$root] ??= ['crud' => false, 'post' => false, 'put' => false, 'delete' => false];

            if (count($parts) === 3 && $parts[1] === 'id' && $parts[2] === '{id}') {
                if (in_array('get', $methods, true)) {
                    $roots[$root]['crud'] = true;
                }
                if (in_array('put', $methods, true)) {
                    $roots[$root]['put'] = true;
                }
                if (in_array('delete', $methods, true)) {
                    $roots[$root]['delete'] = true;
                }
            }

            if (count($parts) === 1 && in_array('post', $methods, true)) {
                $roots[$root]['post'] = true;
            }
        }

        return self::$crudSpec = array_filter($roots, fn ($r) => $r['crud']);
    }

    // -------------------------------------------------------------------------
    // Model introspection helpers
    // -------------------------------------------------------------------------

    /**
     * Short names of every concrete (non-abstract) model class on disk.
     *
     * @return list<string>
     */
    public static function modelShortNames(): array
    {
        $names = [];
        foreach (glob(__DIR__.'/../src/Models/*.php') ?: [] as $file) {
            $short = basename($file, '.php');
            $fqcn = self::MODEL_NS.$short;
            if (class_exists($fqcn) && ! (new ReflectionClass($fqcn))->isAbstract()) {
                $names[] = $short;
            }
        }

        return $names;
    }

    /**
     * Swagger path root for a model class.
     * Respects TABLE_OVERRIDES first, then falls back to the model's getTable().
     */
    public static function rootFor(string $shortName): string
    {
        return self::TABLE_OVERRIDES[$shortName]
            ?? (new ReflectionClass(self::MODEL_NS.$shortName))
                ->newInstanceWithoutConstructor()
                ->getTable();
    }

    /**
     * Returns whether the model allows the given operation ('creatable',
     * 'updatable', 'deletable').
     * Returns false when the corresponding NoCreate / NoUpdate / NoDelete
     * primitive trait is present anywhere in the class hierarchy.
     */
    public static function boolProp(string $shortName, string $prop): bool
    {
        $blockingTrait = match ($prop) {
            'creatable' => 'Geccomedia\\Weclapp\\Traits\\NoCreate',
            'updatable' => 'Geccomedia\\Weclapp\\Traits\\NoUpdate',
            'deletable' => 'Geccomedia\\Weclapp\\Traits\\NoDelete',
            default => null,
        };

        if ($blockingTrait === null) {
            return true;
        }

        return ! isset(class_uses_recursive(self::MODEL_NS.$shortName)[$blockingTrait]);
    }
}
