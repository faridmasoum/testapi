<?php
namespace RMIDatalink;

use Curl\Curl;

class Buckets {

    public function bucketNames()
    {
        $curl = new Curl();
        $path = $this->getPath("buckets.{$this->responseType}");
        $curl->setHeader('api_key', $this->apiKey);
        $curl->get($path);
        $result = json_decode($curl->response , true);
        $curl->close();
        foreach ($result['data'] as $bucket) {
            $bucketNames[]=$bucket['title'];
        }

        return $bucketNames;

    }
}