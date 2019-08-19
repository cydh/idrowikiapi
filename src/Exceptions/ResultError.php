<?php
namespace Cydh\IdrowikiAPI\Exceptions;

class ResultError
{
    public function __construct($type, $keyword)
    {
        $this->message = "$type with keyword '$keyword' is not found.";
    }

    public function __toString()
    {
        return $this->message;
    }
}
