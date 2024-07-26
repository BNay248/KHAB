<?php
require 'vendor/autoload.php';
//read JSON
$data = json_decode(file_get_contents('php://input'), true);

//get username
$user = hash('sha256', $data['username']);
$newuser = hash('sha256', $data['newusername']);
$client = new MongoDB\Client("mongodb://mongodb:27017");
$database = $client->selectDatabase('khab');
$collection = $database->selectCollection($user);
$newusercoll = $database->selectCollection($newuser);
$checkuser = $newusercoll->findOne(['username' => $newuser]);
if(!$checkuser){
    echo json_encode(['message' => 'User not found.']);
    exit;
}
$recipe = $collection->findOne(['title' => $data['title']]);
if($recipe){
    try{
	$newusercoll->insertOne($collection->findOne(['title' => $data['title']]));
	echo json_encode(['message' => 'Recipe succesfully shared.']);
    } catch (Exception $e) {
	echo json_encode(['message' => 'User already has that recipe.']);
    }
} else {
    echo json_encode(['message' => 'Recipe not found.']);
}
?>
