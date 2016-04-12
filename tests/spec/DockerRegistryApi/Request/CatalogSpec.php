<?php

namespace spec\Madkom\DockerRegistryApi\Request;

use Madkom\DockerRegistryApi\Request;
use Madkom\DockerRegistryApi\Request\Catalog;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class CatalogSpec
 * @package spec\Madkom\DockerRegistryApi\Request
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin Catalog
 */
class CatalogSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Request::class);
    }

    function it_should_return_values_it_was_constructed_with()
    {
        $this->uri()->shouldReturn('/v2/_catalog');
        $this->headers()->shouldReturn([]);
        $this->scope()->shouldReturn('registry:catalog:*');
        $this->method()->shouldReturn('GET');
        $this->data()->shouldReturn([]);
    }

}
