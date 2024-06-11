<?php
//read JSON
$data = json_decode(file_get_contents('php://input'), true);

//check for and create user directory
$username = hash('sha256', $data['username']);
$filepath = './users/' . $username;
if(!(is_dir($filepath))){
	mkdir($filepath, 0666, true);
} else {
	$response = array(
    'message' => 'User already exists.',
	);
	echo json_encode($response['message']);
	return;
}

// Write JSON data to file
$file = fopen($filepath . '/cred.json', 'w');
fwrite($file, json_encode($data, JSON_PRETTY_PRINT));
fclose($file);

// Return response
$response = array(
    'message' => 'User has been created.',
);
echo json_encode($response['message']);
?>
