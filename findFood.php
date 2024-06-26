<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>PHP SERVER</title>
  <link rel="stylesheet" href="./style.css">
  <link rel="icon" href="./favicon.ico" type="image/x-icon">
</head>
  <main>
  <div class="header">
   <ul class="navbar">
  <li><a href="index.html">Home</a></li>
  <li><a href="recipes.html">My Recipes</a></li>
  <li><a href="findFood.php">Browse</a></li>
  <li><a href="./users">My Profile</a></li>
</ul>
</br>
</div>
    <h1>Search for ner recipes here</h1>
    <div class="formbold-main-wrapper">
</div>
    <?php
   

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (isset($_POST['search_food']) && !empty($_POST['search_food'])) {
        $search_food = $_POST['search_food'];
        $api_url = "https://www.themealdb.com/api/json/v1/1/search.php?s={$search_food}";
        $meal_data = file_get_contents($api_url);
        $meals = json_decode($meal_data, true);

        if ($meals && isset($meals['meals'])) {
          echo "<h3>Search results for '{$search_food}':</h3>";
          echo '<ul>';
          foreach ($meals['meals'] as $meal) {
            echo '<li>' . $meal['strMeal'] . ' <button onclick="loadRecipe(\'' . $meal['idMeal'] . '\')">Load Recipe</button></li>';
          }
          echo '</ul>';
        } else {
          echo '<p>No meals found for \'' . $search_food . '\'</p>';
        }
      } else {
        echo '<p>Please enter a food name to search.</p>';
      }
    }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <label for="search_food">Search meals by name:</label>
      <input type="text" id="search_food" name="search_food" required>
      <button type="submit">Search</button>
    </form>

    <div id="recipe_details"></div>


    <script>
      function loadRecipe(mealId) {
        var apiUrl = 'https://www.themealdb.com/api/json/v1/1/lookup.php?i=' + mealId;
        fetch(apiUrl)
          .then(response => response.json())
          .then(data => {
            if (data.meals && data.meals.length > 0) {
              var meal = data.meals[0];
              var recipeDetails = document.getElementById('recipe_details');
              recipeDetails.innerHTML = '<h3>Recipe for ' + meal.strMeal + ':</h3>' +
                '<p>' + meal.strInstructions + '</p>' +
                '<p><strong>Category:</strong> ' + meal.strCategory + '</p>' +
                '<p><strong>Area:</strong> ' + meal.strArea + '</p>' +
                '<img src="' + meal.strMealThumb + '" alt="' + meal.strMeal + '" style="max-width: 300px;">';
            } else {
              alert('Recipe not found.');
            }
          })
          .catch(error => {
            console.error('Error fetching recipe:', error);
            alert('Error fetching recipe. Please try again later.');
          });
      }
    </script>
  </main>
</html>
