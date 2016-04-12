<?php

namespace Madkom\DockerRegistryApi\Authorization;

use Http\Client\HttpClient;
use Madkom\DockerRegistryApi\AuthorizationService;
use Madkom\DockerRegistryApi\Request;

/**
 * Class BasicAuthorization
 * @package Madkom\DockerRegistryApi\Authorization
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @since 0.8.0
 */
class BasicAuthorization implements AuthorizationService
{

    /**
     * @var string
     */
    private $username;
    /**
     * @var  string
     */
    private $password;

    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @inheritDoc
     */
    public function authorizationHeader(HttpClient $client, Request $resourceRequest)
    {
        return 'Basic ' . base64_encode($this->username . ':' . $this->password);
    }

}
