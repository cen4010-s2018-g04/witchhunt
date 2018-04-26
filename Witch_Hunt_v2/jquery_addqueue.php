<?php
require_once './includes/config.php';
// This checks to make sure user is logged in, and redirects to index.php if not
require_once './includes/logged_in.php';


//$game_id=0;
$public=false;
$response=0;

// Check if gamieid
if(isSet($_POST["gameid"])){
    // if exists, call function to add current logged in user to queue
    $game_id=(int)trim($_POST["gameid"]);
    $public=(int)trim($_POST["public"])==1;
    $response = addToPlayerQueue($game_id, $user_id, $numplayers, $public);

}
echo $response;
?>