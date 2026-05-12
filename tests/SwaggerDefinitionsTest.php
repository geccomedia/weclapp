<?php

namespace Geccomedia\Weclapp\Tests;

use Geccomedia\Weclapp\Models\ArchivedEmail;
use Geccomedia\Weclapp\Models\Article;
use Geccomedia\Weclapp\Models\ArticleCategory;
use Geccomedia\Weclapp\Models\ArticlePrice;
use Geccomedia\Weclapp\Models\ArticleSupplySource;
use Geccomedia\Weclapp\Models\BatchNumber;
use Geccomedia\Weclapp\Models\Campaign;
use Geccomedia\Weclapp\Models\CampaignParticipant;
use Geccomedia\Weclapp\Models\Comment;
use Geccomedia\Weclapp\Models\CommercialLanguage;
use Geccomedia\Weclapp\Models\CompanySize;
use Geccomedia\Weclapp\Models\Contact;
use Geccomedia\Weclapp\Models\Currency;
use Geccomedia\Weclapp\Models\CustomAttributeDefinition;
use Geccomedia\Weclapp\Models\Customer;
use Geccomedia\Weclapp\Models\CustomerCategory;
use Geccomedia\Weclapp\Models\CustomerLeadLossReason;
use Geccomedia\Weclapp\Models\CustomerTopic;
use Geccomedia\Weclapp\Models\CustomsTariffNumber;
use Geccomedia\Weclapp\Models\Document;
use Geccomedia\Weclapp\Models\FulfillmentProvider;
use Geccomedia\Weclapp\Models\IncomingGoods;
use Geccomedia\Weclapp\Models\Lead;
use Geccomedia\Weclapp\Models\LeadSource;
use Geccomedia\Weclapp\Models\Manufacturer;
use Geccomedia\Weclapp\Models\Opportunity;
use Geccomedia\Weclapp\Models\OpportunityWinLossReason;
use Geccomedia\Weclapp\Models\Party;
use Geccomedia\Weclapp\Models\PaymentMethod;
use Geccomedia\Weclapp\Models\ProductionOrder;
use Geccomedia\Weclapp\Models\PurchaseOrder;
use Geccomedia\Weclapp\Models\Quotation;
use Geccomedia\Weclapp\Models\SalesChannel;
use Geccomedia\Weclapp\Models\SalesInvoice;
use Geccomedia\Weclapp\Models\SalesOrder;
use Geccomedia\Weclapp\Models\SalesStage;
use Geccomedia\Weclapp\Models\Sector;
use Geccomedia\Weclapp\Models\SerialNumber;
use Geccomedia\Weclapp\Models\Shipment;
use Geccomedia\Weclapp\Models\ShipmentMethod;
use Geccomedia\Weclapp\Models\Supplier;
use Geccomedia\Weclapp\Models\Tax;
use Geccomedia\Weclapp\Models\TermOfPayment;
use Geccomedia\Weclapp\Models\Unit;
use Geccomedia\Weclapp\Models\User;
use Geccomedia\Weclapp\Models\VariantArticle;
use Geccomedia\Weclapp\Models\VariantArticleAttribute;
use Geccomedia\Weclapp\Models\VariantArticleVariant;
use Geccomedia\Weclapp\Models\Warehouse;
use Geccomedia\Weclapp\Models\WarehouseStock;
use Geccomedia\Weclapp\Models\WarehouseStockMovement;
use GuzzleHttp\Client;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * Verifies that every property declared in a swagger definition at
 * https://www.weclapp.com/api/swagger.json is also declared as a
 *
 * @property annotation on the corresponding model class.
 */
class SwaggerDefinitionsTest extends TestCase
{
    /**
     * Maps swagger definition name -> model FQCN.
     *
     * Notes:
     * - customer / contact / lead / supplier have no dedicated swagger definition;
     *   they all map to the "party" definition.
     * - Simple lookup-table endpoints (companySize, customerCategory, …) all map
     *   to "customValue" in swagger; each such model is tested individually below.
     */
    private const DEFINITION_TO_MODELS = [
        'archivedEmail' => [ArchivedEmail::class],
        'article' => [Article::class],
        'articleCategory' => [ArticleCategory::class],
        'articlePrice' => [ArticlePrice::class],
        'articleSupplySource' => [ArticleSupplySource::class],
        'batchNumber' => [BatchNumber::class],
        'campaign' => [Campaign::class],
        'campaignParticipant' => [CampaignParticipant::class],
        'comment' => [Comment::class],
        'commercialLanguage' => [CommercialLanguage::class],
        'currency' => [Currency::class],
        'customAttributeDefinition' => [CustomAttributeDefinition::class],
        'document' => [Document::class],
        'fulfillmentProvider' => [FulfillmentProvider::class],
        'incomingGoods' => [IncomingGoods::class],
        'manufacturer' => [Manufacturer::class],
        'opportunity' => [Opportunity::class],
        'paymentMethod' => [PaymentMethod::class],
        'productionOrder' => [ProductionOrder::class],
        'purchaseOrder' => [PurchaseOrder::class],
        'quotation' => [Quotation::class],
        'salesChannel' => [SalesChannel::class],
        'salesInvoice' => [SalesInvoice::class],
        'salesOrder' => [SalesOrder::class],
        'salesStage' => [SalesStage::class],
        'serialNumber' => [SerialNumber::class],
        'shipment' => [Shipment::class],
        'shipmentMethod' => [ShipmentMethod::class],
        'tax' => [Tax::class],
        'termOfPayment' => [TermOfPayment::class],
        'unit' => [Unit::class],
        'user' => [User::class],
        'variantArticle' => [VariantArticle::class],
        'variantArticleAttribute' => [VariantArticleAttribute::class],
        'variantArticleVariant' => [VariantArticleVariant::class],
        'warehouse' => [Warehouse::class],
        'warehouseStock' => [WarehouseStock::class],
        'warehouseStockMovement' => [WarehouseStockMovement::class],
        // Several distinct model classes share the single "party" swagger definition.
        'party' => [
            Party::class,
            Customer::class,
            Contact::class,
            Lead::class,
            Supplier::class,
        ],
        // Simple lookup-table models all share the "customValue" swagger definition.
        'customValue' => [
            CompanySize::class,
            CustomerCategory::class,
            CustomerLeadLossReason::class,
            CustomerTopic::class,
            CustomsTariffNumber::class,
            LeadSource::class,
            OpportunityWinLossReason::class,
            Sector::class,
        ],
    ];

