<?php
require_once 'config.php';
// This checks to make sure user is logged in, and redirects to index.php if not
require_once 'logged_in.php';
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
      <style>
        body{
            background-image: url("http://www.toptenz.net/wp-content/uploads/2011/10/Halloween-Witches.jpg")
        }
    </style>
      <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <title>Witch Hunt - Matchmaking</title>
    <?php
    require_once 'head.php';
    ?>
</head>
<body>
     <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <body style="text-align:center;">Centered Heading</body>
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Witch Hunt</a>
            </div>
                <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="#about">Instructions</a></li>
                    <li><a href="#contact">Standings</a></li>
                </ul>
                
            </div>
          </nav>
<div id="main">
    <?php
    // if user is already logged in a game, show that instead of allowing to add a new one
    // Write code to check if user is already in a game, and show the button if they are.
    global $user_id;
    $resultArray = PlayerActiveGames($user_id);
    $numInGames = count($resultArray);
    if ($numInGames==0) {
        $inPublic=isPlayerInQueue(0, $user_id, true);
       
    
    <div class="container">
        <br><br><br><br><br>
        <h1>Witch Hunt</h1><br>
            
           <h1>
             if ((int)$inPublic==1) {
                echo '<button class="btn" id="newPublicGame">Wait in Public Queue</button>';
            }else{
                echo '<button class="btn" id="newPublicGame">Join a Public Game</button>';
            }
            ?>
            <br />

            <button class="btn" id="joinPrivateGame">Join a Private Game</button><br />
                <br>

                <button class="btn" id="newPrivateGame">Create a Private Game</button><br />
        </h1>
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