<?php
//read JSON
require 'vendor/autoload.php';

$data = json_decode(file_get_contents('php://input'), true);

//check for and create user directory
$user = hash('sha256', $data['username']);
$client = new MongoDB\Client("mongodb://mongodb:27017");
$database = $client->selectDatabase('khab');
$collection = $database->selectCollection($user);

$check = $collection->findOne(['title' => $data['title']]);
if($check){
	echo json_encode(['message' => 'Recipe already exists. Please use edit feature to modify. Or, if this is a new recipe, change the name.']);
	return;
}
$collection->insertOne($data);
echo json_encode(['message' => 'Recipe has been created.']);
?>
