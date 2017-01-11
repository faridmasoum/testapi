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
use RMIDatalink\Fetch;
use RMIDatalink\Datalink;
use RMIDatalink\Enums\ResponseTypes;
use RMIDatalink\Enums\ResponseProducts;

use \Symfony\Component\VarDumper\Test\VarDumperTestTrait;

$config = [
	"api-path" => "http://rmiserver.rminno.com:8001/api",
	"limit" => 50,  																  	//limitation on all requests
	"access-key" => "z/uWekiobDEedhozKm6JntDkcHoUzKm6JntDkczKm6JntDkcaQ", //Datalink Access Key
	"bucket-name" => "faridConfigurableBucket", 										//bucket name
	"response-type" => ResponseTypes::Json, 											//response type of results
	"response-products" => ResponseProducts::All, 									    //type of products Just Simples/Just Configurable/ Configurable>Simple
];

$apiObject = new Fetch($config);

// required fields
$fields = ['id', 'title', 'images', 'additionalImages', 'productType'];

// get all products
$ConfigurableProducts = $apiObject->configurableProducts(0, $fields);

 
