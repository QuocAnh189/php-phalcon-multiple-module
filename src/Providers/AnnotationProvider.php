<?php
namespace MyApp\Providers;

use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Annotations\Adapter\Memory as MemoryAdapter;
use Phalcon\Mvc\Router;


class AnnotationProvider implements ServiceProviderInterface
{
    public function register(DiInterface $di): void
    {
        $di->setShared('annotations', function () {
            return new MemoryAdapter();
        });

        $di->setShared('router', function () {
            $router = new Router(false);
            return $router;
        });

    }
}