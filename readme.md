# Laravel Weclapp

[![Latest Stable Version](https://poser.pugx.org/geccomedia/weclapp/v/stable)](https://packagist.org/packages/geccomedia/weclapp) [![Total Downloads](https://poser.pugx.org/geccomedia/weclapp/downloads)](https://packagist.org/packages/geccomedia/weclapp) [![License](https://poser.pugx.org/geccomedia/weclapp/license)](https://packagist.org/packages/geccomedia/weclapp)

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

use Geccomedia\Weclapp\Model;

class CustomModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'custom-api-route';
}
```

## License & Copyright

Copyright (c) 2017 Gecco Media GmbH

[License](LICENSE)