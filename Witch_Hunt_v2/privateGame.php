<?php 
require_once './includes/config.php'; 
// This checks to make sure user is logged in, and redirects to index.php if not
require_once './includes/logged_in.php';


$errmsg = "";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {

$game_code = "";
    if (empty(trim($_POST["game_name"]))) {
        $errmsg = "Please provide a name for your game.<br />";
    } else{
        $numplayers = (int)trim($_POST["number_of_players"]);
        $game_name = trim($_POST["game_name"]);

        $game_code = createPrivateGame($game_name, $user_id, $numplayers);
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
        <?php
        // Check to make sure user has not already created a game that has not finished
        if ((int)doesPrivateGameExist($user_id)==0){
        ?>
            <form id="private" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <?php if($errmsg != "") {
                echo "<h2>" . $errmsg . "</h2>";
            }?>
              Game Name: <input type="text" name="game_name" title="Name your game."/>
              <br/>
              Min Number of Players: <select name="number_of_players">
                <option>5</option>
                <option>6</option>
                <option>7</option>
                <option>8</option>
                <option>9</option>
              </select>
              <br/>
              <input type="submit" value="Create Game"/>
            </form>
        <?php } else if($game_code != ""){ ?>
            <h2>Your code for your private game is <?php echo $game_code; ?></h2>
            <p>Share this code with whoever you want to invite to your game.</p>
        <?php }else{ ?>
            <h2>You already have a game created.</h2>

        <?php } ?>
    </div>
  </body>
</html>
