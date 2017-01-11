<?php
namespace RMIDatalink;

use RMIDatalink\Enums\ResponseProducts;
use RMIDatalink\Enums\ResponseTypes;
use RMIDatalink\Exceptions\BaseRuntimeException;

use Curl\Curl;

class Fetch extends Datalink // extends Buckets
{

    protected static $responseType;
    protected static $responseProducts;
    protected $apiPath;
    protected $apiKey;


    // get api key onload
    public function __construct(array $config)
    {
        $apiKey = $config["access-key"];
        $responseType = $config["response-type"];
        $bucketName = $config["bucket-name"];
        $responseProduct = $config["response-products"];
        $apiPath = $config["api-path"];

        // check Curl is installed on the server
        if (!extension_loaded('curl')) {
            // return
            self::customError('cURL library is not loaded');
        }

        if(empty($bucketName)) {
            self::customError('Please set the bucket name');
        }

        // check api key is set as parameter on new object
        if (is_null($apiKey)) {
            self::customError('apiKey is empty');
        }

        $this->apiPath = $apiPath."/%s/%s";
        $this->apiKey = $apiKey;
        self::$responseType = $responseType;

        //test connection
        $route = 'buckets.%RESPONSE%';
        $result = $this->doCurl($route);

        if(isset($result) == false)
            return self::customError('Could not access to Datalink, Please check your connection ');
        elseif(array_key_exists('status', $result) && $result['status'] == '500')
            return self::customError($result['message']);

        parent::__construct($bucketName);

    }


    protected function doCurl($route)
    {

        $curl = new Curl();
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
        $bucketId = self::getBucketId();
        $responseType = self::$responseType;

        $realRoute = str_replace("%RESPONSE%" ,$responseType, $route);
        $realRoute = str_replace("%BUCKET-ID%" ,$bucketId, $realRoute);

        return sprintf($this->apiPath, $base, $realRoute);
    }


    // Result > response result
    protected static function result($data)
    {
            return json_encode($data);
    }

    // search on array by custom key
    protected static function arraySearch($array, $key, $value)
    {
        $results = array();

        if (is_array($array)) {
            if (isset($array[$key]) && $array[$key] == $value) {
                $results[] = $array;
            }

            foreach ($array as $subarray) {
                $results = array_merge($results, search($subarray, $key, $value));
            }
        }

        return $results;
    }

    // Result > response error
    public static function customError($detail)
    {
        if(self::$responseType == ResponseTypes::Json) {
       //     header('Content-Type: application/json');
            echo json_encode(["Error" => $detail]);
        }
        else {
            header('Content-Type: text/xml');
            echo $detail;
        }
        exit;
    }

    public static function response($data)
    {
        if(self::$responseType == ResponseTypes::Json) {
            header('Content-Type: application/json');
            echo json_encode([$data]);
        } else {
            header('Content-Type: text/xml');
            echo $data;
        }
        exit;
    }



}