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
            (string)$responseBody->ip,
            (int)$responseBody->port,
            (string)$responseBody->protocol,
            (string)$responseBody->anonymity,
            new \DateTimeImmutable($responseBody->lastTested),
            (bool)$responseBody->allowsRefererHeader,
            (bool)$responseBody->allowsUserAgentHeader,
            (bool)$responseBody->allowsCustomHeaders,
            (bool)$responseBody->allowsCookies,
            (bool)$responseBody->allowsPost,
            (bool)$responseBody->allowsHttps,
            (string)$responseBody->country,
            (float)$responseBody->connectTime,
            (float)$responseBody->downloadSpeed,
            (float)$responseBody->secondsToFirstByte,
            (float)$responseBody->uptime
        );
    }
}
