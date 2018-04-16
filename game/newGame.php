<?php 
require_once './includes/config.php'; 
// This checks to make sure user is logged in, and redirects to index.php if not
require_once './includes/logged_in.php'; 
?>


<!DOCTYPE html>
<html>
  <head>
    <title>Witch Hunt - Matchmaking</title>
  </head>
  <body>
    <a href="waiting.php">Join a Public Game</a>
    <br/>
    <a href="findGame.php">Join a private game</a>
    <br/>
    <a href="privateGame.php">Create a private game</a>
  </body>
</html>
