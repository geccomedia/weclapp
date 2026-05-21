<?php

namespace Geccomedia\Weclapp\Tests\Swagger;

use GuzzleHttp\Client;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * Verifies that every property declared in a swagger sub-definition at
 * https://www.weclapp.com/api/swagger.json is also declared as a "@property"
 * annotation on the corresponding sub-model class.
 *
 * The sub-model → definition mapping is inferred automatically:
 *   - swagger definition name = lcfirst($className), which holds for every
 *     sub-model class on disk without exception.
 *   - Sub-model classes with no matching swagger definition are listed in
 *     SKIP_SUBMODELS and skipped silently.
 */
class SubModelTest extends TestCase
{
    private const SUBMODEL_NS = 'Geccomedia\\Weclapp\\SubModels\\';

    /**
     * Sub-model class names that have no swagger definition of their own.
     * Key = short class name.
     *
     * @var list<string>
     */
    private const SKIP_SUBMODELS = [
        // none at present
    ];

    /** @var array<string, list<string>>|null */
    private static ?array $definitions = null;

    /** @var array<string, bool>|null Definition names referenced directly in swagger paths */
    private static ?array $pathRefs = null;

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /**
     * Fetches the swagger spec once and returns definitionName -> propertyNames[].
     * Also populates $pathRefs as a side-effect.
     *
     * @return array<string, list<string>>
     */
    private static function definitions(): array
    {
        if (self::$definitions !== null) {
            return self::$definitions;
        }

        $client = new Client(['timeout' => 30]);
        $swagger = json_decode(
            (string) $client->get('https://www.weclapp.com/api/swagger.json')->getBody(),
            true,
            flags: JSON_THROW_ON_ERROR
        );

        self::$definitions = [];
        foreach ($swagger['definitions'] as $name => $def) {
            self::$definitions[$name] = array_keys($def['properties'] ?? []);
        }

        self::$pathRefs = [];
        preg_match_all('/#\/definitions\/(\w+)/', json_encode($swagger['paths']), $m);
        foreach ($m[1] as $ref) {
            self::$pathRefs[$ref] = true;
        }

        return self::$definitions;
    }

    /**
     * @return array<string, bool>
     */
    private static function pathRefs(): array
    {
        if (self::$pathRefs === null) {
            self::definitions();
        }

        return self::$pathRefs ?? [];
    }

    /**
     * Returns all @property names from the docblock chain of the given FQCN.
     *
     * @return list<string>
     */
    private static function modelProperties(string $fqcn): array
    {
        $props = [];
        $rc = new ReflectionClass($fqcn);

        do {
            $doc = $rc->getDocComment();
            if ($doc !== false) {
                preg_match_all('/@property[^$]*\$(\w+)/', $doc, $m);
                array_push($props, ...$m[1]);
            }
        } while ($rc = $rc->getParentClass());

        return array_values(array_unique($props));
    }

    /**
     * Returns every sub-model class name on disk, keyed by short name,
     * excluding entries in SKIP_SUBMODELS.
     *
     * @return array<string, string> shortName => fqcn
     */
    private static function subModelClasses(): array
    {
        $result = [];

        foreach (glob(__DIR__.'/../../src/SubModels/*.php') ?: [] as $file) {
            $shortName = basename($file, '.php');

            if (in_array($shortName, self::SKIP_SUBMODELS, true)) {
                continue;
            }

            $result[$shortName] = self::SUBMODEL_NS.$shortName;
        }

        return $result;
    }

    // -------------------------------------------------------------------------
    // Data provider
    // -------------------------------------------------------------------------

    /**
     * Yields [shortName, fqcn, definitionName] for every sub-model on disk.
     *
     * @return array<string, array{string, string, string}>
     */
    public static function subModelDefinitionPairs(): array
    {
        $cases = [];

        foreach (self::subModelClasses() as $shortName => $fqcn) {
            $cases[$shortName] = [$shortName, $fqcn, lcfirst($shortName)];
        }

        return $cases;
    }

    // -------------------------------------------------------------------------
    // Tests
    // -------------------------------------------------------------------------

    /**
     * Every swagger definition that is NOT reachable via a path root AND is not
     * already covered as a top-level model must have a matching SubModel class
     * (lcfirst(ClassName) == definitionName).
     */
    public function test_every_sub_definition_has_a_submodel_class(): void
    {
        $definitions = self::definitions();
        $pathRefs = self::pathRefs();

        // Build a set of definition names covered by sub-model classes on disk.
        $coveredBySubModels = [];
        foreach (self::subModelClasses() as $shortName => $_) {
            $coveredBySubModels[lcfirst($shortName)] = true;
        }

        // Build a set of top-level model definition names (by scanning Models/).
        $topLevelDefs = [];
        foreach (glob(__DIR__.'/../../src/Models/*.php') ?: [] as $file) {
            $shortName = basename($file, '.php');
            $fqcn = 'Geccomedia\\Weclapp\\Models\\'.$shortName;
            if (class_exists($fqcn) && ! (new ReflectionClass($fqcn))->isAbstract()) {
                $topLevelDefs[lcfirst($shortName)] = true;
                // Also cover the $table value (e.g. party for Customer)
                $table = (new ReflectionClass($fqcn))->newInstanceWithoutConstructor()->getTable();
                $topLevelDefs[$table] = true;
            }
        }
        // Also add known shared definitions used by top-level models.
        $topLevelDefs['customValue'] = true;
        $topLevelDefs['shipmentReturnDescription'] = true;

        $uncovered = [];

        foreach (array_keys($definitions) as $defName) {
            if (isset($pathRefs[$defName])) {
                continue; // reachable via path root → top-level model territory
            }

            if (isset($topLevelDefs[$defName])) {
                continue; // covered by a top-level model
            }

            if (! isset($coveredBySubModels[$defName])) {
                $uncovered[] = $defName;
            }
        }

        $this->assertEmpty(
            $uncovered,
            sprintf(
                "%d swagger sub-definition(s) have no matching SubModel class:\n  - %s",
                count($uncovered),
                implode("\n  - ", $uncovered),
            )
        );
    }

    /**
     * Every property of a swagger sub-definition must be declared as @property
     * on the corresponding sub-model class.
     */
    #[DataProvider('subModelDefinitionPairs')]
    public function test_sub_model_declares_all_swagger_properties(
        string $shortName,
        string $fqcn,
        string $definitionName
    ): void {
        $definitions = self::definitions();

        $this->assertArrayHasKey(
            $definitionName,
            $definitions,
            "Swagger sub-definition '{$definitionName}' (for {$shortName}) does not exist in the spec."
        );

        $missing = array_values(array_diff($definitions[$definitionName], self::modelProperties($fqcn)));

        $this->assertEmpty(
            $missing,
            sprintf(
                "%s is missing %d @property annotation(s) from the '%s' swagger sub-definition:\n  - %s",
                $fqcn,
                count($missing),
                $definitionName,
                implode("\n  - ", $missing),
            )
        );
    }
}
