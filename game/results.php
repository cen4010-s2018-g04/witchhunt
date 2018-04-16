<?php 
require_once './includes/config.php'; 

// This checks to make sure user is logged in, and redirects to index.php if not
require_once './includes/logged_in.php';
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Witch Hunt - Results</title>
  </head>
  <body>
  <?php
  
  $username=$_SESSION["username"];
  $statement = 'SELECT * FROM game_players WHERE username="'.$username.'" and alive=1;';
   if (!$result = $sqlcon->query($statement)) {
	   echo "error";
	   
   }
   else{
	 if ($result->num_rows > 0) {
		$array=$result->fetch_assoc();
		$isWitch=$array["witch"];
	    $gameID=$array["id"];
   }
  
  
  
  
  $maxVotes="SELECT max(vote) FROM game_players;";
  $result=$sqlcon->query($maxVotes);
  $deadman=$result->fetch_assoc(); 
  $dead=$deadman["max(vote)"];
  $killVote='UPDATE game_players SET alive=0 WHERE vote='.$dead.' and id='.$gameID.';';
  $sqlcon->query($killVote);
  $checkWitch='SELECT * FROM game_players WHERE witch=1 and alive=1 and id'.$gameID.';';
  $testWin=$sqlcon->query($checkWitch);
  if ($testWin && $testWin->num_rows>0){
	  $killW='UPDATE game_players SET alive=0 WHERE wvote=1;';
	  $testAlive='SELECT * FROM game_players WHERE alive=1;';
	  $resultAlive=sqlcon->query($testAlive);
	  if ($resultAlive && $resultAlive->num_rows<3){
		echo '<h3>The witch has won!</h3>';
		echo '<form action="home.php">';
		echo '<input type="submit" value="Continue">';
		echo '</form>';	  
	  }
	  
	  else{
		  $statement2='SELECT * FROM game_players WHERE username="'.$username.'" and alive=1;';
		  
		  $killw="UPDATE game_players SET alive=0 WHERE wvote=1;";
		  
		  $voteZero="UPDATE game_players SET vote=0, round=round+1,wvote=0;";
		  
		  $result=sqlcon->query($statement2);
		  if ($result && $result->num_rows>0){
			echo '<h3>You are still alive</h3>';
			echo '<form action="votev2.php">';
			echo '<input type="submit" value="Continue">';
			echo '</form>';
		  }
		  else{
			echo '<h3>You are dead</h3>';
			echo '<form action="home.php">';
			echo '<input type="submit" value="Continue">';
			echo '</form>';	  
		  }
	  }
   }
   
   }
   else if ($testWin && $testWin->num_rows==0){
	echo '<h3>The witch is dead</h3>';
	echo '<form action="home.php">';
	echo '<input type="submit" value="Continue">';
	echo '</form>';	
   }
  ?>
  </body>
</html>
