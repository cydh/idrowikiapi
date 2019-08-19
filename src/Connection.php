<?php
namespace Cydh\IdrowikiAPI;

use Cydh\IdrowikiAPI\Parser\DataTemplate;
use Cydh\IdrowikiAPI\Exceptions\ApiException;

class Connection
{
    public $ch;
    public $api_endpoint;
    public $api_type;
    public $api_url;
    public $api_auth_key;
    private $init = null;

    public function __construct()
    {
        $this->ch = curl_init();
        if (!$this->ch) {
            throw new ApiException("Cannot initialize CURL");
        }

        curl_setopt($this->ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($this->ch, CURLOPT_HEADER, 0);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT_MS, 5000);
        curl_setopt($this->ch, CURLOPT_TIMEOUT_MS, 5000);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($this->ch, CURLOPT_REFERER, 'https://idrowiki.org');
        // curl_setopt($this->ch, CURLOPT_SSL_VERIFYSTATUS, 0);
        // curl_setopt($this->ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        var_dump("CURL created");
        $this->init = true;
    }

    public function execute(DataTemplate &$data)
    {
        try {
            if (empty($data)) {
                throw new ApiException("Data type wasn't set");
            }

            if ($this->init !== true) {
                throw new ApiException("CURL wasn't initialized yet");
            }

            $this->api_url = $this->api_endpoint.$data->type.'/'.rawurlencode($data->keyword).'/'.$this->api_auth_key;
            curl_setopt($this->ch, CURLOPT_URL, $this->api_url);

            $content = curl_exec($this->ch);
            if (!$content) {
                throw new ApiException("CURL execution failed");
            }

            $info = curl_getinfo($this->ch);
            if (!isset($info)) {
                throw new ApiException("No content retrieved");
            }

            if ($info['content_type'] != "application/json; charset=UTF-8") {
                throw new ApiException("Received invalid content. Cannot be processed");
            }

            if ($info['http_code'] != 200) {
                throw new ApiException("Error code: ".$info['http_code']);
            }

            $data->content = json_decode($content, true);
            $data->hasValidContent();
        } catch (Exception $e) {
            throw new ApiException("Cannot execute request");
        }
    }

    public function __desctruc()
    {
        if (isset($this->ch)) {
            var_dump("CURL closed");
            curl_close($this->ch);
        }
    }
}
