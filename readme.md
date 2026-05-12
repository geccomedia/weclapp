# Laravel Weclapp

[![Latest Stable Version](https://poser.pugx.org/geccomedia/weclapp/v/stable)](https://packagist.org/packages/geccomedia/weclapp) [![Total Downloads](https://poser.pugx.org/geccomedia/weclapp/downloads)](https://packagist.org/packages/geccomedia/weclapp) [![License](https://poser.pugx.org/geccomedia/weclapp/license)](https://packagist.org/packages/geccomedia/weclapp)

This repo implements most of the Laravel Eloquent Model for the Weclapp web api.

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
so `SalesOrder` maps to `salesOrder`, `Customer` to `customer`, etc. You only need to
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

Models declare `belongsTo` relationships using Weclapp's camelCase foreign key
convention (e.g. `customerId`, not `customer_id`).

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

## License & Copyright

Copyright © 2017–2026 Gecco Media GmbH

[License](LICENSE)
