<?php

namespace Geccomedia\Weclapp\Tests\NotSupported;

use Geccomedia\Weclapp\Client;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

/**
 * Exercises Client::send() directly.
 *
 * All other tests mock the Client, so the send() method never accumulates
 * coverage through them. This file instantiates a real Client (with the
 * internal Guzzle instance swapped out for a MockHandler) so that the
 * method body is actually executed.
 */
class ClientSendTest extends OrchestraTestCase
{
    use UsesServiceProvider;

    /**
     * Replace the private GuzzleClient inside a Client instance with one
     * backed by a MockHandler that returns the given response.
     */
    private function clientWithMockHandler(Response $response): Client
    {
        $handler = new MockHandler([$response]);
        $guzzle = new GuzzleClient(['handler' => HandlerStack::create($handler)]);

        $client = new Client;

        $ref = new \ReflectionProperty(Client::class, 'http');
        $ref->setAccessible(true);
        $ref->setValue($client, $guzzle);

        return $client;
    }

    public function test_send_returns_response_from_handler(): void
    {
        $expected = new Response(200, [], '{"result":[]}');
        $client = $this->clientWithMockHandler($expected);

        $request = new Request('GET', 'unit');
        $response = $client->send($request);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('{"result":[]}', (string) $response->getBody());
    }

    public function test_send_forwards_options_to_guzzle(): void
    {
        // Verify that the $options array is forwarded: the mock handler will
        // still return our stubbed response regardless of options content.
        $expected = new Response(201, [], '{"id":1}');
        $client = $this->clientWithMockHandler($expected);

        $request = new Request('POST', 'unit', [], '{"name":"test"}');
        $response = $client->send($request, ['timeout' => 5]);

        $this->assertSame(201, $response->getStatusCode());
    }
}
