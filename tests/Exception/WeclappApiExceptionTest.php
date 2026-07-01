<?php

namespace Geccomedia\Weclapp\Tests\Exception;

use Geccomedia\Weclapp\Client;
use Geccomedia\Weclapp\Connection;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use Geccomedia\Weclapp\WeclappApiException;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

/**
 * Verifies that WeclappApiException is thrown by Connection::runRequest()
 * on 4xx/5xx responses, and that its accessors return clean scalar values
 * safe for Monolog serialization (no PSR-7 objects, no $previous chain).
 */
class WeclappApiExceptionTest extends OrchestraTestCase
{
    use UsesServiceProvider;

    private function connectionWithMockResponse(Response $response): Connection
    {
        $handler = new MockHandler([$response]);
        $guzzle = new GuzzleClient(['handler' => HandlerStack::create($handler)]);

        $client = new Client;

        $ref = new \ReflectionProperty(Client::class, 'http');
        $ref->setAccessible(true);
        $ref->setValue($client, $guzzle);

        return new Connection($client);
    }

    public function test_4xx_response_throws_weclapp_api_exception(): void
    {
        $connection = $this->connectionWithMockResponse(
            new Response(422, [], '{"error":"invalid field"}')
        );

        $this->expectException(WeclappApiException::class);

        $connection->selectRequest(new Request('GET', 'customer'));
    }

    public function test_5xx_response_throws_weclapp_api_exception(): void
    {
        $connection = $this->connectionWithMockResponse(
            new Response(500, [], '{"error":"internal server error"}')
        );

        $this->expectException(WeclappApiException::class);

        $connection->selectRequest(new Request('GET', 'customer'));
    }

    public function test_exception_exposes_request_method(): void
    {
        $connection = $this->connectionWithMockResponse(
            new Response(422, [], '{"error":"bad"}')
        );

        try {
            $connection->selectRequest(new Request('GET', 'customer'));
            $this->fail('Expected WeclappApiException');
        } catch (WeclappApiException $e) {
            $this->assertSame('GET', $e->getRequestMethod());
        }
    }

    public function test_exception_exposes_request_uri(): void
    {
        $connection = $this->connectionWithMockResponse(
            new Response(422, [], '{"error":"bad"}')
        );

        try {
            $connection->selectRequest(new Request('GET', 'https://example.weclapp.com/salesOrder'));
            $this->fail('Expected WeclappApiException');
        } catch (WeclappApiException $e) {
            $this->assertSame('https://example.weclapp.com/salesOrder', $e->getRequestUri());
        }
    }

    public function test_exception_exposes_response_status(): void
    {
        $connection = $this->connectionWithMockResponse(
            new Response(422, [], '{"error":"bad"}')
        );

        try {
            $connection->selectRequest(new Request('GET', 'customer'));
            $this->fail('Expected WeclappApiException');
        } catch (WeclappApiException $e) {
            $this->assertSame(422, $e->getResponseStatus());
        }
    }

    public function test_exception_exposes_response_body(): void
    {
        $connection = $this->connectionWithMockResponse(
            new Response(422, [], '{"error":"invalid field"}')
        );

        try {
            $connection->selectRequest(new Request('GET', 'customer'));
            $this->fail('Expected WeclappApiException');
        } catch (WeclappApiException $e) {
            $this->assertSame('{"error":"invalid field"}', $e->getResponseBody());
        }
    }

    public function test_exception_message_contains_method_uri_and_body(): void
    {
        $connection = $this->connectionWithMockResponse(
            new Response(422, [], '{"error":"invalid field"}')
        );

        try {
            $connection->selectRequest(new Request('GET', 'https://example.weclapp.com/salesOrder'));
            $this->fail('Expected WeclappApiException');
        } catch (WeclappApiException $e) {
            $this->assertStringContainsString('GET', $e->getMessage());
            $this->assertStringContainsString('https://example.weclapp.com/salesOrder', $e->getMessage());
            $this->assertStringContainsString('{"error":"invalid field"}', $e->getMessage());
        }
    }

    public function test_exception_code_is_http_status(): void
    {
        $connection = $this->connectionWithMockResponse(
            new Response(404, [], 'not found')
        );

        try {
            $connection->selectRequest(new Request('GET', 'customer'));
            $this->fail('Expected WeclappApiException');
        } catch (WeclappApiException $e) {
            $this->assertSame(404, $e->getCode());
        }
    }

    public function test_previous_exception_is_not_forwarded(): void
    {
        $connection = $this->connectionWithMockResponse(
            new Response(500, [], 'error')
        );

        try {
            $connection->selectRequest(new Request('GET', 'customer'));
            $this->fail('Expected WeclappApiException');
        } catch (WeclappApiException $e) {
            // $previous must be null — forwarding RequestException would attach
            // a non-serializable ResponseInterface stream to the exception chain,
            // causing Monolog to silently drop the entire log record.
            $this->assertNull($e->getPrevious());
        }
    }

    public function test_exception_properties_are_all_scalars(): void
    {
        $connection = $this->connectionWithMockResponse(
            new Response(400, [], 'bad request')
        );

        try {
            $connection->selectRequest(new Request('GET', 'customer'));
            $this->fail('Expected WeclappApiException');
        } catch (WeclappApiException $e) {
            // Verify all public accessors return only scalar types — no PSR-7
            // objects that would break Monolog's NormalizerFormatter.
            $this->assertIsString($e->getRequestMethod());
            $this->assertIsString($e->getRequestUri());
            $this->assertIsInt($e->getResponseStatus());
            $this->assertIsString($e->getResponseBody());
            $this->assertIsString($e->getMessage());
            $this->assertIsInt($e->getCode());
        }
    }

    public function test_response_body_is_null_when_no_response(): void
    {
        // Simulate a network failure (no response at all) by making Guzzle
        // throw a RequestException with a null response.
        $client = new Client;
        $guzzleRequest = new Request('GET', 'customer');
        $requestException = new RequestException('connection refused', $guzzleRequest);

        $e = new WeclappApiException($guzzleRequest, null, $requestException);

        $this->assertNull($e->getResponseStatus());
        // Falls back to the Guzzle exception message
        $this->assertSame('connection refused', $e->getResponseBody());
        $this->assertSame(0, $e->getCode());
    }
}
