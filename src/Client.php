<?php

namespace Geccomedia\Weclapp;

use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Client
{
    private GuzzleClient $http;

    public function __construct(array $config = [])
    {
        $weclapp_config = [
            'base_uri' => config('accounting.weclapp.base_url'),
            'headers' => [
                'AuthenticationToken' => config('accounting.weclapp.api_key'),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ];
        $config = array_merge($config, $weclapp_config);
        $this->http = new GuzzleClient($config);
    }

    public function send(RequestInterface $request, array $options = []): ResponseInterface
    {
        return $this->http->send($request, $options);
    }
}
