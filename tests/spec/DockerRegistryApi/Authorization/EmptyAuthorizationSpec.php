<?php

namespace spec\Madkom\DockerRegistryApi\Authorization;

use Http\Client\HttpClient;
use Madkom\DockerRegistryApi\Authorization\EmptyAuthorization;
use Madkom\DockerRegistryApi\AuthorizationService;
use Madkom\DockerRegistryApi\Request;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class EmptyAuthorizationSpec
 * @package spec\Madkom\DockerRegistryApi\Authorization
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin EmptyAuthorization
 */
class EmptyAuthorizationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(AuthorizationService::class);
    }

    function it_should_return_empty_authorization_header(HttpClient $client, Request $resourceRequest)
    {
        $this->authorizationHeader($client, $resourceRequest)->shouldReturn(null);
    }

}
