<?php

namespace Geccomedia\Weclapp;

use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class WeclappApiException extends \RuntimeException
{
    private readonly string $requestMethod;

    private readonly string $requestUri;

    private readonly ?int $responseStatus;

    private readonly string $responseBody;

    public function __construct(
        RequestInterface $apiRequest,
        ?ResponseInterface $apiResponse,
        RequestException $previous,
    ) {
        $this->requestMethod = $apiRequest->getMethod();
        $this->requestUri = (string) $apiRequest->getUri();
        $this->responseStatus = $apiResponse?->getStatusCode();
        $this->responseBody = $apiResponse?->getBody()->getContents()
            ?? $previous->getMessage();

        // $previous is intentionally not forwarded to the parent constructor.
        // Guzzle's RequestException holds a ResponseInterface stream object
        // that Monolog cannot serialize, which causes silent log loss.
        parent::__construct(
            sprintf(
                'Weclapp API error %s %s: %s',
                $this->requestMethod,
                $this->requestUri,
                $this->responseBody,
            ),
            $this->responseStatus ?? 0,
        );
    }

    public function getRequestMethod(): string
    {
        return $this->requestMethod;
    }

    public function getRequestUri(): string
    {
        return $this->requestUri;
    }

    public function getResponseStatus(): ?int
    {
        return $this->responseStatus;
    }

    public function getResponseBody(): string
    {
        return $this->responseBody;
    }
}
