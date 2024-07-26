<?php
// Include MongoDB PHP library
require 'vendor/autoload.php';

$data = json_decode(file_get_contents('php://input'), true);

// Check for and create user directory
$user = hash('sha256', $data['username']);
$client = new MongoDB\Client("mongodb://mongodb:27017");
$database = $client->selectDatabase('khab');
$collection = $database->selectCollection($user);

// Check for user creds
$result = $collection->find(['ingredients.name' => $data['ingredient']]);
$result = iterator_to_array($result);


if ($result) {
    // Return recipes as JSON
    echo json_encode($result, JSON_PRETTY_PRINT);
} else {
    // Return error if no recipes found
    header('Content-Type: application/json', true, 404);
    echo json_encode(['error' => 'No recipes with specified ingredient found.']);
}
?>

