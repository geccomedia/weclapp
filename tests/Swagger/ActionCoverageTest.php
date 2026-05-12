<?php

namespace Geccomedia\Weclapp\Tests\Swagger;

use Geccomedia\Weclapp\Model;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionMethod;

/**
 * Verifies that every action endpoint declared in the swagger spec has a
 * corresponding named method on the appropriate model or utility class.
 *
 * Two endpoint shapes are checked:
 *
 *   Collection action:  /root/actionName          → public function actionName()
 *   Instance action:    /root/id/{id}/actionName  → public function actionName()
 *
 * Since Model::callAction() now dispatches to either the collection or instance
 * API path based on $this->exists, both shapes are covered by one non-static
 * method.  The test verifies only that the named method exists — not how it
 * routes internally.
 *
 * Utility roots (system, job, meta, …) are checked against their registered
 * covering class rather than a Model subclass.
 */
class ActionCoverageTest extends TestCase
{
    /**
     * Action names that appear in the swagger but are intentionally excluded
     * from the named-method requirement.
     *
     * 'count' is handled by Model::count(), not a named action method.
     *
     * @var list<string>
     */
    private const EXCLUDED_ACTIONS = ['count'];

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /**
     * Returns all public method names defined directly on a class (not inherited).
     *
     * @return array<string, true>
     */
    private static function ownPublicMethods(string $fqcn): array
    {
        $rc = new ReflectionClass($fqcn);
        $methods = [];

        foreach ($rc->getMethods(ReflectionMethod::IS_PUBLIC) as $m) {
            if ($m->getDeclaringClass()->getName() === $fqcn) {
                $methods[$m->getName()] = true;
            }
        }

        return $methods;
    }

    /**
     * Returns the FQCN of the class responsible for a given swagger path root.
     * Models are looked up in src/Models/; utility roots use UTILITY_ROOTS.
     *
     * For shared roots (e.g. /party, which covers Customer/Contact/Lead/Supplier),
     * the canonical model — whose short name equals ucfirst($root) — is preferred
     * over the subtype models, because actions are defined on the canonical class.
     */
    private static function classFqcnForRoot(string $root): ?string
    {
        // Utility roots map directly to a specific class
        if (isset(Spec::UTILITY_ROOTS[$root])) {
            return Spec::UTILITY_ROOTS[$root];
        }

        // Prefer the canonical model whose class name matches the root
        // (e.g. root "party" → Party, not Contact/Customer/Lead/Supplier)
        $canonical = Spec::MODEL_NS.ucfirst($root);
        if (class_exists($canonical)) {
            return $canonical;
        }

        // Fall back to the first model whose getTable() matches this root
        foreach (Spec::modelShortNames() as $short) {
            if (Spec::rootFor($short) === $root) {
                return Spec::MODEL_NS.$short;
            }
        }

        return null;
    }

    // -------------------------------------------------------------------------
    // Test
    // -------------------------------------------------------------------------

    /**
     * Every swagger action path must have a corresponding named method on the
     * responsible model or utility class.
     *
     * A "missing" entry means a client user has no convenient way to call that
     * API endpoint without falling back to raw Builder::action() / callAction().
     */
    public function test_every_swagger_action_has_a_named_method(): void
    {
        $paths = Spec::paths();
        $missing = [];

        foreach (array_keys($paths) as $path) {
            $parts = explode('/', ltrim($path, '/'));
            $root = $parts[0];

            // Determine whether this is an action path (not a plain CRUD path)
            $isCollectionAction = count($parts) === 2
                && ! in_array($parts[1], ['count'], true);

            $isInstanceAction = count($parts) === 4
                && $parts[1] === 'id'
                && $parts[2] === '{id}';

            if (! $isCollectionAction && ! $isInstanceAction) {
                continue;
            }

            $action = $parts[count($parts) - 1];

            if (in_array($action, self::EXCLUDED_ACTIONS, true)) {
                continue;
            }

            $fqcn = self::classFqcnForRoot($root);

            if ($fqcn === null || ! class_exists($fqcn)) {
                continue;
            }

            // Check the full inheritance chain for the method
            if (! method_exists($fqcn, $action)) {
                $missing[] = "{$fqcn}::{$action}()  ← {$path}";
            }
        }

        $this->assertEmpty(
            $missing,
            count($missing)." swagger action(s) have no named method:\n  "
            .implode("\n  ", $missing)
        );
    }

    /**
     * No model may have an action method whose name appears in the swagger for
     * that root's CRUD paths (GET, PUT, DELETE on /id/{id}).  This guards against
     * accidentally shadowing Eloquent methods like save(), delete(), find(), etc.
     *
     * The check is narrow: it only looks at methods that call $this->callAction().
     */
    public function test_action_methods_do_not_shadow_base_model_methods(): void
    {
        $baseModelMethods = array_fill_keys(
            get_class_methods(Model::class),
            true
        );

        $conflicts = [];

        foreach (Spec::modelShortNames() as $short) {
            $fqcn = Spec::MODEL_NS.$short;

            foreach (self::ownPublicMethods($fqcn) as $method => $_) {
                // Only examine methods that delegate to callAction
                $src = (new ReflectionMethod($fqcn, $method))->getFileName();
                if ($src === false) {
                    continue;
                }
                $body = file_get_contents($src) ?: '';
                // Quick heuristic: method body contains 'callAction'
                $start = (new ReflectionMethod($fqcn, $method))->getStartLine();
                $end = (new ReflectionMethod($fqcn, $method))->getEndLine();
                $lines = array_slice(explode("\n", $body), $start - 1, $end - $start + 1);
                if (! str_contains(implode(' ', $lines), 'callAction')) {
                    continue;
                }

                if (isset($baseModelMethods[$method])) {
                    $conflicts[] = "{$fqcn}::{$method}() shadows a base Model method";
                }
            }
        }

        $this->assertEmpty(
            $conflicts,
            "Action methods must not shadow base Model methods:\n  "
            .implode("\n  ", $conflicts)
        );
    }
}
