<?php

namespace Madkom\DockerRegistryApi\Request;

use Madkom\DockerRegistryApi\Request;

/**
 * Class ImageTags
 * @package Madkom\DockerRegistryApi\Request
 * @author  Tobias Munk <tobias@diemeisterei.de>
 * @since   0.8.0
 */
class Catalog implements Request
{

    /**
     * @inheritDoc
     */
    public function method()
    {
        return 'GET';
    }

    /**
     * @inheritDoc
     */
    public function uri()
    {
        return '/v2/_catalog';
    }

    /**
     * @inheritDoc
     */
    public function headers()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function data()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function scope()
    {
        return 'registry:catalog:*';
    }


}
