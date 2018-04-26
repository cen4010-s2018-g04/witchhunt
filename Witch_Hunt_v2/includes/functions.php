<?php


function RandCharGen($num){
    $chars="ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $ranSET="";
    for ($i=0;$i<$num;$i++){
        $j=random_int(0,25);
        $ranSET.=substr($chars,$j,1);
    }
    return $ranSET;
}


function isWitch($game_id, $user_id){
    global $sqlcon;
    $retval=0;
    try {
        $query = 'SELECT witch FROM GamePlayers
                  INNER JOIN Games ON Games.game_id = GamePlayers.game_id_f
                  WHERE user_id_f='.(int)$user_id.'
                  AND game_id_f='.(int)$game_id.'
                  LIMIT 1';

        if (!$result = $sqlcon->query($query)){
            $data= "error counting game!";
        }else{
            $data=$result->fetch_assoc();
            $retval=$data['witch'];
        }

    }//end try
    catch (Exception $e){
        echo $e->getMessage();
    }
    return $retval;
}

function isWitchAlive($game_id){
    global $sqlcon;
    $retval=0;
    try {
        $query = 'SELECT user_id_f FROM GamePlayers
                  WHERE game_id_f='.(int)$game_id.'
                  AND witch=1 
                  AND alive=1';

        if (!$result = $sqlcon->query($query)){
            $data= "error is witch alive";
        }else if ($result->num_rows > 0){
            $retval=1;
        }

    }//end try
    catch (Exception $e){
        echo $e->getMessage();
    }
    return $retval;
}
function isPlayerAlive($game_id, $user_id){
    global $sqlcon;
    $retval=0;
    try {
        $query = 'SELECT user_id_f FROM GamePlayers
                  WHERE game_id_f='.(int)$game_id.'
                  AND user_id_f='.(int)$user_id.'
                  AND alive=1';

        if (!$result = $sqlcon->query($query)){
            $data= "error counting game!";
        }else if ($result->num_rows > 0){
            $retval=1;
        }

    }//end try
    catch (Exception $e){
        echo $e->getMessage();
    }
    return $retval;
}
function finalizeGame($game_id){
    global $sqlcon;
    $retval=0;
    try {
        $query = 'UPDATE Games
              SET End_Date=now()
              WHERE game_id='.(int)$game_id.'';

        $sqlcon->query($query);
      }//end try
    catch (Exception $e){
        echo $e->getMessage();
    }
        return $retval;
}
function doesPrivateGameExist($user_id){
    global $sqlcon;
    $retval=0;
    try {
        $query = 'SELECT game_id FROM Games
                          WHERE creator_id_f='.(int)$user_id.'
                          AND End_Date IS NULL';

        if (!$result = $sqlcon->query($query)){
            $retval = "error in queue!";
        }else{
            $data=$result->fetch_assoc();
            $retval=(int)$data['game_id'];
        }
    }//end try
    catch (Exception $e) {
        echo $e->getMessage();
    }
    return $retval;
}

