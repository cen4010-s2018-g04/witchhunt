<?php
require_once './includes/config.php'; 
// This checks to make sure user is logged in, and redirects to index.php if not
require_once './includes/logged_in.php';
$username=$_SESSION["username"];

try{
$statement1='SELECT * FROM waiting_for_game WHERE username="'.$username.'";';

if (!$result = $sqlcon->query($statement1)) {
      echo "Error fetching game data!";
    } 
    else {
      if ($result->num_rows>0){
        $game_name=mysqli_fetch_array($result)["game_name"];
		$curTime=time();
		$statement9='UPDATE waiting_for_game SET time_since_ping='.$curTime.' WHERE username="'.$username.'";';
		$sqlcon->query($statement9);
      }
      else{
        echo "no game_name";
      }
      $statement2='SELECT * FROM waiting_for_game WHERE game_name="'.$game_name.'";';
      if(!$result = $sqlcon->query($statement2)){
          echo "Error fetching wait data!";
      } else{
          if($result->num_rows>0){
          $array=$result->fetch_assoc();
          
          for($i=0;$i<$result->num_rows;$i++){
              $array=$result->fetch_assoc();
              $name=$array["username"];
              echo $name."<br/>";
          }
          }
          else{
              echo "no Rows";
          }
          //echo $array;
      }
      }
      
}
catch (Exception $e){
    echo $e->getMessage();
}

?>