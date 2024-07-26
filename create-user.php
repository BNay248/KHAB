<?php
//read JSON
require 'vendor/autoload.php';

$data = json_decode(file_get_contents('php://input'), true);

//check for and create user directory
$data['username'] = hash('sha256', $data['username']);
$user = $data['username'];
$data['pin'] = hash('sha256', $data['pin']);

$client = new MongoDB\Client("mongodb://mongodb:27017");
$database = $client->selectDatabase('khab');
$collection = $database->selectCollection($user);

$collections = $database->listCollections();
foreach ($collections as $coll) {
        if ($coll->getName() === $user) {
                $response = array(
                'message' => 'User already exists.',
                );
                echo json_encode($response['message']);
                exit;
        }
}

$result = $collection->insertOne($data);

//return
$response = array(
    'message' => 'User has been created.',
);
echo json_encode($response['message']);
?>

