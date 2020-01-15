<?php

namespace Chetkov\GetProxyListClient\Factory;

use Chetkov\GetProxyListClient\CheckingClientDecorator;
use GuzzleHttp\Client;

/**
 * Class CheckingClientDecoratorFactory
 * @package Chetkov\GetProxyListClient\Factory
 */
class CheckingClientDecoratorFactory
{
    /**
     * @param int $timeoutForCheck
     * @return CheckingClientDecorator
     */
    public static function create(int $timeoutForCheck = 30): CheckingClientDecorator
    {
        return new CheckingClientDecorator(
            ClientFactory::create(),
            new Client(),
            $timeoutForCheck
        );
    }
}
