<?php

namespace Madkom\DockerRegistryApi\Authorization;

use Http\Client\HttpClient;
use Madkom\DockerRegistryApi\AuthorizationService;
use Madkom\DockerRegistryApi\DockerRegistryException;
use Madkom\DockerRegistryApi\PsrHttpRequestFactory;
use Madkom\DockerRegistryApi\Request;
use Psr\Http\Message\RequestInterface;

/**
 * Class TokenAuthorization
 * @package Madkom\DockerRegistryApi\Authorization
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class TokenAuthorization implements AuthorizationService
{
    /**
     * @var string
     */
    private $username;
    /**
     * @var string
     */
    private $password;
    /**
     * @var string
     */
    private $registryServiceName;
    /**
     * @var PsrHttpRequestFactory
     */
    private $authorizationFactory;


    /**
     * TokenAuthorization constructor.
     *
     * @param string $username
     * @param string $password
     * @param string $registryServiceName
     * @param string $authorizationFactory
     */
    public function __construct($username, $password, $registryServiceName, $authorizationFactory)
    {
        $this->username             = $username;
        $this->password             = $password;
        $this->registryServiceName  = $registryServiceName;
        $this->authorizationFactory = $authorizationFactory;
    }

    /**
     * @inheritDoc
     */
    public function authorizationHeader(HttpClient $client, Request $resourceRequest)
    {
        $authorizationRequest = $this->authorizationFactory->toPsrRequest(new Request\Authorization($this->authorizationFactory->host(), $this->registryServiceName, $this->username, $this->password, $resourceRequest->scope()));
        $response = $client->sendRequest($authorizationRequest);

        if ($response->getStatusCode() !== 200) {
            throw new DockerRegistryException("Can't authorize with given credentials: " . $response->getBody()->getContents());
        }

        $responseData = json_decode($response->getBody()->getContents(), true);

        return 'Bearer ' . $responseData['token'];
    }
}
