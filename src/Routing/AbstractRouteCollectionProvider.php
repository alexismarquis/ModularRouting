<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\ModularRouting\Routing;

use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\Routing\RouteCollection;
use Symplify\ModularRouting\Contract\Routing\RouteCollectionProviderInterface;
use Symplify\ModularRouting\Exception\FileNotFoundException;

abstract class AbstractRouteCollectionProvider implements RouteCollectionProviderInterface
{
    /**
     * @var LoaderResolverInterface
     */
    private $loaderResolver;

    public function setLoaderResolver(LoaderResolverInterface $loaderResolver)
    {
        $this->loaderResolver = $loaderResolver;
    }

    public function import($resource, $type = null)
    {
        $loader = $this->loaderResolver->resolve($resource, $type);
        if (false === $loader || null === $loader) {
            return new RouteCollection();
        }

        return $loader->load($resource, $type);
    }

    protected function loadRouteCollectionFromFile(string $path) : RouteCollection
    {
        if (!file_exists($path)) {
            throw new FileNotFoundException(
                sprintf('File "%s" was not found.', $path)
            );
        }

        $loader = $this->loaderResolver->resolve($path);
        if (null === $loader) {
            return new RouteCollection();
        }

        return $loader->load($path);
    }

    /**
     * @param string[] $paths
     */
    protected function loadRouteCollectionFromFiles(array $paths) : RouteCollection
    {
        $routeCollection = new RouteCollection();

        foreach ($paths as $path) {
            $routeCollection->addCollection($this->loadRouteCollectionFromFile($path));
        }

        return $routeCollection;
    }
}
