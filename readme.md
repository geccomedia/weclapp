# Laravel Weclapp

[![Latest Stable Version](https://poser.pugx.org/geccomedia/weclapp/v/stable)](https://packagist.org/packages/geccomedia/weclapp) [![Total Downloads](https://poser.pugx.org/geccomedia/weclapp/downloads)](https://packagist.org/packages/geccomedia/weclapp) [![License](https://poser.pugx.org/geccomedia/weclapp/license)](https://packagist.org/packages/geccomedia/weclapp)

This repo implements most of the Laravel Eloquent Model for the Weclapp web api.

## Contents

- [Installation](#installation)
- [Usage](#usage)
- [Available Models](#available-models)
- [Custom Models](#custom-models)
- [Mass Assignments](#mass-assignments)
- [Relations](#relations)
  - [Eager loading](#eager-loading-recommended--single-batched-request)
  - [Lazy loading](#lazy-loading-n1)
  - [Inverse relations](#inverse-relations-hasmany)
- [Additional Properties](#additional-properties)
- [Custom Actions](#custom-actions)
  - [Collection-level actions](#collection-level-actions)
  - [Instance-level actions](#instance-level-actions)
- [Read-only Models](#read-only-models)
- [Embedded Sub-Objects](#embedded-sub-objects)
- [Sub Entities](#sub-entities)
- [Logging](#logging)
- [Party-type Models](#party-type-models)
  - [leadStatus values](#leadstatus-values)
- [Boolean Filters](#boolean-filters)
- [License & Copyright](#license--copyright)
- [Known Gaps / Future Work](#known-gaps--future-work)
  - [1. Utility path roots](#1-utility-path-roots-without-model-classes)
  - [2. Plain string\[\] fields](#2-plain-string-fields-not-in-casts)

## Installation

Require this package with Composer

```
composer require geccomedia/weclapp
```

Add the variables to your `.env`:

```
WECLAPP_BASE_URL=https://your-subdomain.weclapp.com/webapp/api/v1/
WECLAPP_API_KEY=your-key
```

## Usage

Use existing models from the `Geccomedia\Weclapp\Models` namespace.

Most Eloquent methods are implemented within the limitations of the web API.

```php
<?php

use Geccomedia\Weclapp\Models\Customer;

$customer = Customer::where('company', 'Your Company Name')
    ->firstOrFail();
```

## Available Models

Over 150 models are provided, covering all queryable Weclapp API endpoints —
including `SalesOrder`, `Customer`, `Article`, `Shipment`, `PurchaseOrder`,
`Invoice`, `Ticket`, and many more. Every model has full `@property` annotations
for IDE autocompletion.

## Custom Models

The API route is derived automatically from the class name using `lcfirst(ClassName)`,
so `SalesOrder` maps to `salesOrder`, `Article` maps to `article`, etc. You only need to
declare `$table` when your class name does not match the API route:

```php
<?php namespace Your\Custom\Namespace;

use Geccomedia\Weclapp\Model;

class MyOrder extends Model
{
    /**
     * Override only when the class name doesn't match the API route.
     *
     * @var string
     */
    protected $table = 'salesOrder';
}
```

## Mass Assignments

If you want to do mass assignment please use [unguard](https://laravel.com/docs/eloquent#mass-assignment) and reguard:

```php
$customer = new \Geccomedia\Weclapp\Models\Customer();
\Geccomedia\Weclapp\Models\Customer::unguard();
$customer->fill(['partyType' => 'ORGANIZATION']);
\Geccomedia\Weclapp\Models\Customer::reguard();
```

## Relations

Models declare `belongsTo` and `hasMany` relationships using Weclapp's
camelCase foreign key convention (e.g. `customerId`, not `customer_id`).

### Eager loading (recommended — single batched request)

Use `with()` to load related models in one extra request instead of one per record:

```php
// 2 HTTP requests total: one for orders, one batched party lookup
$orders = SalesOrder::with('customer')->get();

foreach ($orders as $order) {
    echo $order->customer->company;
}
```

### Lazy loading (N+1)

Without `with()`, each relation access fires its own HTTP request:

```php
$orders = SalesOrder::get();         // 1 request

foreach ($orders as $order) {
    echo $order->customer->company;  // 1 request per order
}
```

### Inverse relations (hasMany)

Common inverse relations are defined, so you can traverse from either side:

```php
$customer = Customer::find('1');

$customer->salesOrders()->get();   // GET /salesOrder?customerId-eq=1
$customer->shipments()->get();     // GET /shipment?customerId-eq=1
$customer->quotations()->get();    // GET /quotation?customerId-eq=1
$customer->salesInvoices()->get(); // GET /salesInvoice?customerId-eq=1

$warehouse->warehouseStock()->get();     // GET /warehouseStock?warehouseId-eq=1
$salesOrder->shipments()->get();         // GET /shipment?salesOrderId-eq=1
$salesOrder->salesInvoices()->get();     // GET /salesInvoice?salesOrderId-eq=1
$article->articlePrices()->get();        // GET /articlePrice?articleId-eq=1
$supplier->purchaseOrders()->get();      // GET /purchaseOrder?supplierId-eq=1
```

## Additional Properties

Weclapp can return extra computed fields that are not included by default.
Request them with `withProperties()`:

```php
// Includes the orderItems and tags fields in the response
$orders = SalesOrder::withProperties('orderItems', 'tags')->get();
// → GET /salesOrder?additionalProperties=orderItems,tags
```

This can be combined with `select()` and other query methods:

```php
SalesOrder::select('id', 'orderNumber')
    ->withProperties('orderItems')
    ->where('status', 'ORDER_ENTRY_IN_PROGRESS')
    ->get();
```

## Custom Actions

Weclapp exposes many action endpoints beyond standard CRUD. Call them via
`action()` at the class level or `callAction()` on a model instance.

### Collection-level actions

```php
// POST /salesOrder/defaultValuesForCreate
$defaults = SalesOrder::action('defaultValuesForCreate');

// POST /tax/configureSalesTaxes  {"taxRateType": "STANDARD"}
Tax::action('configureSalesTaxes', ['taxRateType' => 'STANDARD']);
```

### Instance-level actions

```php
$order = SalesOrder::find('123');

// POST /salesOrder/id/123/createShipment
$order->newQuery()->callAction('createShipment');

// POST /salesOrder/id/123/createSalesInvoice  {"invoiceDate": 1234567890000}
$order->newQuery()->callAction('createSalesInvoice', ['invoiceDate' => 1234567890000]);

// POST /quotation/id/456/accept
$quotation->newQuery()->callAction('accept');
```

All actions return the decoded JSON response body as an array, or `null` if
the response has no body.

## Read-only Models

Some Weclapp endpoints are read-only (no create or delete). Attempting to
`save()` a new instance or `delete()` an existing one on these models will
throw a `NotSupportedException` immediately, without making an HTTP request.

Non-creatable models (no `POST`):
`AccountingTransaction`, `ArchivedEmail`, `BankTransaction`, `BlanketSalesOrder`,
`CommercialLanguage`, `ContractAuthorizationUnit`, `Document`, `ExternalConnection`,
`FulfillmentProvider`, `InventoryGroup`, `Notification`, `NumberRange`,
`NumberRangeValue`, `PaymentRun`, `Pick`, `PurchaseOpenItem`, `PurchaseRequisition`,
`SalesOpenItem`, `ServiceQuota`, `VariantArticleVariant`, `WarehouseStock`,
`WarehouseStockMovement`.

Non-deletable models (no `DELETE`):
`CashAccount`, `InventoryTransportReference`, `SerialNumber`,
`User`, `WarehouseStock`, `WarehouseStockMovement`.

## Embedded Sub-Objects

Weclapp embeds related data directly in API responses rather than using
separate endpoints. These are automatically hydrated into typed `SubModel`
value objects on read.

```php
$order = SalesOrder::find('123');

// Object-style access (new)
echo $order->orderItems[0]->articleId;
echo $order->recordAddress->city;

// Array-style access (still works — SubModel implements ArrayAccess)
echo $order->orderItems[0]['articleId'];
```

`toArray()` and `toJson()` always return plain nested arrays, so serialisation
and API writes are unaffected.

## Sub Entities

Weclapp treats some models as sub-entities that belong to a parent. For these,
supply the parent entity with `whereEntity($name, $id)`:

```php
$comments = Comment::whereEntity('customer', 123)->orderBy('id')->get();
```

Without the call to `whereEntity` the API will return an error.
See [#22](https://github.com/geccomedia/weclapp/issues/22) for more information.

## Logging

To inspect the HTTP requests being made, enable the connection query log:

```php
use Geccomedia\Weclapp\Connection;

app(Connection::class)->enableQueryLog();

\Geccomedia\Weclapp\Models\Customer::create(['name' => 'Test']);

app(Connection::class)->getQueryLog();
```

## Party-type Models

Weclapp stores customers, suppliers, leads, and contacts all as records in the
single `/party` endpoint, differentiated by boolean role flags and a `leadStatus`
field. The four convenience model classes each apply a global query scope so
they automatically filter to the right subset:

| Class | Route | Filter applied |
|---|---|---|
| `Customer` | `/party` | `customer = true` |
| `Supplier` | `/party` | `supplier = true` |
| `Lead` | `/party` | `leadStatus` is set and not `CONVERTED` |
| `Contact` | `/party` | `partyType = PERSON` |

The scopes are transparent — any extra `where()` clauses stack alongside them:

```php
// GET /party?customer-eq=true&company-eq=Acme&pageSize=100
$customers = Customer::where('company', 'Acme')->get();

// GET /party?supplier-eq=true&pageSize=100
$suppliers = Supplier::all();

// GET /party?leadStatus-notnull=&leadStatus-ne=CONVERTED&pageSize=100
$leads = Lead::all();

// GET /party?partyType-eq=PERSON&pageSize=100
$contacts = Contact::all();
```

A single weclapp party can carry multiple roles simultaneously (e.g.
`customer = true` and `supplier = true`). `Party::all()` returns every party
record unfiltered when you need to query across roles.

### leadStatus values

| Value | Meaning |
|---|---|
| `NEW` | Just entered the funnel |
| `PREQUALIFIED` | Initial screening done |
| `QUALIFIED` | Sales-ready |
| `CONVERTED` | Graduated to a customer — excluded from `Lead`, appears under `Customer` |
| `DISQUALIFIED` | Rejected from funnel |

## Boolean Filters

PHP `true` and `false` values passed to `where()` or `whereIn()` are
automatically serialised to the strings `"true"` and `"false"` that the
weclapp API expects:

```php
// GET /party?customer-eq=true&...
Customer::where('customer', true)->get();

// GET /party?customerBlocked-eq=false&...
Customer::where('customerBlocked', false)->get();

// GET /article?active-in=["true","false"]&...
Article::whereIn('active', [true, false])->get();
```

## License & Copyright

Copyright © 2017–2026 Gecco Media GmbH

[License](LICENSE)

---

## Known Gaps / Future Work

This section documents remaining coverage gaps for future contributors.

### 1. Utility path roots without model classes

Two swagger path roots have no dedicated model class because they expose
only utility/action endpoints (no CRUD). The `Builder` `action()` helper
cannot be used for these because it requires a model's table name as the path
root. Call them directly through the `Connection` instead.

#### `system` endpoints

```php
use GuzzleHttp\Psr7\Request;
use Geccomedia\Weclapp\Connection;

$connection = app(Connection::class);

// GET /system/permissions → string[]
// Returns the list of permission slugs granted to the current API key.
$permissions = $connection->select(new Request('GET', 'system/permissions'));
// e.g. ['party:read', 'salesOrder:read', 'salesOrder:write', ...]

// GET /system/licenses → array of {name: string, permissions: string[]}
// Returns the active licence modules and their included permissions.
$licenses = $connection->select(new Request('GET', 'system/licenses'));
// e.g. [['name' => 'SALES', 'permissions' => ['salesOrder:read', ...]], ...]

// GET /system/demoTestSystemInfo → {createPossible, creationInProgress, demoInstanceUrl, mainInstanceUrl}
// Check whether a demo instance can be created from this tenant.
$info = $connection->action(new Request('GET', 'system/demoTestSystemInfo'));
$demoInfo = $info['result'] ?? null;
// e.g. ['createPossible' => true, 'creationInProgress' => false, 'demoInstanceUrl' => null, ...]

// POST /system/createDemoTestSystem  — creates a demo copy of this tenant
$connection->action(new Request(
    'POST',
    'system/createDemoTestSystem',
    [],
    json_encode(['label' => 'My Test System', 'preset' => 'PROD_SYSTEM'])
));
```

#### `job` endpoints

Weclapp runs long-running background jobs (imports, mass-operations, syncs,
etc.) asynchronously. You can poll or abort them by `type`.

```php
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use Geccomedia\Weclapp\Connection;

$connection = app(Connection::class);

// GET /job/status?type=INVENTORY_BOOKING
// Returns the current status and progress of the named background job.
$statusResult = $connection->action(
    new Request('GET', (string) Uri::withQueryValues(
        new Uri('job/status'),
        ['type' => 'INVENTORY_BOOKING']
    ))
);
$status = $statusResult['result'] ?? null;
// e.g. ['status' => 'EXECUTING', 'progress' => ['current' => 42, 'total' => 100], 'type' => 'INVENTORY_BOOKING']

// GET /job/abort?type=INVENTORY_BOOKING
// Requests cancellation of a running job.
$connection->action(
    new Request('GET', (string) Uri::withQueryValues(
        new Uri('job/abort'),
        ['type' => 'INVENTORY_BOOKING']
    ))
);
```

All valid `type` values are the `SCREAMING_SNAKE_CASE` job names listed in the
swagger `jobResult` definition (e.g. `INVENTORY_BOOKING`, `MATERIAL_PLANNING_RUN`,
`MASS_SHIPMENT_CREATION`, `ACCOUNTING_EXPORT`, …).

### 2. Plain `string[]` fields not in `$casts`

The following fields are plain arrays of strings (not SubModel objects), so
they have no cast and arrive as raw `array|null`. This is correct behaviour;
they are documented here for clarity:

- `tags` — present on `SalesOrder`, `Quotation`, `Shipment`, `PurchaseOrder`,
  `SalesInvoice`, `Party`, `Customer`, `Contact`, `Lead`, `Supplier`, and others
- `availableForSalesChannels` — present on `Article`
