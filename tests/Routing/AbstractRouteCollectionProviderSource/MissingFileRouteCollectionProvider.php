<?php

namespace Symplify\ModularRouting\Tests\Routing\AbstractRouteCollectionProviderSource;

use Symfony\Component\Routing\RouteCollection;
use Symplify\ModularRouting\Routing\AbstractRouteCollectionProvider;

final class MissingFileRouteCollectionProvider extends AbstractRouteCollectionProvider
{
    /**
     * {@inheritdoc}
     */
    public function getRouteCollection() : RouteCollection
    {
        return $this->loadRouteCollectionFromFile('incorrect-path.yml');
    }
}
