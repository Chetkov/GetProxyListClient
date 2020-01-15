<?php

namespace Chetkov\GetProxyListClient;

use Chetkov\GetProxyListClient\DTO\FilterParams;
use Chetkov\GetProxyListClient\DTO\Proxy;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;

/**
 * Class CheckingClientDecorator
 * @package Chetkov\GetProxyListClient
 */
class CheckingClientDecorator implements ClientInterface
{
    /** @var ClientInterface */
    private $decoratedClient;

    /** @var \GuzzleHttp\ClientInterface */
    private $httpClient;

    /** @var int */
    private $timeout;

    /**
     * CheckingClientDecorator constructor.
     * @param ClientInterface $decoratedClient
     * @param \GuzzleHttp\ClientInterface $httpClient
     * @param int $timeout
     */
    public function __construct(
        ClientInterface $decoratedClient,
        \GuzzleHttp\ClientInterface $httpClient,
        int $timeout
    ) {
        $this->decoratedClient = $decoratedClient;
        $this->httpClient = $httpClient;
        $this->timeout = $timeout;
    }

    /**
     * @inheritDoc
     */
    public function getProxy(FilterParams $filterParams): Proxy
    {
        start:
        $proxy = $this->decoratedClient->getProxy($filterParams);
        if (!$this->isAlive($proxy)) {
            goto start;
        }
        return $proxy;
    }

    /**
     * @inheritDoc
     */
    public function getList(FilterParams $filterParams): array
    {
        $checkedProxies = [];
        $proxies = $this->decoratedClient->getList($filterParams);
        foreach ($proxies as $proxy) {
            if ($this->isAlive($proxy)) {
                $checkedProxies[] = $proxy;
            }
        }
        return $checkedProxies;
    }

    /**
     * @param Proxy $proxy
     * @return bool
     */
    public function isAlive(Proxy $proxy): bool
    {
        try {
            $response = $this->httpClient->send(new Request('GET', 'https://2ip.ru'), [
                'proxy' => "{$proxy->getIp()}:{$proxy->getPort()}",
                'timeout' => $this->timeout,
            ]);
            return trim($response->getBody()->getContents()) === $proxy->getIp();
        } catch (GuzzleException $e) {
            return false;
        }
    }
}
