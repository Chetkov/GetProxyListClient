<?php

use Chetkov\GetProxyListClient\ClientFactory;
use Chetkov\GetProxyListClient\DTO\FilterParams;

require_once __DIR__ . '/vendor/autoload.php';

$client = ClientFactory::create();

$filter = (new FilterParams())
    ->setApiKey('api_key')
    ->setLastTested(600)
    ->setPortList([80, 8080])
    ->setProtocolList(['http']);

$proxy = $client->getProxy($filter);
$proxyList = $client->getList($filter);
