<?php
header('Content-Type: application/json');

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['search_food']) && !empty($_POST['search_food'])) {
        $search_food = $_POST['search_food'];
        $api_url = "https://www.themealdb.com/api/json/v1/1/search.php?s={$search_food}";
        $meal_data = file_get_contents($api_url);
        $meals = json_decode($meal_data, true);

        if ($meals && isset($meals['meals'])) {
            echo json_encode($meals);
        } else {
            echo json_encode(['meals' => []]);
        }
    } else {
        echo json_encode(['meals' => []]);
    }
}
?>
