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
    <form id="Game" action="add_to_private_wait.php" method="POST">
      Game Name: <input type="text" name="game_name" value="Name your game"/>
      <br/>
      Max Number of Players: <select name="number_of_players">
        <option>5</option>
        <option>6</option>
        <option>7</option>
        <option>8</option>
        <option>9</option>
      </select>
      <br/>
      <input type="submit" value="Create Game"/>
    </form>
  </body>
</html>
