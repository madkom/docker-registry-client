<?php
require __DIR__ . '/../vendor/autoload.php';

// No Authorization

$registryFactory      = new \Madkom\DockerRegistryApi\PsrHttpRequestFactory('https://registry.com');

$authorizationService = new \Madkom\DockerRegistryApi\Authorization\EmptyAuthorization();
$client = new \Madkom\DockerRegistryApi\HttpDockerRegistryClient(new \Http\Adapter\Guzzle6\Client(), $registryFactory, $authorizationService);

$request  = new \Madkom\DockerRegistryApi\Request\ImageTags('ubuntu');
$response = $client->handle($request);

dump($response->getBody()->getContents());



// Basic Authorization

$registryFactory      = new \Madkom\DockerRegistryApi\PsrHttpRequestFactory('https://registry.com');

$authorizationService = new \Madkom\DockerRegistryApi\Authorization\BasicAuthorization('username', 'password');
$client = new \Madkom\DockerRegistryApi\HttpDockerRegistryClient(new \Http\Adapter\Guzzle6\Client(), $registryFactory, $authorizationService);

$request  = new \Madkom\DockerRegistryApi\Request\ImageTags('ubuntu');
$response = $client->handle($request);

dump($response->getBody()->getContents());



// Token Based Authorization

$registryFactory      = new \Madkom\DockerRegistryApi\PsrHttpRequestFactory('https://registry.com');
$authorizationFactory = new \Madkom\DockerRegistryApi\PsrHttpRequestFactory('https://portus.com');

$authorizationService = new \Madkom\DockerRegistryApi\Authorization\TokenAuthorization('user', 'password', 'registry.com', $authorizationFactory);
$client = new \Madkom\DockerRegistryApi\HttpDockerRegistryClient(new \Http\Adapter\Guzzle6\Client(), $registryFactory, $authorizationService);

$request  = new \Madkom\DockerRegistryApi\Request\ImageTags('ubuntu');
$response = $client->handle($request);

dump($response->getBody()->getContents());