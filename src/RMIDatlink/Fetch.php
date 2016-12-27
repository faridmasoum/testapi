<?php
namespace RMIDatalink;

use RMIDatalink\Response;

class Fetch
{
    protected $apiKey;
    const APIPATH = "http://api.rmdatalink.com/v1/%s/%s/%s.json/"; http://rmib2b.com:3011/api/v1/%s.json


    // get api key onload
    public function __construct($apiKey)
    {
        // check Curl is installed on the server
        if (!extension_loaded('curl')) {

            $response = ["Error" => "Error: cURL library is not loaded"];
            header('Content-Type: application/json');
            echo json_encode($response);

            return

        }

        // check api key is set as parameter on new object
        if (is_null($apiKey)) {
            die('apiKey is empty');
            exit;
        }

        $this->apiKey = $apiKey;
    }

    private function getPath($method, $base = 'sms')
    {
        return sprintf(self::APIPATH, $this->apiKey, $base, $method);
    }

}