# testapi#

RMI Datalink API

Installation
-----
```
composer require faridmasoum/testapi
```
or add
```
"faridmasoum/testapi": "*"
```
And run following command to download extension using **composer** 
```php
$ composer update
```
Basic setup
-----
Configuration
-----
Usage

Create an index.php file in root folder of project and insert these code on it.

-----
```php
require __DIR__ . '/vendor/autoload.php';

$api = new RMIDatalink\Fetch("{API ACCESS KEY}");
echo "First Bucket: ". $api->bucketNames()[0];


 
