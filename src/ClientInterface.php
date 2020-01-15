<?php

namespace Chetkov\GetProxyListClient;

use Chetkov\GetProxyListClient\DTO\FilterParams;
use Chetkov\GetProxyListClient\DTO\Proxy;
use Chetkov\GetProxyListClient\Exception\ExceededDailyLimitException;
use Chetkov\GetProxyListClient\Exception\InvalidApiKeyException;
use Chetkov\GetProxyListClient\Exception\RequestException;
use Chetkov\GetProxyListClient\Exception\ValidationException;

/**
 * Class Client
 * @package Chetkov\GetProxyListClient
 */
interface ClientInterface
{
    /**
     * @param FilterParams $filterParams
     * @return Proxy
     * @throws ExceededDailyLimitException
     * @throws InvalidApiKeyException
     * @throws RequestException
     * @throws ValidationException
     */
    public function getProxy(FilterParams $filterParams): Proxy;

    /**
     * @param FilterParams $filterParams
     * @return Proxy[]
     * @throws ExceededDailyLimitException
     * @throws InvalidApiKeyException
     * @throws RequestException
     */
    public function getList(FilterParams $filterParams): array;
}