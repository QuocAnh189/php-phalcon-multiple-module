<?php

declare(strict_types=1);

namespace MyApp\Student;

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
                'MyApp\Student\Controllers' => __DIR__ . '/Controllers/',
                'MyApp\Student\Models'      => __DIR__ . '/Models/',
                'MyApp\Student\Forms'       => __DIR__ . '/Forms/',
                'MyApp\Student\Services'    => __DIR__ . '/Services/',
                'MyApp\Student\Repositories'    => __DIR__ . '/Repositories/',
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
        //     $dispatcher->setDefaultNamespace('MyApp\Student\Controllers');

        //     // $dispatcher->setEventsManager($eventsManager);
        //     return $dispatcher;
        // });
    }
}