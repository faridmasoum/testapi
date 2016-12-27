<?php
namespace RMIDatalink;

use Fetch;
use Enums;
use Curl;

class Buckets extends Fetch
{

    public function bucketName()
    {
        $curl = new Curl();
        $path = getPath("buckets.{$this->$responseType}");
        $result = json_decode($curl->get($path), true);
        return $result['data']['title'];
    }

}