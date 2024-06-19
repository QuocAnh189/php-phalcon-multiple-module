<?php

declare(strict_types=1);

namespace MyApp\Providers;

use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Mvc\Router;

class RouterProvider implements ServiceProviderInterface
{
    public function register(DiInterface $di): void
    {
        $di->setShared('router', function () {
            $router = new Router(false);

            $router->add('/auths/:action/:params', [
                'module' => 'auth',
                'controller' => 'auths',
                'action' => 1,
                'params' => 2,
            ])->setName('auth-route');  

            $router->add('/users/:action/:params', [
                'module' => 'user',
                'controller' => 'users',
                'action' => 1,
                'params' => 2,
            ])->setName('user-route');

            $router->add('/students/:action/:params', [
                'module' => 'student',
                'controller' => 'students',
                'action' => 1,
                'params' => 2,
            ])->setName('student-route');

            $router->add('/',[
                'module' => 'auth',
                'controller' => 'auths',
                'action' => 'index',
            ]);

            // Default route for the main index
            $router->notFound([
                'module' => 'error',
                'controller' => 'errors',
                'action' => 'show404',
            ]);

            return $router;
        });
    }
}
