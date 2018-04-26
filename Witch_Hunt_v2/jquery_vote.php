<?php
require_once './includes/config.php';
// This checks to make sure user is logged in, and redirects to index.php if not
require_once './includes/logged_in.php';



if(isSet($_POST["vote"])){
    // if exists, call function to add current logged in user to queue
    $vote=(int)trim($_POST["vote"]);
    $game_id = (int)$_SESSION["game_id"];
    $response = vote($game_id, $user_id, $vote);
}
echo $response;
?>