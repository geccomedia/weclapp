<?php

namespace Geccomedia\Weclapp\Tests\Swagger;

use GuzzleHttp\Client;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * Verifies that every property declared in a top-level swagger definition at
 * https://www.weclapp.com/api/swagger.json is also declared as a "@property"
 * annotation on the corresponding model class.
 *
 * Model → definition mapping is inferred automatically:
 *   - The swagger definition name is lcfirst($className) in almost all cases.
 *   - Models that override $table (Customer, Contact, Lead, Supplier → "party")
 *     are detected automatically by reading the model's getTable() value.
 *   - Models whose class name has no matching swagger definition but share one
 *     (ShipmentReturn* → "shipmentReturnDescription"; lookup-table models →
 *     "customValue") are declared in DEFINITION_OVERRIDES below.
 *   - Meta has no swagger definition and is skipped via SKIP_MODELS.
 */
class ModelTest extends TestCase
{
    private const MODEL_NS = 'Geccomedia\\Weclapp\\Models\\';

    /**
     * Models that have no swagger definition of their own and should be skipped.
     * Key = short class name.
     *
     * @var list<string>
     */
    private const SKIP_MODELS = [
        'Meta', // no swagger definition
    ];

    /**
     * Explicit overrides for models whose swagger definition cannot be inferred
     * from lcfirst(ClassName) or getTable(). Key = short class name, value = definition.
     *
     * @var array<string, string>
     */
    private const DEFINITION_OVERRIDES = [
        // Four ShipmentReturn* classes share a single definition.
        'ShipmentReturnAssessment' => 'shipmentReturnDescription',
        'ShipmentReturnError' => 'shipmentReturnDescription',
        'ShipmentReturnReason' => 'shipmentReturnDescription',
        'ShipmentReturnRectification' => 'shipmentReturnDescription',
        // Lookup-table classes share the "customValue" definition.
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

    /** @var array<string, list<string>>|null */
    private static ?array $definitions = null;

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /**
     * Fetches the swagger spec once and returns definitionName -> propertyNames[].
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

        return self::$definitions;
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
     * Infers the swagger definition name for a model class:
     *   1. Explicit override wins.
     *   2. getTable() if different from lcfirst(ClassName).
     *   3. lcfirst(ClassName).
     */
    private static function definitionFor(string $shortName): string
    {
        if (isset(self::DEFINITION_OVERRIDES[$shortName])) {
            return self::DEFINITION_OVERRIDES[$shortName];
        }

        $fqcn = self::MODEL_NS.$shortName;
        $table = (new ReflectionClass($fqcn))->newInstanceWithoutConstructor()->getTable();

        return $table !== lcfirst($shortName) ? $table : lcfirst($shortName);
    }

    // -------------------------------------------------------------------------
    // Data provider
    // -------------------------------------------------------------------------

    /**
     * Yields [shortName, fqcn, definitionName] for every non-abstract model on disk.
     *
     * @return array<string, array{string, string, string}>
     */
    public static function modelDefinitionPairs(): array
    {
        $cases = [];

        foreach (glob(__DIR__.'/../src/Models/*.php') ?: [] as $file) {
            $shortName = basename($file, '.php');

            if (in_array($shortName, self::SKIP_MODELS, true)) {
                continue;
            }

            $fqcn = self::MODEL_NS.$shortName;
            if (! class_exists($fqcn) || (new ReflectionClass($fqcn))->isAbstract()) {
                continue;
            }

            $definition = self::definitionFor($shortName);
            $cases[$shortName] = [$shortName, $fqcn, $definition];
        }

        return $cases;
    }

    // -------------------------------------------------------------------------
    // Tests
    // -------------------------------------------------------------------------

    /**
     * Every model on disk must map to a swagger definition that actually exists.
     * This catches any new models added without a corresponding spec entry.
     */
    public function test_every_model_maps_to_an_existing_swagger_definition(): void
    {
        $definitions = self::definitions();
        $missing = [];

        foreach (self::modelDefinitionPairs() as $shortName => [$_, $fqcn, $definition]) {
            if (! isset($definitions[$definition])) {
                $missing[] = "{$shortName} → '{$definition}' (not found in swagger)";
            }
        }

        $this->assertEmpty(
            $missing,
            sprintf(
                "%d model(s) map to a swagger definition that does not exist:\n  - %s",
                count($missing),
                implode("\n  - ", $missing),
            )
        );
    }

    /**
     * Every property of a swagger definition must be declared as @property
     * on the corresponding model class.
     */
    #[DataProvider('modelDefinitionPairs')]
    public function test_model_declares_all_swagger_properties(
        string $shortName,
        string $fqcn,
        string $definitionName
    ): void {
        $definitions = self::definitions();

        $this->assertArrayHasKey(
            $definitionName,
            $definitions,
            "Swagger definition '{$definitionName}' (for {$shortName}) does not exist in the spec."
        );

        $missing = array_values(array_diff($definitions[$definitionName], self::modelProperties($fqcn)));

        $this->assertEmpty(
            $missing,
            sprintf(
                "%s is missing %d @property annotation(s) from the '%s' swagger definition:\n  - %s",
                $fqcn,
                count($missing),
                $definitionName,
                implode("\n  - ", $missing),
            )
        );
    }
}
