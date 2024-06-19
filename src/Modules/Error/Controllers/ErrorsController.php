<?php

declare(strict_types=1);

namespace MyApp\Error\Controllers;

use MyApp\Common\ControllerBase;

/**
 * Class ErrorsController
 *
 * @package MyApp\Error\Controllers
 */
class ErrorsController extends ControllerBase
{
    /**
     * Initialize method.
     *
     * Set the title for the error pages.
     */
    public function initialize()
    {
        $this->tag->title()->set('Oops!');

        parent::initialize();
    }

    /**
     * Action to show a 401 Unauthorized error page.
     */
    public function show401Action(): void
    {
        $this->response->setStatusCode(401);
    }

    /**
     * Action to show a 404 Not Found error page.
     */
    public function show404Action(): void
    {
        $this->response->setStatusCode(404);
    }

    /**
     * Action to show a 500 Internal Server Error page.
     */
    public function show500Action(): void
    {
        $this->response->setStatusCode(500);
    }
}
