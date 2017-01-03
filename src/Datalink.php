<?php
namespace RMIDatalink;

use Curl\Curl;

class Datalink
{
    public static $bucketId;
    protected static $classListMap;

    function __construct()
    {
        // constructor
    }


    public function buckets($fieldsList=[])
    {
        $route = "buckets.{$this->$responseType}";
        $result = $this->doCurl($route);

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

        $route = "buckets/{$this->$responseType}/classes.json";
        $result = $this->doCurl($route);

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
        if(empty(self::$bucketId)) return $this->customError('Bucket-ID is not defined');

        $route = "buckets/{$this->$responseType}/products.json?limit=$limit&skip=$offset";
        $result = $this->doCurl($route);

        $i=0;
        $products=[];
        if(count($fieldsList) == 0) $fieldsList = ['id', 'title', 'quantity', 'sku', 'shapeName'];

        foreach ($result['data'] as $product) {
            $productTmp=[];

            foreach ($fieldsList as $fieldList) {

                if(is_array($product[$fieldList]))
                {
                    $productArrayTmp = [];
                    foreach ($product[$fieldList] as $productDetailKey => $productDetailValue) {
                        $productArrayTmp[$productDetailKey] = $productDetailValue;
                    }
                    $productTmp[$fieldList] = $productArrayTmp;
                }
                else
                {
                    $productTmp[$fieldList]=$product[$fieldList];
                }


            }
            $products[] = $productTmp;
            $i++;
        }

        $result = $products;

        return $result;
    }


    public function productPackage()
    {


    }

}