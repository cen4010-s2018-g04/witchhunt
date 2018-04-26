<?php
require_once './includes/config.php';
// This checks to make sure user is logged in, and redirects to index.php if not
require_once './includes/logged_in.php';

// show the number of users left to vote for this game on this round
    $game_id = (int)$_SESSION["game_id"];
    $response = getRemainVotes($game_id);




echo $response;
?>