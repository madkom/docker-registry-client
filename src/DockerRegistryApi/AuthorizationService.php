<?php

namespace Madkom\DockerRegistryApi;

use Http\Client\HttpClient;
use Madkom\DockerRegistryApi\Request;

/**
 * Interface AuthorizationService
 * @package spec\Madkom\DockerRegistryApi
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
interface AuthorizationService
{

    /**
     * Authorize request
     *
     * @param HttpClient $client
     * @param Request    $resourceRequest
     *
     * @return string authorization header string
     * @throws DockerRegistryException
     */
    public function authorizationHeader(HttpClient $client, Request $resourceRequest);

}