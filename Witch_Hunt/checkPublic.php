<?php
require_once './includes/config.php'; 
// This checks to make sure user is logged in, and redirects to index.php if not
require_once './includes/logged_in.php';
$username=$_SESSION["username"];

$statement='SELECT * FROM waiting_for_game WHERE username="'.$username.'";';

if (!$result = $sqlcon->query($statement)) {
      echo "Error fetching game data!";
    } else {
      if($result->num_rows<1){
        echo 1;
      }
      else{
        echo 0;
      }
    }

?>