<?php

$data = json_decode(file_get_contents('php://input'), true);
$keyword = $data['keyword'];
$directory = './users/' . hash('sha256', $data['directory']);
$recipeString = "";
//check for dir
if (!is_dir($directory)) {
	echo "You don't have any recipes!";
	return;
}

$dir = opendir($directory);

if (!$dir) {
	echo "Failed to open dir.";
	return;
}

//search through files
while (($file = readdir($dir)) !== false) {
	//skip non-recipes
	if ($file === '.' || $file === '..' ||$file === 'cred.json') {
		continue;
	}

	//get .json files
	$filePath = $directory . "/" . $file;
	if (is_file($filePath) && pathinfo($filePath, PATHINFO_EXTENSION) === 'json') {
		//read json
		$json = json_decode(file_get_contents($filePath), true);
		//search all ingredients
		foreach ($json['ingredients'] as $ingredient) {
			if (isset($ingredient['name']) && stripos($ingredient['name'], $keyword) !== false) {
				$recipeString .= $json['title'] . ", ";
				break;
			}
		}
	}
}
closedir($dir);
echo json_encode(['recipes' => $recipeString]);
?>