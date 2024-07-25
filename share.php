<?php
//read JSON
$data = json_decode(file_get_contents('php://input'), true);

//get username
$username = hash('sha256', $data['username']);
$newusername = hash('sha256', $data['newusername']);
$title = $data['title'];

//get file contents
$jsonFile = ('./users/' . $username . '/' . $title . '.json');
if (file_exists($jsonFile) && $title != 'cred') {
	if(!(is_dir('./users/' . $newusername))){
	$response = array(
    'message' => 'user',
	);
	echo json_encode($response['message']);
	return;
	}
    $pasteName = "./users/" . $newusername . "/" . $data['title'] . ".json";
	
	//create json file
	copy($jsonFile, $pasteName);
	$response = array(
    'message' => 'Recipe Copied',
	);
	echo json_encode($response['message']);
	return;
} else {
    //return error
    $response = array(
    'message' => 'Recipe was not Found',
	);
	echo json_encode($response['message']);
	return;
}
?>
