<?php
require_once './includes/config.php';
// This checks to make sure user is logged in, and redirects to index.php if not
require_once './includes/logged_in.php';

// get the current round number for the game
    $game_id = (int)$_SESSION["game_id"];
    $response = getCurrentRound($game_id);




echo $response;
?>