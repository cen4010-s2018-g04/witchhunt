<!DOCTYPE html>
<html>
  <head>
    <title>Witch Hunt - Match</title>
  </head>
  <body>
    <?php

    //DB connection
    $con = new mysqli("localhost", "CEN4010_S2018g04", "cen4010_s2018", "CEN4010_S2018g04");
    //Show players that aren't dead and don't show the player
    $statement = "SELECT * FROM game_data WHERE isDead = 0 AND username != " . $_SESSION['username'] . ";";
    if (!$result = $con->query($statement)) {
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
          echo '<input type="radio" name="vote" value="'. $rowItem['username'] .'" id="'. $rowItem['username'] .'">';
          echo '<label for="'.$rowItem['username'].'">'.$rowItem['username'].'</label>';
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
      }
    }
    ?>
  </body>
</html>
