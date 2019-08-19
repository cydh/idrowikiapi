<?php
namespace Cydh\IdrowikiAPI\Exceptions;

class APIError
{
    public $message;
    public $code;

    public function __construct($message, $code = 0)
    {
        $this->message = $message;
        $this->code = $code;
    }
}
