<!DOCTYPE html>
<html>
  <head>
    <title>Witch Hunt - Register</title>
  </head>
  <body>
    <?php
    //Gets data from form
    $username = $_GET["username"];
    $password = $_GET["password"];
    $vpassword = $_GET["verified_pass"];

    if ($password != $vpassword) {
      echo "Passwords must match!";
    } else {
      //Connect to the DB
      $conn = new mysqli("localhost", "CEN4010_S2018g04", "cen4010_s2018", "CEN4010_S2018g04");
      $statement = "SELECT * FROM users WHERE username = '$username';";
      //Makes sure there are no errors connecting to DB
      if (!$result = $conn->query($statement)) {
        echo "Cannot register <br>";
        echo "Query: " . $statement . "<br>";
        echo "Errno: " . $conn->errno . "<br>";
        echo "Error: " . $conn->error . "<br>";
      } else {
        //If no similar combination, user can be created
        if ($result->num_rows == 0) {
          $insert = "INSERT INTO users (username, password) VALUES ('$username', '$password');";
          if ($conn->query($insert)) {
            $conn->Close();
            //$page = file_get_contents("list.php");
            //echo $page;
            //$_SESSION["username"] = $user;
            //$_SESSION["password"] = $pass;
            //include("list.php");
            echo "You registered (click back to sign in)!!";
          } else {
            echo "Query didn't work.";
            $conn->Close();
          }
        }
      }
    }
    ?>
  </body>
</html>
