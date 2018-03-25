<?php session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
    <title>Witch Hunt - Sign In</title>
  </head>
  <body>
    <?php
    //Handles Signing Users In

    $user = $_GET["username"];
    $pass = $_GET["password"];

    $con = new mysqli("localhost", "CEN4010_S2018g04", "cen4010_s2018", "CEN4010_S2018g04");
    $statement = "SELECT * FROM users WHERE username = '$user' AND password = '$pass';";
    if (!$result = $con->query($statement)) {
      echo "Cannot call a query!";
    } else {
      if ($result->num_rows > 0) {
        $_SESSION["username"] = $user;
        $_SESSION["password"] = $pass;
        //$page = file_get_contents("list.php");
        //echo $page;
        //include("list.php");

        $insert = "INSERT INTO game_data (username, isWitch, isDead, villagerVotes, isWitchesVictim) VALUES ('" . $_SESSION['username'] . "', '0', '0', '0', '0');";
        if ($con->query($insert)) {
          //Display the player's data from DB
          echo "Username: " . $_SESSION["username"] . "<br>";
          echo "Password: " . $_SESSION["password"] . "<br><br>";

          //Players will be pushed into a queue... or match if one is available
          echo '<form id="make_make" action="vote.php" method="get">
            <fieldset>
              <button type="submit" name="Game_Button">Join a match!</button>
            </fieldset>
          </form>';
        } else {
          echo "Couldn't add you to the game.";
        }
      }
    }
    $con->Close();
    ?>

    <!-- (php statement)
    //Matches users with other players (timeout test)

    /*$time = 0;
    while($time < 30) {
      usleep(1000000);
      $time++;
      echo "$time <br>";
    }
    echo "Timeout";*/
    -->
  </body>
</html>
