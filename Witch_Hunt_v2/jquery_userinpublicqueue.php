<?php
require_once './includes/config.php';
// This checks to make sure user is logged in, and redirects to index.php if not
require_once './includes/logged_in.php';

// Check if user is in the public queue
$public=true;
$game_id=0;
$response=isPlayerInQueue($game_id, $user_id, $public);

echo $response;
?>