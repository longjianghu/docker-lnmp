<?php
try {
	$manager = new MongoDB\Driver\Manager("mongodb://root:123456@172.17.0.1:27017");

	$filter = ['x' => ['$gt' => 1]];
	$options = [
		'projection' => ['_id' => 0],
		'sort' => ['x' => -1],
	];

	$query = new MongoDB\Driver\Query($filter, $options);
	$cursor = $manager->executeQuery('db.collection', $query);

	$data = [];
	
	foreach ($cursor as $document) {
		$data[] = $document;
	}
	
	echo '<pre>';
	print_r($data);
	echo '</pre>';
	
	if( ! empty($data)){
		throw new \Exception('Success');
	}
	
	$bulk = new MongoDB\Driver\BulkWrite;
	$bulk->insert(['x' => 1]);
	$bulk->insert(['x' => 2]);
	$bulk->insert(['x' => 3]);
	$manager->executeBulkWrite('db.collection', $bulk);
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}