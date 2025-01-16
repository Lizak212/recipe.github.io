<!DOCTYPE html>
<html>
<head>

</head>
  <title>Recipe Manager</title>
  <style>
    body {
      display: flex; 
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }
    form {
      border: 1px solid black;
      background-color: #f2f2f2;
      padding: 5px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }
    table, th, td {
      border: 1px solid #ddd;
    }
    th, td {
      padding: 12px;
      text-align: left;
    }
    th {
      background-color: #f2f2f2;
    }
    tr {
      background-color: #f9f9f9;
    }
  </style>
<body>
  <h1>Recipe Manager</h1>

  <?php
  $db = new SQLite3 ("recipe.db");

  // so that the tables will only be made once
  $start = $db->query ("SELECT name FROM sqlite_master WHERE type = 'table' AND name = 'recipes'");

  if (!$start->fetchArray ()) {
    $db->exec ("DROP TABLE IF EXISTS recipes");
    $db->exec ("CREATE TABLE IF NOT EXISTS recipes (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT, description TEXT)");

    $db->exec ("DROP TABLE IF EXISTS ingrediants");
    $db->exec ("CREATE TABLE IF NOT EXISTS ingrediants (id INTEGER PRIMARY KEY AUTOINCREMENT, recipe_id INTEGER, name TEXT, quantity TEXT, FOREIGN KEY (recipe_id) REFERENCES recipes (id))");

    $db->exec ("INSERT INTO recipes (name, description) VALUES ('Pizza', 'A dish of Italien origin')");
    $db->exec ("INSERT INTO ingrediants (recipe_id, name, quantity) VALUES (1, 'pizza dough', '1 cup')");
    $db->exec ("INSERT INTO ingrediants (recipe_id, name, quantity) VALUES (1, 'tomato sauce', '3 cups')");
    $db->exec ("INSERT INTO ingrediants (recipe_id, name, quantity) VALUES (1, 'cheese', '2 cups')");

    $db->exec ("INSERT INTO recipes (name, description) VALUES ('Pasta', 'An easy and popular dish')");
    $db->exec ("INSERT INTO ingrediants (recipe_id, name, quantity) VALUES (2, 'pasta', '5 cups')");
    $db->exec ("INSERT INTO ingrediants (recipe_id, name, quantity) VALUES (2, 'salt', '1 tsp')");
    $db->exec ("INSERT INTO ingrediants (recipe_id, name, quantity) VALUES (2, 'tomato sauce', '3 cups')");
  }

  if (isset ($_POST ["submit_r"])){
    $name = $_POST ["recipe"];
    $description = $_POST ["description"];

    $db->exec ("INSERT INTO recipes (name, description) VALUES ('$name', '$description')");
  }

  if (isset ($_POST ["submit_i"])){
    $name = $_POST ["ingre"];
    $quantity = $_POST ["quantity"];
    $recipe_id = $_POST ["recipe_id"];

    $db->exec ("INSERT INTO ingrediants (recipe_id, name, quantity) VALUES ('$recipe_id', '$name', '$quantity')");
  }

  $result = $db->query ("SELECT * FROM recipes");

  echo "<h2>Add Recipe</h2>";

  echo "<form method= 'POST'>
    <label> Add Recipe </label>
    <input type = 'text' name = 'recipe'>

    <label> Add Description </label>
    <input type = 'text' name = 'description'>

    <input type = 'submit' name = 'submit_r'>
  </form>";

  echo "<h2>Add Ingredient</h2>"; 

  echo "<form method= 'POST'>
    <label> What is the recipe id? </label>
    <input type = 'text' name = 'recipe_id'>

    <label> Ingredient name </label>
    <input type = 'text' name = 'ingre'>

    <label> Quantity </label>
    <input type = 'text' name = 'quantity'>

    <input type = 'submit' name = 'submit_i'>
  </form>";

  echo "<h2>All Recipes</h2>";

  While ($row = $result->fetchArray (SQLITE3_ASSOC)){
    echo "<h3>". $row ["name"] . "</h3>";
    echo "<p>". $row ["description"] . "</p>";

    $result2 = $db->query ("SELECT * FROM ingrediants WHERE recipe_id = " . $row["id"]);

    echo "<table>";
    echo "<tr>";
    echo "<th>Name</th>";
    echo "<th>Quantity</th>";
    echo "</tr>";

    While ($row2 = $result2->fetchArray (SQLITE3_ASSOC)){
      echo "<tr>";
      echo "<td>". $row2 ["name"] . "</td>";
      echo "<td>". $row2 ["quantity"] . "</td>";
      echo "</tr>";
    }

    echo "</table>";
  }
  ?>
</body>
</html>


  

</body>
</html>
 
