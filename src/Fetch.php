<?php
namespace RMIDatalink;

use RMIDatalink\Enums\ResponseTypes;
use RMIDatalink\Exceptions\BaseRuntimeException;

use Curl\Curl;

class Fetch extends Datalink // extends Buckets
{

    protected static $responseType;
    protected $apiPath;
    protected $apiKey;


    // get api key onload
    public function __construct($apiKey, $responseType=ResponseTypes::Json, $apiPath="http://rmib2b.com:8100/api/%s/%s")
    {
        // check Curl is installed on the server
        if (!extension_loaded('curl')) {
            // return
            self::customError('cURL library is not loaded');
        }

        // check api key is set as parameter on new object
        if (is_null($apiKey)) {
            self::customError('apiKey is empty');
        }



        $this->apiPath = $apiPath;
        $this->apiKey = $apiKey;
        self::$responseType = $responseType;

        //test connection
        $curl = new Curl();
        $route = "buckets.{$responseType}";
        $path = $this->getPath($route);
        $curl->setHeader('api_key', $this->apiKey);
        $curl->get($path);
        $result = json_decode($curl->response , true);
        $curl->close();

        if(isset($result) === false)
            return self::customError('Could not access to Datalink, Please check your connection ');
        elseif(array_key_exists('status', $result) && $result['status'] == '500'){
            return self::customError($result['message']);
        }

        parent::__construct();

    }

    protected function doCurl($route)
    {

        $curl = new Curl();
        $responseType = self::$responseType;
        $path = $this->getPath($route);
        $curl->setHeader('api_key', $this->apiKey);
        $curl->get($path);
        $result = json_decode($curl->response , true);
        $curl->close();

        return $result;
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
    public static function customError($detail)
    {
        if(self::$responseType == ResponseTypes::Json)
        {
            header('Content-Type: application/json');
            echo json_encode(["Error" => $detail]);
        }
        else
        {
            header('Content-Type: text/xml');
            echo $detail;
        }
        exit;
    }

    public static function response($data)
    {
        if(self::$responseType == ResponseTypes::Json)
        {
            header('Content-Type: application/json');
            echo json_encode([$data]);
        }
        else
        {
            header('Content-Type: text/xml');
            echo $data;
        }
        exit;
    }



}