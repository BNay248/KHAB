<?php
//eead JSON
$data = json_decode(file_get_contents('php://input'), true);

//generate filename
$fileName = $data['recipeName'];

//check for user creds
$username = hash('sha256', $data['username']);
if(!(is_dir('./users/' . $username))){
	echo 'User does not exist';
}
$jsonFile = file_get_contents('./users/' . $username . 'cred.json');
$array = json_decode($jsonData, true);
if($array['pin'] != $data['pin']){
	echo 'Incorrect Pin'
}

//create json file
$file = fopen($fileName, 'w');
fwrite($file, json_encode($data, JSON_PRETTY_PRINT));
fclose($file);

echo 'User has been created';
?>