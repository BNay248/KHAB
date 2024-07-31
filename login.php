<?php
//read JSON
require 'vendor/autoload.php';

$data = json_decode(file_get_contents('php://input'), true);

//check for and create user directory
$data['username'] = hash('sha256', $data['username']);
$user = $data['username'];
$data['pin'] = hash('sha256', $data['pin']);
$pin = $data['pin'];
$client = new MongoDB\Client("mongodb://mongodb:27017");
$database = $client->selectDatabase('khab');
$collection = $database->selectCollection($user);

//check for user creds
$result = $collection->findOne(['username' => $user, 'pin' => $pin]);
if(!$result){
    echo json_encode(array('message' => 'user'));
    return;
}
echo json_encode(array('message' => 'good'));
?>
