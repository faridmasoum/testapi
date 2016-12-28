<?php
namespace RMIDatalink;

use RMIDatlink\Enums;
use RMIDatlink\Exceptions;

class Fetch
{
    protected $responseType;
    protected $apiPath;
    private $apiKey;

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
    }


    // API > Generate path of API
    private function getPath($route, $base = 'v1')
    {
        return sprintf($this->apiPath, $base, $route);
    }

    // Result > response result
    private static function result($data)
    {
            return json_encode($data);
    }

    // Result > response error
    private static function customError($detail)
    {
            echo json_encode(["Error" => $detail]);
            exit;
    }

}