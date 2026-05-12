<?php

namespace Geccomedia\Weclapp\Tests\Swagger;

use PHPUnit\Framework\TestCase;
use ReflectionMethod;

/**
 * Verifies that the HTTP verb used inside each named action method matches what
 * the swagger spec declares for that endpoint.
 *
 * Every action method in this codebase delegates to:
 *
 *   $this->callAction('actionName', $params, 'GET'|'POST')
 *
 * The swagger spec declares each action endpoint with exactly one HTTP method —
 * either "get" or "post".  This test extracts the verb from the method source
 * and compares it (case-insensitively) to the swagger declaration.
 *
 * Methods that do not contain a callAction() call are skipped — this test only
 * cares about action dispatchers, not relation methods or other helpers.
 */
class ActionVerbTest extends TestCase
{
    /**
     * Action names excluded from verb checking.
     * 'count' is handled internally by Model::count(), not a named action method.
     *
     * @var list<string>
     */
    private const EXCLUDED_ACTIONS = ['count'];

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /**
     * Returns the FQCN of the class responsible for a given swagger path root.
     * Mirrors the logic in SwaggerActionCoverageTest.
     */
    private static function classFqcnForRoot(string $root): ?string
    {
        if (isset(Spec::UTILITY_ROOTS[$root])) {
            return Spec::UTILITY_ROOTS[$root];
        }

        $canonical = Spec::MODEL_NS.ucfirst($root);
        if (class_exists($canonical)) {
            return $canonical;
        }

        foreach (Spec::modelShortNames() as $short) {
            if (Spec::rootFor($short) === $root) {
                return Spec::MODEL_NS.$short;
            }
        }

        return null;
    }

    /**
     * Reads the source of a method and returns the HTTP verb string passed to
     * callAction() as the third argument (e.g. 'GET' or 'POST').
     * Returns null when no callAction() call is found in the method body.
     */
    private static function extractCallActionVerb(string $fqcn, string $methodName): ?string
    {
        $rm = new ReflectionMethod($fqcn, $methodName);
        $file = $rm->getFileName();

        if ($file === false) {
            return null;
        }

        $lines = file($file, FILE_IGNORE_NEW_LINES) ?: [];
        $body = implode(' ', array_slice($lines, $rm->getStartLine() - 1, $rm->getEndLine() - $rm->getStartLine() + 1));

        // Match: callAction('actionName', $params, 'VERB')
        // or:    callAction("actionName", $params, "VERB")
        if (preg_match('/callAction\s*\([^,]+,[^,]+,\s*[\'"]([A-Z]+)[\'"]\s*\)/', $body, $m)) {
            return strtoupper($m[1]);
        }

        return null;
    }

    // -------------------------------------------------------------------------
    // Test
    // -------------------------------------------------------------------------

    /**
     * Every named action method must use the HTTP verb declared in the swagger
     * spec for its corresponding endpoint.
     *
     * A "wrong verb" entry means the client would send GET when swagger expects
     * POST (or vice versa), resulting in a 4xx error at runtime.
     */
    public function test_action_method_verbs_match_swagger(): void
    {
        $paths = Spec::paths();
        $wrongVerb = [];

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

            if (! method_exists($fqcn, $action)) {
                continue; // Missing method is SwaggerActionCoverageTest's concern.
            }

            // The swagger spec verb for this path (always exactly one: get or post)
            $swaggerVerb = strtoupper(array_keys($paths[$path])[0]);

            // The verb baked into the action method's callAction() call
            $codeVerb = self::extractCallActionVerb($fqcn, $action);

            if ($codeVerb === null) {
                continue; // Not a callAction dispatcher; skip.
            }

            if ($codeVerb !== $swaggerVerb) {
                $wrongVerb[] = sprintf(
                    '%s::%s() uses %s but swagger declares %s  ← %s',
                    $fqcn,
                    $action,
                    $codeVerb,
                    $swaggerVerb,
                    $path
                );
            }
        }

        $this->assertEmpty(
            $wrongVerb,
            count($wrongVerb)." action method(s) use the wrong HTTP verb:\n  "
            .implode("\n  ", $wrongVerb)
        );
    }
}
