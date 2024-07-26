<?php
//read JSON
require 'vendor/autoload.php';

$data = json_decode(file_get_contents('php://input'), true);

//check for and create user directory
$user = hash('sha256', $data['username']);
$client = new MongoDB\Client("mongodb://mongodb:27017");
$database = $client->selectDatabase('khab');
$collection = $database->selectCollection($user);

//check for user creds
$result = $collection->findOne(['title' => $data['title']]);
if($result){
    echo json_encode($result, JSON_PRETTY_PRINT);
    return;
}
//return error
header('Content-Type: application/json', true, 404);
echo json_encode(['error' => 'Recipe not found']);
?>
