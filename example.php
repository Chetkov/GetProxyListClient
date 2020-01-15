<?php

use Chetkov\GetProxyListClient\DTO\FilterParams;
use Chetkov\GetProxyListClient\Factory\CheckingClientDecoratorFactory;
use Chetkov\GetProxyListClient\Factory\ClientFactory;

require_once __DIR__ . '/vendor/autoload.php';

$client = ClientFactory::create();

$filter = (new FilterParams())
    ->setApiKey('api_key')
    ->setLastTested(600)
    ->setPortList([80, 8080])
    ->setProtocolList(['http']);

$proxy = $client->getProxy($filter);
$proxyList = $client->getList($filter);


// Получение 100% живых прокси
$client = CheckingClientDecoratorFactory::create(15);

$filter = (new FilterParams())
    ->setApiKey('api_key')
    ->setLastTested(600)
    ->setPortList([80, 8080])
    ->setProtocolList(['http']);

$proxy = $client->getProxy($filter);
$proxyList = $client->getList($filter);
