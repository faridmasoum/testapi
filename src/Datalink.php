<?php
namespace RMIDatalink;

use Curl\Curl;

class Datalink
{
    protected static $bucketList=[];
    protected static $classList=[];

    protected static $bucketId;
    public static $bucketName;

    function __construct($bucketName)
    {
        self::$bucketList = $this->getBuckets();
        self::$bucketId = $this->setBucketId($bucketName);

        self::$classList = $this->getClasses();
    }


    private function buckets($offset=0, $fieldsList=[], $limit=30)
    {
        $route = 'buckets.%RESPONSE%'."?limit=$limit&skip=$offset";;
        $result = $this->doCurl($route);

        $count = $result["metadata"]["count"];

        $i = 0;
        $buckets = [];
        if (count($fieldsList) == 0) $fieldsList = ['id', 'title'];

        foreach ($result['data'] as $bucket) {
            $bucketTmp = [];

            foreach ($fieldsList as $fieldList) {
                $bucketTmp[$fieldList] = $bucket[$fieldList];
            }

            $buckets[] = $bucketTmp;

            $i++;
        }

        return ["count" =>  $count, "result" => $buckets];
    }

    public function getBuckets()
    {
        $limit=50;
        $offset=0;
        $response = [];
        do {
            $results = $this->buckets($offset);
            foreach($results["result"] as $result) {
                $response[] = $result;
            }
            $offset=+$limit;
            $count=$results["count"];
        } while($count>0);

        return $response;
    }



    private function classes($offset=0, $fieldsList=[], $limit=30)
    {
        $route = 'buckets/%BUCKET-ID%/classes.%RESPONSE%'."?limit=$limit&skip=$offset";;
        $result = $this->doCurl($route);

        $count = $result["metadata"]["count"];

        $i=0;
        $classes=[];
        if(count($fieldsList) == 0) $fieldsList = ['id', 'class'];
        foreach ($result['data'] as $class) {
            $classTmp=[];

            foreach ($fieldsList as $fieldList) {
                $classTmp[$fieldList] = $class[$fieldList];
            }

            $classes[] = $classTmp;

            $i++;
        }

        return ["count" =>  $count, "result" => $classes];
    }

    public function getClasses($offset=0, $fieldsList=[], $limit=30)
    {
        $limit=50;
        $offset=0;
        $response = [];
        do {
            $results = $this->classes($offset);
            foreach($results["result"] as $result) {
                $response[] = $result;
            }
            $offset=+$limit;
            $count=$results["count"];
        } while($count>0);

        return $response;
    }


    // API > set bucket id
    public function setBucketId($bucketName)
    {
        $bucketId = "";
        foreach (self::$bucketList as $bucket) {
            $bucketTitle = $bucket['title'];
            if($bucketName == $bucketTitle)
                $bucketId = $bucket['id'];
        }
        return $bucketId;
    }

    // API > set bucket id
    public function getBucketId()
    {
        return self::$bucketId;
    }


    public function configurableProducts($offset=0, $fieldsList=[] , $limit=50)
    {
        $route = 'buckets/%BUCKET-ID%/products.%RESPONSE%'."?limit=$limit&skip=$offset";
        $result = $this->doCurl($route);

        $i=0;
        $products=[];
        if(count($fieldsList) == 0) $fieldsList = ['id', 'title', 'quantity', 'sku', 'shapeName'];

        foreach ($result['data'] as $product) {
            $productTmp=[];

            foreach ($fieldsList as $fieldList) {

                if(is_array($product[$fieldList])) {
                    $productArrayTmp = [];
                    foreach ($product[$fieldList] as $productDetailKey => $productDetailValue) {
                        $productArrayTmp[$productDetailKey] = $productDetailValue;
                    }
                    $productTmp[$fieldList] = $productArrayTmp;
                } else {
                    $productTmp[$fieldList]=$product[$fieldList];
                }


            }

            $products[] = $productTmp;
            $i++;
        }

        $result = $products;

        return $result;
    }


    public function simpleProducts($configurableId, $offset=0, $fieldsList=[] , $limit=50)
    {
        $route = 'buckets/%BUCKET-ID%/products.%RESPONSE%'."?limit=$limit&skip=$offset";
        $result = $this->doCurl($route);

        $i=0;
        $products=[];
        if(count($fieldsList) == 0) $fieldsList = ['id', 'title', 'quantity', 'sku', 'shapeName'];

        foreach ($result['data'] as $product) {
            $productTmp=[];

            foreach ($fieldsList as $fieldList) {

                if(is_array($product[$fieldList])) {
                    $productArrayTmp = [];
                    foreach ($product[$fieldList] as $productDetailKey => $productDetailValue) {
                        $productArrayTmp[$productDetailKey] = $productDetailValue;
                    }
                    $productTmp[$fieldList] = $productArrayTmp;
                } else {
                    $productTmp[$fieldList]=$product[$fieldList];
                }


            }

            $products[] = $productTmp;
            $i++;
        }

        $result = $products;

        return $result;
    }

}