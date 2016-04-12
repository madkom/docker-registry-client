<?php

namespace Madkom\DockerRegistryApi\Authorization;

use Http\Client\HttpClient;
use Madkom\DockerRegistryApi\AuthorizationService;
use Madkom\DockerRegistryApi\Request;

/**
 * Class EmptyAuthorization
 * @package Madkom\DockerRegistryApi\Authorization
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class EmptyAuthorization implements AuthorizationService
{
    /**
     * @inheritDoc
     */
    public function authorizationHeader(HttpClient $client, Request $resourceRequest)
    {
        return null;
    }
}
