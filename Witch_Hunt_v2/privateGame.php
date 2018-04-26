<?php 
require_once './includes/config.php'; 
// This checks to make sure user is logged in, and redirects to index.php if not
require_once './includes/logged_in.php';





?>


<!DOCTYPE html>
<html>
  <head>
    <title>Witch Hunt - Matchmaking</title>
      <?php
      require_once './includes/head.php';
      ?>
  </head>
  <body>
    <div id="main">
        <?php
        // Check to make sure user has not already created a game that has not finished
        if ((int)doesPrivateGameExist($user_id)==0){
        ?>
            <form id="private" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
              Game Name: <input type="text" name="game_name" value="Name your game"/>
              <br/>
              Min Number of Players: <select name="number_of_players">
                <option>5</option>
                <option>6</option>
                <option>7</option>
                <option>8</option>
                <option>9</option>
              </select>
              <br/>
              <input type="submit" value="Create Game"/>
            </form>
        <?php }else{ ?>
            <h2>You already have a game created.</h2>

        <?php } ?>
    </div>
  </body>
</html>
