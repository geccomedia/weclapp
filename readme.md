# Laravel Weclapp

This repo implements most of the Laravel Eloquent Model for the Weclapp web api.

## Installation Informations

Require this package with Composer

```
composer require geccomedia/weclapp
```

Add the variables to your .env

```
WECLAPP_BASE_URL=https://#your-sub-domain#.weclapp.com/webapp/api/v1/
WECLAPP_API_KEY=your-key
```

## Usage

Use existing models from "Geccomedia\Weclapp\Models"-Namespace.

Most Eloquent methods are implemented within the limitations of the web api.
```
<?php

use Geccomedia\Weclapp\Models\Customer;

class YourClass
{
    public function yourFunction()
    {
        $customer = Customer::where('company', 'Your Company Name')
            ->firstOrFail();
```

## Custom models

Example:
```
<?php namespace Your\Custom\Namespace;

use Geccomedia\Weclapp\WeclappModel;

class CustomModel extends WeclappModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'custom-api-route';
}
```