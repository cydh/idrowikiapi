<?php
namespace Cydh\IdrowikiAPI;

use Cydh\IdrowikiAPI\Exceptions\ApiException;
use Cydh\IdrowikiAPI\Exceptions\JSONErrorType;
use Cydh\IdrowikiAPI\Exceptions\APIError;
use Cydh\IdrowikiAPI\ApiType;
use Cydh\IdrowikiAPI\Parser\ItemInfo;
use Cydh\IdrowikiAPI\Parser\ItemSearch;
use Cydh\IdrowikiAPI\Parser\ItemDroplist;
use Cydh\IdrowikiAPI\Parser\MonsterInfo;
use Cydh\IdrowikiAPI\Parser\MonsterDroplist;
use Cydh\IdrowikiAPI\Parser\MonsterMaplist;
use Cydh\IdrowikiAPI\Parser\MonsterSearch;
use Cydh\IdrowikiAPI\Parser\MapInfo;
use Cydh\IdrowikiAPI\Parser\MapSearch;

class IdrowikiAPI
{
    private $data;
    private $connection;
    private $error;

    public function __construct($type, $keyword)
    {
        try {
            $this->connection = new Connection();

            switch ($type) {
                case ApiType::ITEM_INFO:
                    $this->data = new ItemInfo();
                    break;

                case ApiType::ITEM_DROPLIST:
                    $this->data = new ItemDroplist();
                    break;

                case ApiType::ITEM_SEARCH:
                    $this->data = new ItemSearch();
                    break;

                case ApiType::MONSTER_INFO:
                    $this->data = new MonsterInfo();
                    break;

                case ApiType::MONSTER_MAPLIST:
                    $this->data = new MonsterMaplist();
                    break;

                case ApiType::MONSTER_DROPLIST:
                    $this->data = new MonsterDroplist();
                    break;

                case ApiType::MONSTER_SEARCH:
                    $this->data = new MonsterSearch();
                    break;

                case ApiType::MAP_INFO:
                    $this->data = new MapInfo();
                    break;

                case ApiType::MAP_SEARCH:
                    $this->data = new MapSearch();
                    break;

                default:
                    throw new ApiException("Invalid type '$type'");
                    break;
            }

            $this->data->keyword = $keyword;
            $this->setKeyword($keyword);

        } catch (ApiException $e) {
            $this->error = new APIError($e->getMessage(), $e->getCode());
        }
    }

    public function setEndpoint($str)
    {
        $this->connection->api_endpoint = $str;
    }

    public function setAuthKey($str)
    {
        $this->connection->api_auth_key = $str;
    }

    public function setAPIType($str)
    {
        $this->connection->api_type = $str;
    }

    public function setKeyword($str)
    {
        $this->data->keyword = $str;
    }

    public function execute()
    {
        try {

            $this->connection->execute($this->data);
            var_dump("Execution complete");

            return true;
        } catch (ApiException $e) {

            $this->error = new APIError($e->getMessage(), $e->getCode());

            return false;
        }
    }

    public function getErrorCode()
    {
        return $this->error->code;
    }

    public function getErrorMessage()
    {
        return $this->error->message;
    }

    public function isSuccess()
    {
        return !isset($this->error);
    }

    public function getContent()
    {
        if (!$this->isSuccess()) {
            return "null";
        }
        return $this->data->content;
    }

    public function simplePrint()
    {
        if (!$this->isSuccess()) {
            return "null";
        }

        return empty($this->data->parsed_content) ? $this->data->parse() : $this->data->parsed_content;
    }

    public function getLink()
    {
        return $this->data->getLink();
    }
}
