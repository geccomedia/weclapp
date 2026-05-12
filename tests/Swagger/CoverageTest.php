<?php

namespace Geccomedia\Weclapp\Tests\Swagger;

use PHPUnit\Framework\TestCase;

/**
 * Verifies that every swagger path root is covered by a model or utility class,
 * that no model points at a non-existent swagger root (orphan detection), and
 * that every model uses the NoCreate / NoUpdate / NoDelete primitive traits
 * to match its swagger mutation profile — no property declarations allowed.
 */
class CoverageTest extends TestCase
{
    // -------------------------------------------------------------------------
    // 1. Path-root coverage
    // -------------------------------------------------------------------------

    /**
     * Every CRUD swagger root must map to a model class.
     * Every action-only root must appear in UTILITY_ROOTS with a covering class.
     */
    public function test_every_swagger_root_is_covered(): void
    {
        $modelRoots = array_map(
            fn ($s) => Spec::rootFor($s),
            Spec::modelShortNames()
        );
        $covered = array_unique(
            array_merge($modelRoots, array_keys(Spec::UTILITY_ROOTS))
        );

        $uncovered = array_values(array_diff(
            array_keys(Spec::crudRoots()),
            $covered
        ));

        $this->assertEmpty(
            $uncovered,
            'Swagger CRUD roots with no model or utility wrapper: '.implode(', ', $uncovered)."\n"
            .'Add a Model (for CRUD roots) or register it in Spec::UTILITY_ROOTS.'
        );
    }

    /** Every class listed in UTILITY_ROOTS must actually exist. */
    public function test_utility_root_covering_classes_exist(): void
    {
        foreach (Spec::UTILITY_ROOTS as $root => $class) {
            $this->assertTrue(
                class_exists($class),
                "UTILITY_ROOTS['{$root}'] references non-existent class {$class}."
            );
        }
    }

    /**
     * Every model's getTable() must appear somewhere in the swagger paths.
     * Catches phantom models left behind after Weclapp removes an endpoint.
     */
    public function test_no_model_maps_to_a_nonexistent_swagger_root(): void
    {
        $allRoots = array_unique(array_map(
            fn ($p) => explode('/', ltrim($p, '/'))[0],
            array_keys(Spec::paths())
        ));

        $orphans = [];
        foreach (Spec::modelShortNames() as $short) {
            $root = Spec::rootFor($short);
            if (! in_array($root, $allRoots, true)) {
                $orphans[] = "{$short} → {$root}";
            }
        }

        $this->assertEmpty(
            $orphans,
            'Models pointing at non-existent swagger roots: '.implode(', ', $orphans)
        );
    }

    // -------------------------------------------------------------------------
    // 2. Primitive trait consistency
    // -------------------------------------------------------------------------

    /**
     * Every model must express its mutation restrictions via the NoCreate,
     * NoUpdate, and NoDelete primitive traits rather than $creatable /
     * $updatable / $deletable property declarations.
     *
     * The test checks both directions:
     *   - If swagger has no POST  → model must use NoCreate
     *   - If swagger has no PUT   → model must use NoUpdate
     *   - If swagger has no DELETE → model must use NoDelete
     *   - And the inverse: if swagger HAS the verb, the model must NOT block it
     */
    public function test_models_use_primitive_traits_not_properties(): void
    {
        $noCreateFqcn = 'Geccomedia\\Weclapp\\Traits\\NoCreate';
        $noUpdateFqcn = 'Geccomedia\\Weclapp\\Traits\\NoUpdate';
        $noDeleteFqcn = 'Geccomedia\\Weclapp\\Traits\\NoDelete';

        $usesProperties = [];
        $missing = [];
        $spurious = [];

        foreach (Spec::modelShortNames() as $short) {
            $root = Spec::rootFor($short);

            if (isset(Spec::TABLE_OVERRIDES[$short])) {
                continue;
            }

            $crudRoots = Spec::crudRoots();
            if (! isset($crudRoots[$root])) {
                continue;
            }

            $fqcn = Spec::MODEL_NS.$short;
            $rc = new \ReflectionClass($fqcn);
            $traits = class_uses_recursive($fqcn);

            // Fail if the model still uses property declarations
            foreach (['creatable', 'updatable', 'deletable'] as $prop) {
                if ($rc->hasProperty($prop) && $rc->getProperty($prop)->getDeclaringClass()->getName() === $fqcn) {
                    $usesProperties[] = "{$short}::\${$prop}";
                }
            }

            // Check each primitive trait matches the swagger profile
            $checks = [
                'post' => [$noCreateFqcn, 'NoCreate'],
                'put' => [$noUpdateFqcn, 'NoUpdate'],
                'delete' => [$noDeleteFqcn, 'NoDelete'],
            ];

            foreach ($checks as $verb => [$traitFqcn, $traitName]) {
                $apiHas = $crudRoots[$root][$verb];
                $hasTrait = isset($traits[$traitFqcn]);

                if (! $apiHas && ! $hasTrait) {
                    $missing[] = "{$short} missing {$traitName} (swagger has no {$verb})";
                } elseif ($apiHas && $hasTrait) {
                    $spurious[] = "{$short} has spurious {$traitName} (swagger has {$verb})";
                }
            }
        }

        $this->assertEmpty($usesProperties,
            'Models must use traits instead of properties: '.implode(', ', $usesProperties));
        $this->assertEmpty($missing,
            'Models missing required primitive traits: '.implode(', ', $missing));
        $this->assertEmpty($spurious,
            'Models with spurious primitive traits: '.implode(', ', $spurious));
    }
}
