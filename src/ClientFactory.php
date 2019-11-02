<?php

namespace Chetkov\GetProxyListClient;

use Chetkov\GetProxyListClient\Assembler\ProxyAssembler;
use Chetkov\GetProxyListClient\Extractor\FilterParamsExtractor;

/**
 * Class ClientFactory
 * @package Chetkov\GetProxyListClient
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