function getNumPlayersAlive($game_id){
    global $sqlcon;
    $retval=0;
    try {
        $query = 'SELECT user_id_f FROM GamePlayers
                  WHERE game_id_f='.(int)$game_id.'
                  AND alive=1';

        if (!$result = $sqlcon->query($query)){
            $data= "error counting game!";
        }else if ($result->num_rows > 0){
            $retval=$result->num_rows;
        }

    }//end try
    catch (Exception $e){
        echo $e->getMessage();
    }
    return $retval;
}
function addToPlayerQueue($game_id, $user_id, $numplayers, $public){
    global $sqlcon;
    $numrows=0;
    try {

        if ($stmt = $sqlcon->prepare("INSERT INTO GameQueue
                    (game_id_f, user_id_f, numplayers, public)
                      VALUES (? ,?, ?, ?)")) {
            $stmt->bind_param('iiii', $game_id, $user_id, $numplayers, $public);

            $stmt->execute();

            $numrows = $stmt->affected_rows;

            /* close statement and connection */
            $stmt->close();
        }
    }//end try
    catch (Exception $e){
        echo $e->getMessage();
    }
    return $numrows;
}

function PlayerActiveGames($user_id){
    global $sqlcon;
    $retval=[];
    try {
        $query = 'SELECT game_id, game_name FROM GamePlayers
                  INNER JOIN Games ON Games.game_id = GamePlayers.game_id_f
                  WHERE user_id_f='.(int)$user_id.'
                  AND alive=1 AND End_Date IS NULL
                  LIMIT 1';

        if (!$result = $sqlcon->query($query)){
            $data= "error counting game!";
        }else{
            for ($i=0; $i < $result->num_rows; $i++){
                $data=$result->fetch_assoc();
                $retval[]=$data;
            }
        }
        /* close statement and connection */
        $result->close();

    }//end try
    catch (Exception $e){
        echo $e->getMessage();
    }
    return $retval;
}

function PlayersInGame($game_id){
    global $sqlcon;
    try {
        $query = 'SELECT game_id, game_name, alive, username, user_id FROM GamePlayers
                  INNER JOIN Games ON Games.game_id = GamePlayers.game_id_f
                  INNER JOIN users On users.user_id = GamePlayers.user_id_f
                  WHERE game_id_f='.(int)$game_id;

        if (!$result2 = $sqlcon->query($query)){
            $data= "error counting game!";
        }else{
            for ($i=0; $i < $result2->num_rows; $i++){
                $data=$result2->fetch_assoc();
                $retval2[]=$data;
            }
        }
        /* close statement and connection */
        $result2->close();

    }//end try
    catch (Exception $e){
        echo $e->getMessage();
    }
    return $retval2;
}


function isPlayerInQueue($game_id, $user_id, $public){
    global $sqlcon;
    $retval=0;
    try {
        /*$query = 'SELECT COUNT(*) as Total FROM GameQueue
                  WHERE game_id_f='.(int)$game_id.'
                      AND user_id_f='.(int)$user_id.'
                      AND public='.(bool)$public;*/
        $query = 'SELECT game_id_f FROM GameQueue
                  WHERE user_id_f='.(int)$user_id.'
                  AND public='.(int)$public.'';


        if (!$result = $sqlcon->query($query)){
            echo "error counting queue!";
        }else{
            if ((bool)$public){
                $retval=$result->num_rows;
            }else{
                if ($result->num_rows>0){
                $data=$result->fetch_assoc();
                $retval=(int)$data['game_id_f'];
                }
            }
        }

    }//end try
    catch (Exception $e){
        echo $e->getMessage();
    }
    return $retval;
}
function minPlayersGame($game_id){
    global $sqlcon;
    $retval=0;
    try {
        $query = 'SELECT numplayers FROM Games
                  WHERE game_id='.(int)$game_id;
        if (!$result = $sqlcon->query($query)){
            echo "error counting queue!";
        }else{
            $data=$result->fetch_assoc();
            $retval=$data['numplayers'];
        }
    } //end try
    catch (Exception $e){
        echo $e->getMessage();
    }
    return $retval;
}

function PlayersInQueue($game_id, $public){
    global $sqlcon;
    $numInQueue=0;
    try {
        $query = 'SELECT COUNT(*) as Total FROM GameQueue
                  WHERE game_id_f='.(int)$game_id.'
                      AND public='.(bool)$public;

        if (!$result = $sqlcon->query($query)){
            echo "error counting queue!";
        }else{

            $data=$result->fetch_assoc();
            $numInQueue=$data['Total'];
        }
        /* close statement and connection */
        $result->close();


    }//end try
    catch (Exception $e){
        echo $e->getMessage();
    }
    return $numInQueue;
}


function convertPlayersToGame($game_id, $user_id, $public) {
    // Load up the
    global $sqlcon;
    global $maxplayers;
    $retval="0";
    try {
        // Lock the table, so overlapping doesn't occur in case another user tries to empty queue as well

        $query = 'LOCK TABLES GameQueue WRITE;';
        $result = $sqlcon->query($query);
        $query = 'SELECT gamequeue_id, user_id_f FROM GameQueue
                  WHERE game_id_f='.(int)$game_id.'
                      AND public='.(bool)$public.'
                      AND user_id_f <> '.(int)$user_id.'
                      ORDER BY created ASC
                      LIMIT '.((int)$maxplayers-1);

        if (!$result = $sqlcon->query($query)){
            $retval = "error counting queue! 115";
        }else{
            // Load up the query into an array, do not include this user

            for ($i=0; $i < $result->num_rows; $i++){
                $data=$result->fetch_assoc();
                $potUsers[$i]=$data['user_id_f'];
                $queueid[$i]=$data['gamequeue_id'];
            }
            //Add queueid / userid of current user
            $query = 'SELECT gamequeue_id, user_id_f FROM GameQueue
                      WHERE game_id_f='.(int)$game_id.'
                      AND public='.(bool)$public.'
                      AND user_id_f = '.(int)$user_id.'
                      ORDER BY created ASC
                      LIMIT 1';

            if (!$result = $sqlcon->query($query)){
                $retval = "error in queue!";
            }else{
                $count = count($potUsers);
                $data=$result->fetch_assoc();
                $potUsers[$count]=$data['user_id_f'];
                $queueid[$count]=$data['gamequeue_id'];
            }



            // Now delete the users from the queue
            foreach ($queueid as $queue) {
                $query='DELETE FROM GameQueue WHERE gamequeue_id = '.(int)$queue;
                $sqlcon->query($query);
            }

            // Unlock the queue table
            $query = 'UNLOCK TABLES;';
            $sqlcon->query($query);


            // now add the users from array into the game

            // Create new game and get id

            // If this is a public game, we need to create an entry in the game table and get back
            // the new game id. If it was private, we should already have the game id
            if ((int)$game_id==0) {
                $query = 'INSERT INTO Games
                      (creator_id_f) VALUES (0);';
                $sqlcon->query($query);
                $game_id = $sqlcon->insert_id;
            }

            // Add Players from array to the game and unlock the table
            $count = count($potUsers);
            // get random number of total count of users for this game for the witch
            $witchPos=rand(0,$count-1);
            for ($i=0; $i < $count; $i++){
                // if this current user is the witch, turn on the flag
                if ($i==$witchPos){
                    $witch=1;
                }else{
                    $witch=0;
                }
                $query = 'INSERT INTO GamePlayers
                          (game_id_f, user_id_f, witch, alive)
                          VALUES ('.(int)$game_id.','.(int)$potUsers[$i].','.(int)$witch.',1)';
                $sqlcon->query($query);
            }

            if ((int)$game_id > 0) {
                $_SESSION['game_id'] = $game_id;

            }


        }



    }//end try
    catch (Exception $e){
        echo $e->getMessage();
    }
    return $retval;

}
function getCurrentRound($game_id){
    global $sqlcon;
    try {
        $query = 'SELECT curround FROM Games
                          WHERE game_id='.(int)$game_id.'';

        if (!$result = $sqlcon->query($query)){
            $retval = "error in queue!";
        }else{
            $data=$result->fetch_assoc();
            $curround=(int)$data['curround'];
        }
    }//end try
    catch (Exception $e) {
        echo $e->getMessage();
    }
    return $curround;
}

function vote($game_id, $user_id, $vote)
{
    global $sqlcon;
    $retval = "0";
    try {
        // get current round, if current round is zero, increment to 1 and fill start date on game
        $curround = getCurrentRound($game_id);

        // This is the first round, Increment curround and also timestamp of start date
        if ($curround==0){
            $query = 'UPDATE Games
                        SET curround=1, Start_Date=now()
                      WHERE game_id='.(int)$game_id.'';
            $sqlcon->query($query);
            $curround++;
        }

        $voted=false;
        // see if we have voted yet for this round
        $query = 'SELECT vote_id FROM Votes
                      WHERE game_id_f='.(int)$game_id.'
                        AND user_id_f='.(int)$user_id.'
                        AND round='.(int)$curround;
        if (!$result = $sqlcon->query($query)){
            $retval = "error in queue!";
        }else{
            if ($result->num_rows > 0){
                // We have already cast a vote for this round
                $voted=true;
            }
        }

        // if we have not voted for this round, cast vote
        if (!$voted){
            $query = 'INSERT INTO Votes
                          (round, game_id_f, user_id_f, vote_user_id_f)
                          VALUES ('.(int)$curround.','.(int)$game_id.','.(int)$user_id.','.(int)$vote.')';
            $sqlcon->query($query);
        }

        // see how many votes have been cast for this round
        $query = 'SELECT COUNT(*) as numvotes, 
                      (SELECT COUNT(*) FROM GamePlayers WHERE game_id_f='.(int)$game_id.' AND alive=1) AS numalive
                      FROM Votes
                      WHERE game_id_f='.(int)$game_id.'
                        AND round='.(int)$curround;
        if (!$result = $sqlcon->query($query)){
            echo "error counting queue!";
        }else{

            $data=$result->fetch_assoc();
            $numvotes=(int)$data['numvotes'];
            $numalive=(int)$data['numalive'];
        }

        // if all alive players have voted, increment round on game, set alive flag to 0 on killed players and return 0
        $retval = $numalive-$numvotes;
        if ($retval == 0){
            //get whoever received most votes
            $query = 'SELECT vote_user_id_f, COUNT(vote_id) As numvotes FROM `Votes`
                        WHERE round='.(int)$curround.' 
                        AND game_id_f='.(int)$game_id.'
                        GROUP BY vote_user_id_f
                        ORDER BY numvotes DESC
                        LIMIT 1';
            if (!$result = $sqlcon->query($query)){
                echo "error counting queue!";
            }else{
                $data=$result->fetch_assoc();
                $votedout=(int)$data['vote_user_id_f'];
            }

            // set alive=0 for whoever received most votes
            $query = 'UPDATE GamePlayers SET alive=0, rounddied='.(int)$curround.' WHERE 
                    game_id_f = '.(int)$game_id.'
                    AND user_id_f = '.(int)$votedout;
            $sqlcon->query($query);

            // get witch id
            $query = 'SELECT user_id_f FROM GamePlayers WHERE game_id_f = ' . (int)$game_id . ' AND witch=1';
            if (!$result = $sqlcon->query($query)){
                echo "error counting queue!";
            }else{
                $data=$result->fetch_assoc();
                $theWitch=(int)$data['user_id_f'];
            }

            // if its the witch, game is over.
            if ($theWitch == $votedout){


            }else{
                // set alive=0 for whoever witch chose
                $query='UPDATE GamePlayers
                      SET alive=0, rounddied='.(int)$curround.' WHERE user_id_f = 
                          (SELECT vote_user_id_f FROM Votes                       
                          WHERE game_id_f = '. (int)$game_id .'
                          AND user_id_f = '. (int)$theWitch .'                          
                        AND round='.(int)$curround.')';
                if (!$result = $sqlcon->query($query)){
                    echo "error witch kill queue!";
                }
                // If number of alive players is down to 2, and the witch is still alive, no need to continue, witch has won
                $numalive = getNumPlayersAlive($game_id);

                /*$query = 'SELECT COUNT(*) AS numalive FROM GamePlayers WHERE game_id_f='.(int)$game_id.' AND alive=1)';
                if (!$result = $sqlcon->query($query)){
                    echo "error counting queue!";
                }else{
                    $data=$result->fetch_assoc();
                    $numalive=(int)$data['numalive'];
                }*/

                if ((int)$numalive > 2) {
                    // Witch is still alive and there is more than one other player, increment round
                    $query = 'UPDATE Games
                            SET curround=curround+1
                          WHERE game_id='.(int)$game_id.'';
                    $sqlcon->query($query);
                }

            }

        }else if ($retval <0){
            echo "error, too many votes have occured for this round.";
            $retval=0;
        }



    }//end try
    catch (Exception $e) {
        echo $e->getMessage();
    }
    return $retval;
}

function getRemainVotes($game_id){
    // Load up the
    global $sqlcon;
    global $maxplayers;
    $retval = "0";
    try {
        // see how many votes have been cast for this round
        $query = 'SELECT COUNT(*) as numvotes, 
                          (SELECT COUNT(*) FROM GamePlayers WHERE game_id_f='.(int)$game_id.' AND alive=1) AS numalive
                          FROM Votes
                          WHERE game_id_f='.(int)$game_id.'
                            AND round=(SELECT curround FROM Games WHERE game_id='.(int)$game_id.')';
        if (!$result = $sqlcon->query($query)){
            echo "error get remain votes!";
        }else{

            $data=$result->fetch_assoc();
            $numvotes=(int)$data['numvotes'];
            $numalive=(int)$data['numalive'];
            if ($numvotes>0){
                $retval= $numalive-$numvotes;
            }

        }
    }//end try
    catch (Exception $e) {
        echo $e->getMessage();
    }
        return $retval;
    }