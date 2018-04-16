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
    <form id="Game" action="private_wait.php" method="POST">
      Game Name: <input type="text" name="game_name" value="Name your game"/>
      <br/>
      <input type="submit" value="Join Game"/>
    </form>
  </body>
</html>
