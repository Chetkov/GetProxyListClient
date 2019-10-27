<?php

namespace Chetkov\GetProxyListClient;

use GuzzleHttp\Client;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class HttpClientAdapter
 * @package Chetkov\GetProxyListClient
 */
class HttpClientAdapter implements ClientInterface
{
    /** @var Client */
    private $guzzleClient;

    /**
     * HttpClientAdapter constructor.
     * @param Client $guzzleClient
     */
    public function __construct(Client $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }

    /**
     * @inheritDoc
     */
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        return $this->guzzleClient->send($request);
    }
}
