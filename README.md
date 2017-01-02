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
use RMIDatalink\Enums\ResponseTypes;



$apiObject = new Fetch("{ TOKEN }",ResponseTypes::Json);

// Set Bucket ID
$apiObject->setBucketId($apiObject->buckets()[0]->id);

// required fields
$fields = ['id', 'title', 'images', 'additionalImages'];

// get all products
$products = $apiObject->products(0, $fields);

// loop on all products > products(offset, fields, limit)
foreach($products as $product)
{
	echo "<br><h1>Product:</h1><br>";

	echo $product['id']."<br>";
	echo $product['title']."<br>";

	foreach($product['images'] as $image) {
		echo "<br>";
		foreach($image as $imageKey=>$imageValue)
		{
			echo "<br>$imageKey:$imageValue";
		}

	}

	foreach($product['additionalImages'] as $image) {
		echo "<br>";
		foreach($image as $additionalImageKey=>$additionalImageValue)
		{
		    echo "<br>$additionalImageKey:$additionalImageValue";
		}

	}

	 echo "<br>----------------------Next Product---------------------";

}

 
