<?php
//eead JSON
$data = json_decode(file_get_contents('php://input'), true);

//generate filename
$username = hash('sha256', $data['username']);
if($data['title'] == 'cred'){
	$response = array(
	'message' => 'Cannot create recipe titled cred.',
	);
}
echo json_encode($response['message']);
$fileName = "./users/" . $username . "/" . $data['title'] . ".json";

//create json file
$file = fopen($fileName, 'w');
fwrite($file, json_encode($data, JSON_PRETTY_PRINT));
fclose($file);

$response = array(
'message' => 'Recipe has been created.',
);
echo json_encode($response['message']);
?>
