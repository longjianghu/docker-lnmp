<?php
try {
	$manager = new MongoDB\Driver\Manager("mongodb://root:123456@172.17.0.1:27017");

	$bulk = new MongoDB\Driver\BulkWrite;
	$bulk->insert(['x' => 1]);
	$bulk->insert(['x' => 2]);
	$bulk->insert(['x' => 3]);
	$manager->executeBulkWrite('db.collection', $bulk);

	$filter = ['x' => ['$gt' => 1]];
	$options = [
		'projection' => ['_id' => 0],
		'sort' => ['x' => -1],
	];

	$query = new MongoDB\Driver\Query($filter, $options);
	$cursor = $manager->executeQuery('db.collection', $query);

	foreach ($cursor as $document) {
		var_dump($document);
	}
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}