    /** @var array<string, list<string>>|null Cached definitions map: definitionName -> propertyNames */
    private static ?array $definitions = null;

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /**
     * Fetches https://www.weclapp.com/api/swagger.json once per test run and
     * returns a map of  definitionName -> list<propertyName>.
     *
     * @return array<string, list<string>>
     */
    private static function definitions(): array
    {
        if (self::$definitions !== null) {
            return self::$definitions;
        }

        $client = new Client(['timeout' => 30]);
        $response = $client->get('https://www.weclapp.com/api/swagger.json');
        $swagger = json_decode((string) $response->getBody(), true, flags: JSON_THROW_ON_ERROR);

        self::$definitions = [];
        foreach ($swagger['definitions'] as $name => $definition) {
            self::$definitions[$name] = array_keys($definition['properties'] ?? []);
        }

        return self::$definitions;
    }

    /**
     * Returns all @property names declared in the docblock of the given class
     * and every class in its inheritance chain.
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
                preg_match_all('/@property[^$]*\$(\w+)/', $doc, $matches);
                array_push($props, ...$matches[1]);
            }
        } while ($rc = $rc->getParentClass());

        return array_values(array_unique($props));
    }

    // -------------------------------------------------------------------------
    // Data provider
    // -------------------------------------------------------------------------

    /**
     * Yields one [definitionName, modelFqcn] row per (definition × model) pair.
     *
     * @return array<string, array{string, string}>
     */
    public static function definitionModelPairs(): array
    {
        $cases = [];

        foreach (self::DEFINITION_TO_MODELS as $definition => $models) {
            foreach ($models as $fqcn) {
                $shortName = (new ReflectionClass($fqcn))->getShortName();
                $key = count($models) > 1 ? "{$definition}:{$shortName}" : $definition;
                $cases[$key] = [$definition, $fqcn];
            }
        }

        return $cases;
    }

    // -------------------------------------------------------------------------
    // Tests
    // -------------------------------------------------------------------------

    /**
     * Every definition in the swagger spec that matches a model's $table name
     * must be listed in DEFINITION_TO_MODELS so it actually gets tested.
     */
    public function test_all_matching_swagger_definitions_are_covered(): void
    {
        $definitions = self::definitions();

        // Build a table-name -> FQCN map from the actual model files on disk.
        $modelTables = [];
        foreach (glob(__DIR__.'/../src/Models/*.php') ?: [] as $file) {
            $fqcn = 'Geccomedia\\Weclapp\\Models\\'.basename($file, '.php');
            if (class_exists($fqcn)) {
                $rc = new ReflectionClass($fqcn);
                if (! $rc->isAbstract()) {
                    $prop = $rc->getProperty('table');
                    $table = $prop->getValue($rc->newInstanceWithoutConstructor());
                    $modelTables[$table] = $fqcn;
                }
            }
        }

        $coveredDefinitions = array_keys(self::DEFINITION_TO_MODELS);

        foreach (array_keys($definitions) as $definitionName) {
            if (isset($modelTables[$definitionName]) && ! in_array($definitionName, $coveredDefinitions, true)) {
                $this->fail(
                    "Swagger definition '{$definitionName}' has a matching model "
                    ."({$modelTables[$definitionName]}) but is not listed in DEFINITION_TO_MODELS."
                );
            }
        }

        $this->addToAssertionCount(1);
    }

    /**
     * Every property of a swagger definition must be declared as @property on
     * the corresponding model class.
     */
    #[DataProvider('definitionModelPairs')]
    public function test_model_declares_all_swagger_properties(string $definitionName, string $fqcn): void
    {
        $definitions = self::definitions();

        $this->assertArrayHasKey(
            $definitionName,
            $definitions,
            "Swagger definition '{$definitionName}' does not exist in the spec."
        );

        $swaggerProps = $definitions[$definitionName];
        $modelProps = self::modelProperties($fqcn);

        $missing = array_values(array_diff($swaggerProps, $modelProps));

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
