<?php

namespace Chetkov\GetProxyListClient\Factory;

use Chetkov\GetProxyListClient\Assembler\ProxyAssembler;
use Chetkov\GetProxyListClient\Client;
use Chetkov\GetProxyListClient\Extractor\FilterParamsExtractor;

/**
 * Class ClientFactory
 * @package Chetkov\GetProxyListClient\Factory
 */
class ClientFactory
{
    /**
     * @return Client
     */
    public static function create(): Client
    {
        return new Client(
            new \GuzzleHttp\Client(),
            new FilterParamsExtractor(),
            new ProxyAssembler()
        );
    }
}
