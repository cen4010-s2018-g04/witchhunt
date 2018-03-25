<?php session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
    <title>Witch Hunt - Match</title>
  </head>
  <body>
    <?php

    $con = new mysqli("localhost", "CEN4010_S2018g04", "cen4010_s2018", "CEN4010_S2018g04");
    $statement = "SELECT * FROM game_data;";
    if (!$result = $con->query($statement)) {
      echo "Error fetching game data!";
    } else {
      if ($result->num_rows > 0) {
        //echo ""
        echo "Success!"
      }
    }
    ?>
  </body>
</html>
