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
    <a href="newGame.php"><h2>Start New Game</h2></a>
    <h2>Instructions</h2>
    <h2>Standings</h2>


  </body>
</html>
