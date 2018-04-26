<?php 
require_once './includes/config.php'; 
// This checks to make sure user is logged in, and redirects to index.php if not
require_once './includes/logged_in.php'; 


try{

$statement1='SELECT game_name FROM waiting_for_game WHERE game_name="'.$_POST["game_name"].'";';

//if there aren't any errors running statement 1 and the game_name exists
//add the player to the wait list
if(!$result=$sqlcon->query($statement1)){

if ($result->num_rows>0){
$statement2="insert into waiting_for_game 
            values('".$_POST["game_name"]."',
            '".$_SESSION["username"]."',
            0,
            0,
            10,
            0);";

if (!$result = $sqlcon->query($statement2)) {
      echo "Error fetching game data!";
    }
}}
else{
  echo "Error adding to the wait!";}


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
            window.location=game.php;
          }
          
      }
            
    </script>
  </head>
  <body>
    <p>Please wait. The admin has not begun the game yet.</p>
    <script>
      setInterval(
        function(){checkWaitlist()},1000
      );
    </script>
  </body>
</html>
