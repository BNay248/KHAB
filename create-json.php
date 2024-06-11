<?php
// Read JSON data from request body
$data = json_decode(file_get_contents('php://input'), true);

// Generate a unique filename
$fileName = md5(uniqid()) . '.json';

//Check for and create user directory
$username = hash('sha256', $data['username']);
if(!(is_dir('./users/' . $username))){
	mkdir('./users/' . $username, 0666, true);
}

// Write JSON data to file
$file = fopen($fileName, 'w');
fwrite($file, json_encode($data, JSON_PRETTY_PRINT));
fclose($file);

// Return response
$response = array(
    'message' => 'JSON file has been saved.',
    'fileName' => $fileName
);
echo json_encode($response);
?>
