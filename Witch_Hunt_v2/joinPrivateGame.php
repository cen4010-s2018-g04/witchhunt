<?php 
require_once './includes/config.php'; 
// This checks to make sure user is logged in, and redirects to index.php if not
require_once './includes/logged_in.php';


$errmsg = "";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {

$game_code = "";
    if (empty(trim($_POST["game_code"]))) {
        $errmsg = "Please enter the code for the game.<br />";
    } else{
        // check if game exists
        $game_id = getGamebyCode(trim($_POST["game_code"]));
        // if games exists, enter user into queue
        if ($game_id > 0) {
            // get num players in this game
            $numplayers=getNumPlayersinGame($game_id);
            $public=false;
            // enter user in game
            $response = addToPlayerQueue($game_id, $user_id, $numplayers, $public);
            if ($response > 0) {
                // Redirect to waiting, user has been added to queue
                $_SESSION['game_id']=$game_id;
                header("location: waiting.php");

            }
        }else{
            $errmsg = "There is no game that matches the game code entered.<br />Please check the code and try again.";
        }

    }
}


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
            <form id="private" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <?php if($errmsg != "") {
                echo "<h2>" . $errmsg . "</h2>";
            }?>
              Game Code: <input type="text" name="game_code" title="Enter the Game Code for the Private Game."/>
              <br/>
              <input type="submit" value="Join Game"/>
            </form>
    </div>
  </body>
</html>
