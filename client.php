<?php

declare(strict_types=1);

use GuzzleHttp\Client as PsrHttpClient;
use Nyholm\Psr7\Factory\Psr17Factory;
use Prokerala\Common\Api\Authentication\Oauth2;
use Prokerala\Common\Api\Client;

const CLIENT_ID = 'YOUR_CLIENT_ID';
const CLIENT_SECRET = 'YOUR_CLIENT_SECRET';

$psr17Factory = new Psr17Factory();
$httpClient = new PsrHttpClient();

$clientId = CLIENT_ID;
$clientSecret = CLIENT_SECRET;

if ('YOUR_CLIENT_ID' === $clientId && isset($_ENV['DEMO_CLIENT_ID'])) {
    $clientId = $_ENV['DEMO_CLIENT_ID'];
    $clientSecret = $_ENV['DEMO_CLIENT_SECRET'];
}

$authClient = new Oauth2($clientId, $clientSecret, $httpClient, $psr17Factory, $psr17Factory);

return new Client($authClient, $httpClient, $psr17Factory);
