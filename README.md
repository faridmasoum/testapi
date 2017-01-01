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




$apiObject = new Fetch("{ DATALINK TOKEN }",ResponseTypes::Json);

// Set Bucket ID
$apiObject->setBucketId($apiObject->buckets()[0]->id);

// required fields
$fields = ['id', 'title', 'images', 'additionalImages'];


// get all products
// loop on all products > products(offset, fields, limit)
$products = $apiObject->products(0, $fields);


foreach($products as $product)
{
	echo "<br><h1>Product:</h1><br>";

	// loop on required fields
	foreach ($fields as $field)
	{
		if(is_object($product->$field))
		{
			// loop on object
			foreach($product->$field as $attributes)
			{
				// if the field contains nested object

				//current field Name
				echo "<strong>Object Field: $field </strong><br>";
				foreach($attributes as $FieldName => $FieldValue)
				{
					echo "$FieldName: $FieldValue";
					echo "<br>";
				}
				echo "<br>";
			}

		}
		else
		{
			echo "<strong>String Field: $field </strong><br>";
			echo "{$product->$field} <br><br>";
		}

	}

	 echo "----------------------Next Product---------------------";

}

 
