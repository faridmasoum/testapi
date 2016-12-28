<?php
namespace RMIDatalink;

use RMIDatalink\Enums\ResponseTypes;
use RMIDatalink\Exceptions\BaseRuntimeException;

class Fetch extends Buckets
{
    protected $responseType;
    protected $apiPath;
    protected $apiKey;

    // get api key onload
    public function __construct($apiKey, $responseType=ResponseTypes::Json, $apiPath="http://rmib2b.com:8100/api/%s/%s")
    {
        // check Curl is installed on the server
        if (!extension_loaded('curl')) {
            // return
            customError('cURL library is not loaded');
        }

        // check api key is set as parameter on new object
        if (is_null($apiKey)) {
            customError('apiKey is empty');
        }

        // response type
        if($this->responseType == ResponseTypes::Json) {
            header('Content-Type: application/json');
        }

        $this->apiKey = $apiKey;
        $this->apiPath = $apiPath;
        $this->responseType = $responseType;
    }


    // API > Generate path of API
    protected function getPath($route, $base = 'v1')
    {
        return sprintf($this->apiPath, $base, $route);
    }

    // Result > response result
    protected static function result($data)
    {
            return json_encode($data);
    }

    // Result > response error
    protected static function customError($detail)
    {
            echo json_encode(["Error" => $detail]);
            exit;
    }



}