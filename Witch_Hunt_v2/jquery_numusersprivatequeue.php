<?php
require_once './includes/config.php';
// This checks to make sure user is logged in, and redirects to index.php if not
require_once './includes/logged_in.php';

// Check if user is in the public queue
$public=false;
// Check if gameid
if(isSet($_POST["gameid"])) {
    // if exists, call function to add current logged in user to queue
    $game_id = (int)trim($_POST["gameid"]);
    $numinqueue = PlayersInQueue($game_id, $public);
    $minimum = minPlayersGame($game_id);
    echo $numinqueue.','.$minimum;
}
?>