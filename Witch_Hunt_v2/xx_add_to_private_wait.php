<?php 
require_once './includes/config.php'; 
// This checks to make sure user is logged in, and redirects to index.php if not
require_once './includes/logged_in.php';

$intPlayers=(int)$_POST['number_of_players'];

$statement="insert into waiting_for_game 
            values('".$_POST['game_name']."',
            '".$_SESSION['username']."',
            0,
            0,
            ".$intPlayers.",
            0);";

if (!$result = $sqlcon->query($statement)) {
      echo "Error fetching game data!";
    }
    
?>


<!DOCTYPE html>
<html>
  <head>
    <title>Witch Hunt - Matchmaking</title>
    <script>
      function checkWaitlist(){
          var xmlRequest=new XMLHttpRequest();
          
          xmlRequest.open("POST","checkPrivateCreator.php",false);
          xmlRequest.send();
          document.getElementById("print_username").innerHTML=xmlRequest.responseText;
      }
    </script>
  </head>
  <body>
    <p id="print_username">
    </p>
    <script>
      setInterval(
        function(){checkWaitlist()},2000
      );
    </script>
  </body>
</html>