<?php 
require_once './includes/config.php'; 
// This checks to make sure user is logged in, and redirects to index.php if not
require_once './includes/logged_in.php'; 
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
    <p>Please wait. Not enough players to make a game.</p>
    <script>
      setInterval(
        function(){checkWaitlist()},1000
      );
    </script>
  </body>
</html>