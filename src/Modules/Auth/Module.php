<?php

namespace MyApp\Auth;

use Phalcon\Autoload\Loader;
use Phalcon\Mvc\View;
use Phalcon\Di\DiInterface;
use Phalcon\Mvc\ModuleDefinitionInterface;
use MyApp\Plugins\NotFoundPlugin;
use MyApp\Plugins\SecurityPlugin;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\Dispatcher;

class Module implements ModuleDefinitionInterface
{
    public function registerAutoloaders(DiInterface $di = null): void
    {
        $loader = new Loader();
        $loader->setNamespaces(
            [
                'MyApp\Auth\Controllers' => __DIR__ . '/Controllers/',
                'MyApp\Auth\Models'      => __DIR__ . '/Models/',
                'MyApp\Auth\Forms'       => __DIR__ . '/Forms/',
                'MyApp\Auth\Services'    => __DIR__ . '/Services/',
                'MyApp\Auth\Repositories'    => __DIR__ . '/Repositories/',
            ]
        );
        $loader->register();
    }

    public function registerServices(DiInterface $di): void
    {

        // $di->setShared('dispatcher', function () {
        //     $eventsManager = new EventsManager();

        //     $eventsManager->attach('dispatch:beforeExecuteRoute', new SecurityPlugin());

        //     $eventsManager->attach('dispatch:beforeException', new NotFoundPlugin());

        //     $dispatcher = new Dispatcher();
        //     $dispatcher->setDefaultNamespace('MyApp\Auth\Controllers');
        //     // $dispatcher->setEventsManager($eventsManager);

        //     return $dispatcher;
        // });

        // Registering the view component
        // $di->set(
        //     'view',
        //     function () {
        //         $view = new View();
        //         $view->setViewsDir(__DIR__ . '/Views/');
        //         return $view;
        //     }
        // );
    }
}
