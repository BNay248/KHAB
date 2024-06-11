<?php
//eead JSON
$data = json_decode(file_get_contents('php://input'), true);

//check for user creds
$username = hash('sha256', $data['username']);
if(!(is_dir('./users/' . $username))){
	echo 'user';
}
$jsonFile = file_get_contents('./users/' . $username . 'cred.json');
$array = json_decode($jsonData, true);
if($array['pin'] != $data['pin']){
	echo 'pin';
}
echo "good";
?>