<?php

declare(strict_types=1);

namespace MyApp\Common;

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    protected function initialize()
    {
        $this->tag->title()->prepend('UIT | ');
        $this->view->setTemplateAfter('main');
    }
}
