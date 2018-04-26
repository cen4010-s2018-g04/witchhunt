<?php
require_once './includes/config.php';
// This checks to make sure user is logged in, and redirects to index.php if not
require_once './includes/logged_in.php';


?>


<!DOCTYPE html>
<html>
<head>
    <title>Witch Hunt - Matchmaking</title>
    <?php
    require_once './includes/head.php';
    ?>
</head>
<body>
<div id="main">
    <?php
    // if user is already logged in a game, show that instead of allowing to add a new one
    // Write code to check if user is already in a game, and show the button if they are.
    global $user_id;

    $resultArray = PlayerActiveGames($user_id);
    $numInGames = count($resultArray);

    if ($numInGames==0) {
        $inPublic=isPlayerInQueue(0, $user_id, true);
        if ((int)$inPublic==1) {
            echo '<button class="btn" id="newPublicGame">Wait in Public Queue</button>';
        }else{
            echo '<button class="btn" id="newPublicGame">Join a Public Game</button>';
        }
        ?>
        <br />
        <button class="btn" id="joinPrivateGame">Join a Private Game</button><br />
        <button class="btn" id="newPrivateGame">Create a Private Game</button><br />
    <?php
    }else{
        echo '<h3>You are already joined to a current game.</h3>';
        foreach ($resultArray as $data){
            $game_name=$data['game_name'];
            $game_id=$data['game_id'];
            $_SESSION['game_id'] = $game_id;
            if ($game_name == NULL) { $game_name="Public";};
            echo '<button class="btn playExistingGame" id="playExistingGame'.$game_id.'" value="'.$game_id.'">Play '.$game_name.' Game</button><br />';
        }
    }
    ?>

    <div id="createPrivate" style="display: none;">
        <h2>Enter Name for your Game</h2>

    </div>

</div>
</body>
</html>
