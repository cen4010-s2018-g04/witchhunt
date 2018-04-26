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

    //Show players that aren't dead and don't show the player
    $statement = "SELECT * FROM game_data INNER JOIN users ON user_id = user_id_f WHERE isDead = 0 AND user_id_f != " . $user_id . ";";
    if (!$result = $sqlcon->query($statement)) {
      echo "Error fetching game data!";
    } else {
      if ($result->num_rows > 0) {
        //Display vote screen
        echo "<h4>You are</h4>
        <h1>A Villager</h1>
        <h5>Who is the Witch?</h5>";

        echo '<form id="vote" action="results.php" method="get">';
        echo "<div>";
        while($rowItem = mysqli_fetch_array($result)){
          echo '<input type="radio" name="vote" value="'. $rowItem['user_id'] .'" id="'. $rowItem['user_id'] .'">';
          echo '<label for="'.$rowItem['user_id'].'">'.$rowItem['username'].'</label>';
        }
        echo "</div>";
        echo "<div>";
        //Submits which player was killed (voted)
        echo '<button type="submit" name="Vote_Button">Vote!</button>';
        echo "</div>";
        echo "</form>";


        /*<div>
    <input type="radio" id="contactChoice1"
     name="contact" value="email">
    <label for="contactChoice1">Email</label>

    <input type="radio" id="contactChoice2"
     name="contact" value="phone">
    <label for="contactChoice2">Phone</label>

    <input type="radio" id="contactChoice3"
     name="contact" value="mail">
    <label for="contactChoice3">Mail</label>
  </div>
  <div>
    <button type="submit">Submit</button>
  </div>*/
      }else{
          echo "<h4>not enough players.</h4>";
      }
    }
    ?>
  </body>
</html>
