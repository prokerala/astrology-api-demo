<?php

declare(strict_types=1);

use GuzzleHttp\Client as PsrHttpClient;
use Nyholm\Psr7\Factory\Psr17Factory;
use Prokerala\Common\Api\Authentication\Oauth2;
use Prokerala\Common\Api\Client;

const CLIENT_ID = 'fb5ea517-14bf-4074-93b2-26d169cad89e';
const CLIENT_SECRET = '5OyTKU3DFNT3CfNpQAXuSxiA7fTVCdKTNnYRVBuj';

$psr17Factory = new Psr17Factory();
$httpClient = new PsrHttpClient();

$clientId = CLIENT_ID;
$clientSecret = CLIENT_SECRET;

if ('YOUR_CLIENT_ID' === $clientId && !empty(getenv('DEMO_CLIENT_ID'))) {
    $clientId = getenv('DEMO_CLIENT_ID');
    $clientSecret = getenv('DEMO_CLIENT_SECRET');
}

$authClient = new Oauth2($clientId, $clientSecret, $httpClient, $psr17Factory, $psr17Factory);

return new Client($authClient, $httpClient, $psr17Factory);
