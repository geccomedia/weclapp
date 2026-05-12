<?php

namespace Geccomedia\Weclapp\Tests\Swagger;

use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * Verifies that every array-typed swagger property whose items carry a $ref
 * (i.e. a collection of sub-objects) has a corresponding SubModel cast entry
 * in the model's $casts array.
 *
 * The swagger spec distinguishes two kinds of array properties:
 *
 *   1. Primitive arrays  – items.type is "string" / "integer" / etc.
 *      These should NOT have a cast (they are left as plain PHP arrays).
 *
 *   2. Sub-object arrays – items.$ref points to another definition.
 *      These MUST be cast to the corresponding SubModel class so that callers
 *      receive typed SubModel instances rather than raw associative arrays.
 *
 * A missing cast entry means the property is returned as a plain array instead
 * of a typed SubModel collection, breaking @property type hints and SubModel
 * helper methods.
 *
 * Models whose swagger definition cannot be inferred automatically (Meta, the
 * shared-definition groups) are skipped because they have no $ref-bearing
 * array properties in practice.
 */
class CastCoverageTest extends TestCase
{
    /**
     * Models that have no swagger definition of their own and should be skipped.
     *
     * @var list<string>
     */
    private const SKIP_MODELS = [
        'Meta', // no swagger definition
    ];

    /**
     * Models whose swagger definition cannot be inferred from lcfirst(ClassName)
     * or getTable(). Key = short class name, value = definition name.
     *
     * Must stay in sync with SwaggerModelTest::DEFINITION_OVERRIDES.
     *
     * @var array<string, string>
     */
    private const DEFINITION_OVERRIDES = [
        'ShipmentReturnAssessment' => 'shipmentReturnDescription',
        'ShipmentReturnError' => 'shipmentReturnDescription',
        'ShipmentReturnReason' => 'shipmentReturnDescription',
        'ShipmentReturnRectification' => 'shipmentReturnDescription',
        'ArticleAccountingCode' => 'customValue',
        'ArticleCategoryClassification' => 'customValue',
        'ArticleRating' => 'customValue',
        'ArticleStatus' => 'customValue',
        'CompanySize' => 'customValue',
        'ContractBillingGroup' => 'customValue',
        'ContractTerminationReason' => 'customValue',
        'CostCenterGroup' => 'customValue',
        'CrmCallCategory' => 'customValue',
        'CrmEventCategory' => 'customValue',
        'CustomerCategory' => 'customValue',
        'CustomerLeadLossReason' => 'customValue',
        'CustomerTopic' => 'customValue',
        'CustomsTariffNumber' => 'customValue',
        'LeadRating' => 'customValue',
        'LeadSource' => 'customValue',
        'LegalForm' => 'customValue',
        'OpportunityTopic' => 'customValue',
        'OpportunityWinLossReason' => 'customValue',
        'PartyRating' => 'customValue',
        'PersonDepartment' => 'customValue',
        'PersonRole' => 'customValue',
        'PersonalAccountingCode' => 'customValue',
        'PickCheckReason' => 'customValue',
        'PlaceOfService' => 'customValue',
        'Sector' => 'customValue',
        'StoragePlaceBlockingReason' => 'customValue',
        'TicketChannel' => 'customValue',
        'Title' => 'customValue',
    ];

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /**
     * Returns the swagger definition name for a model class.
     * Follows the same priority order as SwaggerModelTest::definitionFor().
     */
    private static function definitionFor(string $shortName): string
    {
        if (isset(self::DEFINITION_OVERRIDES[$shortName])) {
            return self::DEFINITION_OVERRIDES[$shortName];
        }

        return Spec::rootFor($shortName);
    }

    /**
     * Returns the $casts array resolved from the model's full inheritance chain.
     * Entries declared on a parent class are included so that Party subtypes
     * (Customer, Contact, etc.) inherit their parent's casts.
     *
     * @return array<string, string> property => cast class-string
     */
    private static function resolvedCasts(string $fqcn): array
    {
        $casts = [];
        $rc = new ReflectionClass($fqcn);

        do {
            if ($rc->isAbstract()) {
                break; // The abstract base Model class can't be instantiated.
            }

            if ($rc->hasProperty('casts')) {
                $prop = $rc->getProperty('casts');
                $value = $prop->getValue($rc->newInstanceWithoutConstructor());
                // Lower-priority parent entries don't overwrite child entries.
                $casts = array_merge((array) $value, $casts);
            }
        } while ($rc = $rc->getParentClass());

        return $casts;
    }

    // -------------------------------------------------------------------------
    // Test
    // -------------------------------------------------------------------------

    /**
     * Every $ref-backed array property in a swagger definition must have a
     * matching $casts entry on the corresponding model class.
     */
    public function test_every_ref_array_property_has_a_submodel_cast(): void
    {
        $definitions = Spec::definitions();
        $missing = [];

        foreach (Spec::modelShortNames() as $short) {
            if (in_array($short, self::SKIP_MODELS, true)) {
                continue;
            }

            // Party subtypes share the 'party' definition; check via Party only.
            if (isset(Spec::TABLE_OVERRIDES[$short]) && $short !== 'Party') {
                continue;
            }

            $defName = self::definitionFor($short);

            // Skip if the definition doesn't exist in the spec.
            if (! isset($definitions[$defName])) {
                continue;
            }

            $properties = $definitions[$defName]['properties'] ?? [];
            $fqcn = Spec::MODEL_NS.$short;
            $casts = self::resolvedCasts($fqcn);

            foreach ($properties as $propName => $propDef) {
                // Only care about array properties whose items are $ref-backed.
                if (($propDef['type'] ?? '') !== 'array') {
                    continue;
                }

                $items = $propDef['items'] ?? [];
                if (! isset($items['$ref'])) {
                    continue; // Primitive array — no cast needed.
                }

                if (! isset($casts[$propName])) {
                    $refName = basename(str_replace('\\', '/', $items['$ref']));
                    $missing[] = sprintf(
                        '%s::$casts[\'%s\'] is missing  (swagger ref: %s)',
                        $fqcn,
                        $propName,
                        $refName
                    );
                }
            }
        }

        $this->assertEmpty(
            $missing,
            count($missing)." model property/properties lack a SubModel cast:\n  "
            .implode("\n  ", $missing)
        );
    }
}
