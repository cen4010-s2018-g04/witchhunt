<?php
require_once './includes/config.php'; 

// This checks to make sure user is logged in, and redirects to index.php if not
require_once './includes/logged_in.php';
$username=$_SESSION["username"];
$statement='SELECT * FROM game_players WHERE username="'.$username.'"';
$result=$sqlcon->query($statement);

$isWitch=mysqli_fetch_array($result)["witch"];


$voteA=$_POST["username"];

if ($isWitch){
  $st2='UPDATE game_players SET wvote=1 WHERE username="'.$_POST["username"].'";';}
else{
  $st2='UPDATE game_players SET vote=vote+1 WHERE username="'.$_POST["username"].'";';}

$sqlcon->query($st2);

}
}

header("location: results.php");
  exit;
?>