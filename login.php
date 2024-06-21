<?php
//read JSON
$data = json_decode(file_get_contents('php://input'), true);

//check for user creds
$username = hash('sha256', $data['username']);
if(!(is_dir('./users/' . $username))){
	$response = array(
    'message' => 'user',
	);
	echo json_encode($response['message']);
	return;
}
//check for pin validity
$jsonFile = file_get_contents('./users/' . $username . '/cred.json');
$array = json_decode($jsonFile, true);
if($array['pin'] != $data['pin']){
	$response = array(
    'message' => 'pin',
	);
	echo json_encode($response['message']);
	return;
}
//good response
$response = array(
'message' => 'good',
);
echo json_encode($response['message']);
?>