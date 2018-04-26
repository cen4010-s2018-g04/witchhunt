<?php
require_once './includes/config.php';
// This checks to make sure user is logged in, and redirects to index.php if not
require_once './includes/logged_in.php';

$game_id = (int)$_SESSION["game_id"];
$continueplay = '<button class="btn" id="continueGame">Continue</button><br />';
$gohome = '<button class="btn" id="goHome">Continue</button><br />';
// is witch alive
if ((int)isWitchAlive($game_id) == 1)
{
    // Witch is Alive
    //Check how many players, and if < 3, the witch has won
    $numalive = getNumPlayersAlive($game_id);
    if ($numalive < 3) {
        // Witch has won
        // End game by adding final timestamp
        finalizeGame($game_id);
        echo '<h3>The witch has won!</h3>';
        echo $gohome;
    }else{
        // The witch has not won
        // check if user is alive
        $playerAlive = isPlayerAlive($game_id, $user_id);
        if ($playerAlive == 1){
            echo '<h3>You are still alive</h3>';
            echo $continueplay;
        }else{
            echo '<h3>You are dead</h3>';
            echo $gohome;
        }
    }
}else{
    // Witch is Dead
    // End game by adding final timestamp
    finalizeGame($game_id);
    echo '<h3>The witch is dead!</h3>';
    echo $gohome;
}


?>