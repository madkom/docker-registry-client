<?php

namespace Madkom\DockerRegistryApi;

use Http\Client\HttpClient;
use Madkom\DockerRegistryApi\Request\Authorization;
use Psr\Http\Message\ResponseInterface;

/**
 * Class HttpDockerRegistryClient
 * @package Madkom\DockerRegistryApi
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class HttpDockerRegistryClient
{
    /**
     * @var HttpClient
     */
    private $client;
    /**
     * @var string
     */
    private $username;
    /**
     * @var string
     */
    private $registryServiceName;
    /**
     * @var string
     */
    private $password;
    /**
     * @var PsrHttpRequestFactory
     */
    private $psrHttpRequestFactoryAuthorization;
    /**
     * @var PsrHttpRequestFactory
     */
    private $psrHttpRequestFactoryRegistry;

    /**
     * HttpDockerRegistryClient constructor.
     *
     * @param string                $username
     * @param string                $password
     * @param string                $registryServiceName
     * @param HttpClient            $client
     * @param PsrHttpRequestFactory $psrHttpRequestFactoryRegistry
     * @param PsrHttpRequestFactory $psrHttpRequestFactoryAuthorization
     */
    public function __construct($username, $password, $registryServiceName, HttpClient $client, PsrHttpRequestFactory $psrHttpRequestFactoryRegistry, PsrHttpRequestFactory $psrHttpRequestFactoryAuthorization = null)
    {
        $this->username = $username;
        $this->password = $password;
        $this->registryServiceName = $registryServiceName;
        $this->client = $client;
        $this->psrHttpRequestFactoryRegistry = $psrHttpRequestFactoryRegistry;
        $this->psrHttpRequestFactoryAuthorization = $psrHttpRequestFactoryAuthorization;
    }

    /**
     * @param Request $request
     *
     * @return ResponseInterface
     * @throws DockerRegistryException
     */
    public function handle(Request $request)
    {
        $psr7Request = $this->psrHttpRequestFactoryRegistry->toPsrRequest($request);

        if ($this->psrHttpRequestFactoryAuthorization) {
            $authorizationRequest = $this->psrHttpRequestFactoryAuthorization->toPsrRequest(new Authorization($this->psrHttpRequestFactoryRegistry->host(), $this->registryServiceName, $this->username, $this->password, $request->scope()));
            $response = $this->client->sendRequest($authorizationRequest);

            if ($response->getStatusCode() !== 200) {
                throw new DockerRegistryException("Can't authorize with given credentials: ".$response->getBody()->getContents());
            }

            $token = json_decode($response->getBody()->getContents(), true);
            $token = $token['token'];

            $psr7Request = $psr7Request->withHeader('Authorization', 'Bearer '.$token);
        }

        return $this->client->sendRequest($psr7Request);
    }

}
