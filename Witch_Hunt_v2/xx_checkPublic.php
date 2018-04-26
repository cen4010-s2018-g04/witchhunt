<?php
require_once './includes/config.php'; 
// This checks to make sure user is logged in, and redirects to index.php if not
require_once './includes/logged_in.php';
$username=$_SESSION["username"];

$statement1='SELECT * FROM waiting_for_game WHERE username="'.$username.'";';

if (!$result = $sqlcon->query($statement1)) {
      echo "Error fetching game data!";
    } else {
      if($result->num_rows==0){
        echo 1;
      }
      else{
		$curTime=time();
		$statement2='UPDATE waiting_for_game SET time_since_ping='.$curTime.' WHERE username="'.$username.'";';
		$sqlcon->query($statement2);
        echo 0;
      }
    }

?>