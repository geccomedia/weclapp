<?php namespace Geccomedia\Weclapp;

use GuzzleHttp\Client as BaseClient;

class Client extends BaseClient
{
    public function __construct(array $config = [])
    {
        $weclapp_config = [
            'base_uri' => config('accounting.weclapp.base_url'),
            'headers' => [
                'AuthenticationToken' => config('accounting.weclapp.api_key'),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ]
        ];
        $config = array_merge($config, $weclapp_config);
        parent::__construct($config);
    }
}