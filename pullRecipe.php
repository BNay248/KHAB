<?php
//read JSON
$data = json_decode(file_get_contents('php://input'), true);

//get username
$username = hash('sha256', $data['username']);
$title = $data['title'];

//get file contents
$jsonFile = ('./users/' . $username . '/' . $title . '.json');
if (file_exists($jsonFile)) {
    $jsonData = file_get_contents($jsonFile);
    header('Content-Type: application/json');
    
    //return recipe
    echo $jsonData;
} else {
    //return error
    header('Content-Type: application/json', true, 404);
    echo json_encode(['error' => 'Recipe not found']);
}
?>