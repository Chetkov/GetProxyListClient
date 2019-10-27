<?php

namespace Chetkov\GetProxyListClient\Assembler;

use Chetkov\GetProxyListClient\DTO\Proxy;

/**
 * Class ProxyAssembler
 * @package Chetkov\GetProxyListClient\Assembler
 */
class ProxyAssembler
{
    /**
     * @param \stdClass $responseBody
     * @return Proxy
     */
    public function create(\stdClass $responseBody): Proxy
    {
        return new Proxy(
            $responseBody->ip,
            $responseBody->port,
            $responseBody->protocol,
            $responseBody->anonymity,
            new \DateTimeImmutable($responseBody->lastTested),
            $responseBody->allowsRefererHeader,
            $responseBody->allowsUserAgentHeader,
            $responseBody->allowsCustomHeaders,
            $responseBody->allowsCookies,
            $responseBody->allowsPost,
            $responseBody->allowsHttps,
            $responseBody->country,
            $responseBody->connectTime,
            $responseBody->downloadSpeed,
            $responseBody->secondsToFirstByte,
            $responseBody->uptime
        );
    }
}
