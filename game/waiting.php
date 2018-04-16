<?php 
require_once './includes/config.php'; 
// This checks to make sure user is logged in, and redirects to index.php if not
require_once './includes/logged_in.php'; 
$username=$_SESSION["username"];

function RandCharGen($num){
    $chars="ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $ranSET="";
    for ($i=0;$i<$num;$i++){
        $j=random_int(0,25);
        $ranSET.=substr($chars,$j,1);
    }
    return $ranSET;
}


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
$arrTime=time();
try{
$statement2="insert into waiting_for_game 
values('any',
'".$_SESSION['username']."',
0,
0,
5,
".$newPlace.",
".$arrTime.");";

$sqlcon->query($statement2);


$statement3='DELETE FROM waiting_for_game WHERE time_since_ping<'.$arrTime-10 .';';
$sqlcon->query($statement3);


$statement4='SELECT count(username) FROM waiting_for_game WHERE game_name="any";';
if (!$result=$sqlcon->query($statement4)){
  echo "error counting public players!";
}
else if($result->num_rows>0){
  $numInPublic=$result->fetch_assoc();
  //echo $numInPublic["count(username)"];
  
  $numAny=$numInPublic["count(username)"];
  if ($numAny>4){//enough players to start a game
	$smfindUser='SELECT username,place FROM waiting_for_game WHERE place>0;';
	$smUsers=$sqlcon->query($smfindUser);
	$maxUsers=$smUsers->num_rows;
	for ($i=0;$i<$maxUsers;$i++){
		$temp=$smUsers->fetch_assoc();
		$potUsers[$i]=$temp;
	}
	$w=0;
	$gameID=rand(1,1000000000);
	
	$RGameName=RandCharGen(10);
	while($w<9 && $w<$maxUsers){
	  $statementd[$w]='DELETE FROM waiting_for_game WHERE username="'.$potUsers[$w]["username"].'";';
	  $actUser=$potUsers[$w]["username"];
	  $smaddGame[$w]="INSERT INTO game_players values(".$gameID.",'".$actUser."',0,1,1,0,0);";
	  $w++;
    }
	$witchIs=rand(1,$w-1);
	$createGame="INSERT INTO GameList VALUES(
	".$gameID.",
	'".$RGameName."',
	'".$username."',
	".time().",
	' ');";
	$sqlcon->query($createGame);
	for ($a=0;$a<$w;$a++){
	  if($a!=$witchIs){
	    $sqlcon->query($smaddGame[$a]);
		}
	  else{
	    $sqlcon->query("INSERT INTO game_players values(".$gameID.",'".$actUser[$w]."',1,1,0,1,0);");}
	  
	  $sqlcon->query($statementd[$a]); 
	}
	
  
}






}//end elif
}//end try
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
          if(xmlRequest.responseText===1){
            window.location="http://lamp.cse.fau.edu/~CEN4010_S2018g04/WitchHuntTest001/votev2.php";
			document.getElementById("test").innerHTML="relocation doesn't work<br/>";
			
          }
		  else{
			  document.getElementById("test").innerHTML="error with checkPublic<br/>";
		  }
      }
         
    </script>
  </head>
  <body>
    <p>Please wait. Not enough players to make a game.</p>
	<p id="test"></p>
    <script>
      setInterval(
        function(){checkWaitlist()},1000
      );
    </script>
  </body>
</html>
