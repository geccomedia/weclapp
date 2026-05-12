<?php

namespace Geccomedia\Weclapp\Tests\Swagger;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

/**
 * Verifies that every property in a swagger definition that ends in "Id" and
 * references a known model class has a corresponding belongsTo() relation method
 * on the model.
 *
 * The convention in this codebase is:
 *   - FK field  customerId  → relation method  customer()  → Party::class
 *   - FK field  currencyId  → relation method  currency()  → Currency::class
 *
 * The target model class is inferred by stripping the trailing "Id" from the
 * field name and mapping the result to a class in the Models namespace.
 * If no class exists for that name, the field is skipped (it may reference a
 * sub-definition, an enum, or an unknown resource).
 *
 * Party-subtype models (Customer, Contact, Lead, Supplier) whose table is
 * "party" are checked against the Party class since that is what belongsTo
 * resolves to.  The subtypes inherit all relations from Party.
 */
class RelationCoverageTest extends TestCase
{
    /**
     * FK fields that are intentionally not backed by a belongsTo relation.
     * Keys are "ClassName.fieldName" for model-specific exclusions;
     * bare "fieldName" entries apply across all models.
     *
     * @var array<int, string>
     */
    private const EXCLUDED = [
        // weclappOs has no top-level model counterpart
        'weclappOsId',
        // Refers to a sub-definition, not a top-level Model
        'customerHabitualExporterLetterOfIntentId',
        // Self-referential or variant article links that are not exposed as relations
        'variantArticleId',
    ];

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /**
     * Returns the property names declared in a swagger definition.
     *
     * @return list<string>
     */
    private static function swaggerProperties(string $definitionName): array
    {
        // Reuse the cached spec from Spec
        static $defs = null;

        if ($defs === null) {
            $client = new Client(['timeout' => 30]);
            $swagger = json_decode(
                (string) $client->get('https://www.weclapp.com/api/swagger.json')->getBody(),
                true,
                flags: JSON_THROW_ON_ERROR
            );
            $defs = $swagger['definitions'];
        }

        return array_keys($defs[$definitionName]['properties'] ?? []);
    }

    /**
     * Returns the swagger definition name for a model class.
     * Handles TABLE_OVERRIDES (party subtypes) and the ShipmentReturn* cluster.
     */
    private static function definitionFor(string $shortName): string
    {
        // Party subtypes all map to the "party" definition
        if (isset(Spec::TABLE_OVERRIDES[$shortName])) {
            return Spec::TABLE_OVERRIDES[$shortName];
        }

        return lcfirst($shortName);
    }

    // -------------------------------------------------------------------------
    // Test
    // -------------------------------------------------------------------------

    /**
     * Every *Id property in a swagger definition that corresponds to a known
     * model class must have a named belongsTo relation on the model.
     */
    public function test_every_foreign_key_property_has_a_belongs_to_relation(): void
    {
        $missing = [];

        foreach (Spec::modelShortNames() as $short) {
            // Party subtypes inherit all relations from Party — skip duplicates
            if (isset(Spec::TABLE_OVERRIDES[$short]) && $short !== 'Party') {
                continue;
            }

            $definitionName = self::definitionFor($short);
            $properties = self::swaggerProperties($definitionName);
            $fqcn = Spec::MODEL_NS.$short;

            foreach ($properties as $prop) {
                // Only consider properties ending in 'Id'
                if (! str_ends_with($prop, 'Id')) {
                    continue;
                }

                if (in_array($prop, self::EXCLUDED, true)) {
                    continue;
                }

                // Derive the expected relation name: strip trailing 'Id'
                $relationName = substr($prop, 0, -2);

                // Derive the expected target model: PascalCase of the relation name
                $targetShort = ucfirst($relationName);
                $targetFqcn = Spec::MODEL_NS.$targetShort;

                // If no model class exists for that name, skip (e.g. enum FK, sub-definition)
                if (! class_exists($targetFqcn)) {
                    continue;
                }

                // The relation method must exist somewhere in the class hierarchy
                if (! method_exists($fqcn, $relationName)) {
                    $missing[] = "{$short}::{$relationName}()  ← \${$prop} → {$targetShort}";
                }
            }
        }

        $this->assertEmpty(
            $missing,
            count($missing)." FK properties have no belongsTo relation:\n  "
            .implode("\n  ", $missing)
        );
    }
}
