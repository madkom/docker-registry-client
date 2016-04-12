<?php

namespace Madkom\DockerRegistryApi;

use Http\Client\HttpClient;
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
     * @var PsrHttpRequestFactory
     */
    private $psrHttpRequestFactory;
    /**
     * @var AuthorizationService
     */
    private $authorizationService;

    /**
     * HttpDockerRegistryClient constructor.
     *
     * @param HttpClient            $client
     * @param PsrHttpRequestFactory $psrHttpRequestFactory
     * @param AuthorizationService  $authorizationService
     */
    public function __construct(HttpClient $client, PsrHttpRequestFactory $psrHttpRequestFactory, AuthorizationService $authorizationService)
    {
        $this->client                = $client;
        $this->psrHttpRequestFactory = $psrHttpRequestFactory;
        $this->authorizationService  = $authorizationService;
    }

    /**
     * @param Request $request
     *
     * @return ResponseInterface
     * @throws DockerRegistryException
     */
    public function handle(Request $request)
    {
        $authorizationHeader = $this->authorizationService->authorizationHeader($this->client, $request);

        $psrRequest = $this->psrHttpRequestFactory->toPsrRequest($request);
        $psrRequest = $psrRequest->withHeader('Authorization', $authorizationHeader);

        return $this->client->sendRequest($psrRequest);
    }

}
