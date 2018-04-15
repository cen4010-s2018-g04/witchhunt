<?php
require_once './includes/config.php';

// This checks to make sure user is logged in, and redirects to index.php if not
require_once './includes/logged_in.php';

// If we get here, user has been logged in
?>

<!DOCTYPE html>
<html>
  <head>
      <title><?php echo $title;?></title>
  </head>
  <body>
    <h1>Witch Hunt</h1>
    <?php

    //Generate New Game below
    //User Creates a new game (similar to host game)
    //Users can join game?

    //Sample data
    $gameid = 1;
    $gameName = "My Game";
    $creator = "$_SESSION['username']";

    //New insert entry for the game table
    $query = "INSERT INTO Games (Game_ID, Game_Name, Creator) VALUES (?, ?, ?)";

    //Makes sure connection is possible
    if ($stmt = mysqli_prepare($sqlcon, $query)) {
      mysqli_stmt_bind_param($stmt, "sss", $param_gameid, $param_gameName, $param_creator);

      //Assigns parameters their values
      $param_gameid = $gameid;
      $param_gameName = $gameName;
      $param_creator = $creator;

      //Attempts to execute create the table
      if (mysqli_stmt_execute($stmt)) {
        echo "<h5>A new game was created</h5>";
      } else {
        echo "Could not create a new game.";
      }
    }
    ?>
  </body>
</html>
