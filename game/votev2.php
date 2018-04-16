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
	$username=$_SESSION["username"];
    //Show players that aren't dead and don't show the player
    $statement = 'SELECT * FROM game_players WHERE username="'.$username.'" and alive=1;';
    if (!$result = $sqlcon->query($statement)) {
      echo "Error fetching game data!";
    } else {
      if ($result->num_rows > 0) {
		$array=$result->fetch_assoc();
		$isWitch=$array["witch"];
	  $gameID=$array["id"];
	  $statement1='SELECT * FROM game_players WHERE id="'.$gameID.'" and alive=1;';
	  $result=$sqlcon->query($statement1);
        //Display vote screen
        echo "<h4>You are</h4><br/>";
		if (!$isWitch){
        echo "<h1>A Villager</h1><br/>";
		echo "<h3>Who is the Witch?</h3><br/>";
		}
		else{
		  echo "<h1>The Witch</h1><br/>";
		  echo "<h3>Who will you kill?</h3><br/>";
		}
        
        echo '<form id="vote" action="castVote.php" method="POST">';
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
      }else{
          echo "<h4>not enough players.</h4>";
      }
    }
    ?>
  </body>
</html>
