<?php

declare(strict_types=1);

namespace MyApp\Providers;

use MyApp\Plugins\NotFoundPlugin;
use MyApp\Plugins\SecurityPlugin;
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\Dispatcher;

class DispatcherProvider implements ServiceProviderInterface
{
    public function register(DiInterface $di): void
    {
        $di->setShared('dispatcher', function () use($di) {
            $eventsManager = new EventsManager();
            

            $eventsManager->attach('dispatch:beforeDispatchLoop', function ($event, $dispatcher) {
                $moduleName = $dispatcher->getModuleName();

                switch ($moduleName) {
                    case 'auth':
                        $dispatcher->setDefaultNamespace('MyApp\Auth\Controllers');
                        break;
                    case 'user':
                        $dispatcher->setDefaultNamespace('MyApp\User\Controllers');
                        break;
                    case 'student':
                        $dispatcher->setDefaultNamespace('MyApp\Student\Controllers');
                        break;
                    case 'error':
                        $dispatcher->setDefaultNamespace('MyApp\Error\Controllers');
                        break;
                    default:
                        $dispatcher->setDefaultNamespace('MyApp\Error\Controllers');
                        break;
                }
            });

            
            // // Attach SecurityPlugin to handle security checks
            // $eventsManager->attach('dispatch:beforeExecuteRoute', new SecurityPlugin());

            // // Attach NotFoundPlugin to handle not-found exceptions
            
            // $eventsManager->attach('dispatch:beforeException', new NotFoundPlugin());
            // $eventsManager->attach('dispatch:beforeExecuteRoute', new SecurityPlugin());

            // Attach SecurityPlugin to handle security checks
            // $securityPlugin = $di->get(SecurityPlugin::class);
            // $eventsManager->attach('dispatch:beforeExecuteRoute', $securityPlugin);

            $dispatcher = new Dispatcher();
            
            $dispatcher->setEventsManager($eventsManager);

            return $dispatcher;
        });
    }
}
