<?php

namespace spec\Madkom\DockerRegistryApi\Authorization;

use Http\Client\HttpClient;
use Madkom\DockerRegistryApi\Authorization\TokenAuthorization;
use Madkom\DockerRegistryApi\AuthorizationService;
use Madkom\DockerRegistryApi\DockerRegistryException;
use Madkom\DockerRegistryApi\PsrHttpRequestFactory;
use Madkom\DockerRegistryApi\Request;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Class TokenAuthorizationSpec
 * @package spec\Madkom\DockerRegistryApi\Authorization
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin TokenAuthorization
 */
class TokenAuthorizationSpec extends ObjectBehavior
{
    /** @var  PsrHttpRequestFactory */
    private $authorizationRequestFactory;

    function let(PsrHttpRequestFactory $authorizationRequestFactory)
    {
        $this->authorizationRequestFactory = $authorizationRequestFactory;
        $this->beConstructedWith('login', 'password', 'registryServiceName', $authorizationRequestFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AuthorizationService::class);
    }
    
    function it_should_return_authorization_string(HttpClient $client, Request $request, ResponseInterface $responseInterface, StreamInterface $streamInterface, RequestInterface $authorizationPsrRequest)
    {
        $this->authorizationRequestFactory->host()->willReturn('https://portus.com');
        $this->authorizationRequestFactory->toPsrRequest(Argument::type(Request\Authorization::class))->willReturn($authorizationPsrRequest);

        $client->sendRequest($authorizationPsrRequest)->willReturn($responseInterface);

        $responseInterface->getStatusCode()->willReturn(200);
        $responseInterface->getBody()->willReturn($streamInterface);
        $streamInterface->getContents()->willReturn(json_encode(['token' => 'someGeneratedToken']));

        $this->authorizationHeader($client, $request)->shouldReturn('Bearer someGeneratedToken');
    }

    function it_should_throw_exception_if_no_authorized(HttpClient $client, Request $request, ResponseInterface $responseInterface, StreamInterface $streamInterface, RequestInterface $authorizationPsrRequest)
    {
        $this->authorizationRequestFactory->host()->willReturn('https://portus.com');
        $this->authorizationRequestFactory->toPsrRequest(Argument::type(Request\Authorization::class))->willReturn($authorizationPsrRequest);

        $client->sendRequest($authorizationPsrRequest)->willReturn($responseInterface);

        $responseInterface->getStatusCode()->willReturn(403);
        $responseInterface->getBody()->willReturn($streamInterface);
        $streamInterface->getContents()->willReturn('not authorized');

        $this->shouldThrow(DockerRegistryException::class)->during('authorizationHeader', [$client, $request]);
    }
    
}
