<?php 
require_once './includes/config.php'; 

// This checks to make sure user is logged in, and redirects to index.php if not
require_once './includes/logged_in.php'; 
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Witch Hunt - Match</title>
  </head>
  <body>
    <?php

    $statement = "SELECT * FROM game_data;";
    if (!$result = $sqlcon->query($statement)) {
      echo "Error fetching game data!";
    } else {
      if ($result->num_rows > 0) {
        //echo ""
        echo "Sucess!"
      }
    }
    ?>
  </body>
</html>
