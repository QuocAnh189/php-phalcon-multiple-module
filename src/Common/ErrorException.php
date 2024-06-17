<?php

namespace MyApp\Common;

class ErrorException extends \Exception
{
    protected $code;
    protected $message;

    public function __construct($code, $message)
    {
        $this->code = $code;
        $this->message = $message;
        parent::__construct($message, $code);
    }
}

