## Описание
PHP обёртка для API https://getproxylist.com/

## Установка
```
composer require v.chetkov/get-proxy-list-client
```

## Использование
```php
<?php

use Chetkov\GetProxyListClient\DTO\FilterParams;use Chetkov\GetProxyListClient\Factory\ClientFactory;

$client = ClientFactory::create();
$filter = (new FilterParams())
    ->setApiKey('api_key')
    ->setLastTested(600)
    ->setPortList([80, 8080])
    ->setProtocolList(['http']);

$proxy = $client->getProxy($filter);
$proxyList = $client->getList($filter);
```

Более полную информацию о критериях фильтрации смотрите на сайте: https://getproxylist.com/#the-api 
