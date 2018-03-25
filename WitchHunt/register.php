<!DOCTYPE html>
<html>
  <head>
    <title>Witch Hunt - Register</title>
  </head>
  <body>
    <?php
    $username = $_GET["username"];
    $password = $_GET["password"];
    $vpassword = $_GET["verified_pass"];

    if ($password != $vpassword) {
      echo "Passwords must match!";
    } else {
      $conn = new mysqli("localhost", "CEN4010_S2018g04", "cen4010_s2018", "CEN4010_S2018g04");
      $statement = "SELECT * FROM users WHERE username = '$username';";
      if (!$result = $conn->query($statement)) {
        echo "Cannot register <br>";
        echo "Query: " . $statement . "<br>";
        echo "Errno: " . $conn->errno . "<br>";
        echo "Error: " . $conn->error . "<br>";
      } else {
        if ($result->num_rows == 0) {
          $insert = "INSERT INTO users (username, password) VALUES ('$username', '$password');";
          if ($conn->query($insert)) {
            $conn->Close();
            //$page = file_get_contents("list.php");
            //echo $page;
            //$_SESSION["username"] = $username;
            //$_SESSION["password"] = $password;
            //include("list.php");
            echo "You registered!!"
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
