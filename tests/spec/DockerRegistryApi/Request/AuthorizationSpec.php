<?php

namespace spec\Madkom\DockerRegistryApi\Request;

use Madkom\DockerRegistryApi\Request;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class AuthorizationSpec
 * @package spec\Madkom\DockerRegistryApi\Request
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin Request\Authorization
 */
class AuthorizationSpec extends ObjectBehavior
{

    private $registryHost;
    private $registryService;
    private $username;
    private $password;
    private $scope;

    function let()
    {
        $this->registryHost = 'https://registry.com';
        $this->registryService = 'registry.com';
        $this->username = 'Franek';
        $this->password = 'Majehan';
        $this->scope    = 'registry:catalog:*';

        $this->beConstructedWith($this->registryHost, $this->registryService, $this->username, $this->password, $this->scope);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Request::class);
    }

    function it_should_return_values_it_constructed_with()
    {
        $this->uri()->shouldReturn('/v2/token?service=registry.com&scope=registry:catalog:*');
        $this->headers()->shouldReturn([
            'Authorization' => 'Basic RnJhbmVrOk1hamVoYW4='
        ]);
        $this->scope()->shouldReturn($this->scope);
        $this->method()->shouldReturn('GET');
        $this->data()->shouldReturn([]);
    }


}
