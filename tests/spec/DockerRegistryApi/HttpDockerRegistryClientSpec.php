<?php

namespace spec\Madkom\DockerRegistryApi;

use Http\Client\HttpClient;
use Madkom\DockerRegistryApi\AuthorizationService;
use Madkom\DockerRegistryApi\DockerRegistryException;
use Madkom\DockerRegistryApi\HttpDockerRegistryClient;
use Madkom\DockerRegistryApi\PsrHttpRequestFactory;
use Madkom\DockerRegistryApi\Request;
use \GuzzleHttp\Psr7;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Class HttpDockerRegistryClientSpec
 * @package spec\Madkom\DockerRegistryApi
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin HttpDockerRegistryClient
 */
class HttpDockerRegistryClientSpec extends ObjectBehavior
{

    /** @var  HttpClient */
    private $client;
    /** @var  PsrHttpRequestFactory */
    private $psrHttpRequestFactory;
    /** @var  AuthorizationService */
    private $authorizationService;

    function let(HttpClient $client, PsrHttpRequestFactory $psrHttpRequestFactory, AuthorizationService $authorizationService)
    {
        $this->client                   = $client;
        $this->psrHttpRequestFactory    = $psrHttpRequestFactory;
        $this->authorizationService     = $authorizationService;

        $this->beConstructedWith($client, $this->psrHttpRequestFactory, $authorizationService);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Madkom\DockerRegistryApi\HttpDockerRegistryClient');
    }

    function it_should_handle_request_2(Request $resourceRequest, RequestInterface $psrResourceRequest)
    {
        $this->authorizationService->authorizationHeader($this->client, $resourceRequest)->willReturn('Basic someHash');

        $this->psrHttpRequestFactory->toPsrRequest($resourceRequest)->willReturn($psrResourceRequest);
        $psrResourceRequest->withHeader('Authorization', 'Basic someHash')->shouldBeCalledTimes(1)->willReturn($psrResourceRequest);

        $this->client->sendRequest($psrResourceRequest)->shouldBeCalledTimes(1);

        $this->handle($resourceRequest);
    }

}
