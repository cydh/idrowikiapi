<?php
namespace Cydh\IdrowikiAPI\Parser;

use Cydh\IdrowikiAPI\Exceptions\ApiException;
use Cydh\IdrowikiAPI\Exceptions\ResultError;

abstract class DataTemplate implements ParserInterface
{
    /**
     * Keyword used to search
     **/
    public $keyword;

    /**
     * Data type {class}/{mode}
     **/
    public $type;

    /**
     * Decoded content in assocative array
     **/
    public $content;

    /**
     * Simple parsed content in string
     **/
    public $parsed_content;

    /**
     * Must exists array-key in content
     **/
    public $key_entry;

    /**
     * Data is search mode, check for result list
     **/
    public $is_search;

    public function __construct()
    {
        $this->parsed_content = "";
        $this->is_search = false;
    }

    public function hasValidContent()
    {
        if (!isset($this->content[$this->key_entry]) || $this->content[$this->key_entry] == false) {
            throw new ApiException(new ResultError($this->type, $this->keyword));
        }

        if ($this->is_search && $this->content['found'] < 1) {
            throw new ApiException(new ResultError($this->type, $this->keyword));
        }
    }

    public function getLink()
    {
        return !empty($this->content['WebURL']) ? $this->content['WebURL'] : "";
    }
}
