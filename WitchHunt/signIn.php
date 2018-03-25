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
        $con->Close();
        //$page = file_get_contents("list.php");
        //echo $page;
        //include("list.php");
        echo "Username: " . $_SESSION["username"] . "<br>";
        echo "Password: " . $_SESSION["password"] . "<br><br>";
      }
    }

    //Players will be pushed into a queue... or match if one is available
    echo '<button type="submit" name="Game_Button" action="game">Click here to join a match!</button>';

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
