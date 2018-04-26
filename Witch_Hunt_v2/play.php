<?php
require_once './includes/config.php';

// This checks to make sure user is logged in, and redirects to index.php if not
require_once './includes/logged_in.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Witch Hunt - Play</title>
    <?php
    require_once './includes/head.php';
    ?>

</head>
<body>
<div id="main">
    <?php
    global $user_id;
    $game_id = $_SESSION['game_id'];

    echo "<h4>You are</h4>";
    if (isWitch($game_id, $user_id)){
        echo "<h1>The Witch</h1>";
        echo "<h3>Who will you kill?</h3>";
    }
    else{
        echo "<h1>A Villager</h1>";
        echo "<h3>Who is the Witch?</h3>";
    }
    $curround = getCurrentRound($game_id);
    if ((int)$curround == 0) {$curround=1;}

    $resultArray = PlayersInGame($game_id);
    $numInGames = count($resultArray);


    echo '<h2 id="roundnum">Round '.$curround.'</h2>';


    echo '<div id="playerbtns">';
    foreach ($resultArray as $data){
        $game_name=$data['game_name'];
        $game_id=$data['game_id'];
        $alive = $data['alive'];
        $username = $data['username'];
        $user_id_game = $data['user_id'];
        if ($game_name == NULL) { $game_name="Public";};
        if ((int)$user_id_game != $user_id) {
            if ((int)$alive==1){
                echo '<button class="btn btn-success votePlayer" id="vote'.$user_id_game.'" value="'.$user_id_game.'">'.$username.'</button><br />';
            }else{
                echo '<button class="btn btn-danger votePlayer" disabled id="vote'.$user_id_game.'" value="'.$user_id_game.'">'.$username.'</button><br />';
            }
        }
    }
    echo '</div>';
    ?>
    <div id="waitvote" style="display: none;">
        <div id="votesremaining"></div>
    </div>

    <div id="voteresult" style="display: none;">
        <div id="showresults"></div>

    </div>
</div>
</body>
</html>

