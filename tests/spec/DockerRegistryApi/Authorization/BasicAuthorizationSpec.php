<?php

namespace spec\Madkom\DockerRegistryApi\Authorization;

use Http\Client\HttpClient;
use Madkom\DockerRegistryApi\Authorization\BasicAuthorization;
use Madkom\DockerRegistryApi\AuthorizationService;
use Madkom\DockerRegistryApi\Request;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class BasicAuthorizationSpec
 * @package spec\Madkom\DockerRegistryApi\Authorization
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin BasicAuthorization
 */
class BasicAuthorizationSpec extends ObjectBehavior
{

    function let()
    {
        $this->beConstructedWith('username', 'password');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AuthorizationService::class);
    }

    function it_should_return_authorization_string(HttpClient $client, Request $request)
    {
        $this->authorizationHeader($client, $request)->shouldReturn('Basic ' . base64_encode('username' . ':' . 'password'));
    }

}
