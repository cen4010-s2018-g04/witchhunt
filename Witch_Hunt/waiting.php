<?php 
require_once './includes/config.php'; 
// This checks to make sure user is logged in, and redirects to index.php if not
require_once './includes/logged_in.php'; 

$newPlace=1;
$statement1="SELECT max(place) FROM waiting_for_game;";
if (!$result = $sqlcon->query($statement1)) {
      echo "Error fetching game data!1";
    }
    else{
      if ($result->num_rows>0){
        $newPlace=mysqli_fetch_array($result)[0]+1;
      }
      echo $newPlace;
    }

try{
$statement2="insert into waiting_for_game 
values('any',
'".$_SESSION['username']."',
0,
0,
5,
".$newPlace.");";

$sqlcon->query($statement2);
}
catch (Exception $e){
    echo $e->getMessage();
}
?>


<!DOCTYPE html>
<html>
  <head>
    <title>Witch Hunt - Matchmaking</title>
    <script>
      function checkWaitlist(){
          var xmlRequest=new XMLHttpRequest();
          
          xmlRequest.open("POST","checkPublic.php",false);
          xmlRequest.send();
          if(xmlRequest.responseText==1){
            window.location="http://lamp.cse.fau.edu/~CEN4010_S2018g04/WitchHuntTest001/game.php";
          }
      }
         
    </script>
  </head>
  <body>
    <p>Please wait. Not enough players to make a game.</p>
    <script>
      setInterval(
        function(){checkWaitlist()},1000
      );
    </script>
  </body>
</html>
