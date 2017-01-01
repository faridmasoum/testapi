<?php
namespace RMIDatalink;

use Curl\Curl;
use RMIDatalink\Fetch;

class Datalink
{
    public static $bucketId;

    public function buckets($fieldsList=[])
    {
        $curl = new Curl();
        $responseType = Fetch::$responseType;
        $route = "buckets.{$responseType}";
        $path = $this->getPath($route);
        $curl->setHeader('api_key', $this->apiKey);
        $curl->get($path);
        $result = json_decode($curl->response , true);
        $curl->close();

        $i=0;
        $buckets=[];
        if(count($fieldsList) == 0) $fieldsList = ['id', 'title'];

        foreach ($result['data'] as $bucket) {
            $bucketTmp=[];

            foreach ($fieldsList as $fieldList) {
                $bucketTmp[$fieldList]=$bucket[$fieldList];
            }

            $buckets[] = (object)$bucketTmp;

            $i++;
        }
        $result = $buckets;

        return $result;
    }

    public function classes($offset=0, $fieldsList=[], $limit=30)
    {
        $curl = new Curl();
        $bucketId = self::$bucketId;
        $route = "buckets/{$bucketId}/classes.json?limit=$limit&skip=$offset";
        $path = $this->getPath($route);
        $curl->setHeader('api_key', $this->apiKey);
        $curl->get($path);
        $result = json_decode($curl->response , true);
        $curl->close();

        $i=0;
        $classes=[];
        if(count($fieldsList) == 0) $fieldsList = ['id', 'class'];
        foreach ($result['data'] as $class) {
            $bucketTmp=[];

            foreach ($fieldsList as $fieldList) {
                $bucketTmp[$fieldList]=$class[$fieldList];
            }

            $classes[] = (object)$bucketTmp;

            $i++;
        }
        $result = $classes;

        return $result;
    }

    // API > set bucket id
    public function setBucketId($bucketID)
    {
        self::$bucketId = $bucketID;
    }

    // API > set bucket id
    public function getBucketId()
    {
        return self::$bucketId;
    }


    public function products($offset=0, $fieldsList=[] , $limit=50)
    {
        if(empty(self::$bucketId)) return Fetch::customError('Bucket-ID is not defined');

        $curl = new Curl();
        $bucketId = self::$bucketId;
        $route = "buckets/{$bucketId}/products.json?limit=$limit&skip=$offset";
        $path = $this->getPath($route);
        $curl->setHeader('api_key', $this->apiKey);
        $curl->get($path);
        $result = json_decode($curl->response , true);
        $curl->close();

        $i=0;
        $products=[];
        if(count($fieldsList) == 0) $fieldsList = ['id', 'title', 'quantity', 'sku', 'shapeName'];

        foreach ($result['data'] as $product) {
            $productTmp=[];

            foreach ($fieldsList as $fieldList) {

                if(is_array($product[$fieldList]))
                {
                    $productArrayTmp = [];
                    foreach ($product[$fieldList] as $productDetailArray) {
                        $productArrayTmp[] = (object)$productDetailArray;
                    }
                    $productTmp[$fieldList] = (object)$productArrayTmp;
                }
                else
                {
                    $productTmp[$fieldList]=$product[$fieldList];
                }


            }
            $products[] = (object)$productTmp;
            $i++;
        }

        $result = $products;

        return $result;
    }


    public function productPackage()
    {

    }

}