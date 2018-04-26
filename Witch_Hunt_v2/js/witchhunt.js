$(document).ready(function ($) {
    var err = "";
    var inQueue = false;
    var numinQueue=0;
    var pollInterval=1;
    var timer;
    $('.playExistingGame').click(function() {
        url = "play.php";
        $(location).attr("href", url);
    });

    $('.votePlayer').click(function() {
        // show the div for waiting to vote, and hide the buttons of other voters
        $('#waitvote').show();
        $('#playerbtns').hide();

        voteid = $(this).attr("value");
        //submit vote
        $.post("./jquery_vote.php",
            {vote: voteid},
            function(response, status) {
                //wait for others
                waitForVotes();
            });
    });


    $('#newPublicGame').click(function() {

        // New public game is clicked, send player into the queue and wait for other users to join
        // to get to minimum amount of players

        // First check to see if user is already in the queue
            $.post("./jquery_userinpublicqueue.php",
                {},
                function(response, status) {
                // handle callback
                    if (response=='0') {
                        // If not in queue, add to queue
                        $.post("./jquery_addqueue.php",
                            {gameid: 0, public: 1},
                            function(response, status) {
                                // handle callback
                                waitPublicQueue();
                            });
                    }else{
                        // go to waiting queue
                        waitPublicQueue();
                    }
            });
    });

    $('#joinPrivateGame').click(function() {
        alert("join private game");
        // SHow textbox to enter private game name




    });

    $('#newPrivateGame').click(function() {
        // First check to see if user is already in the queue
        $.post("./jquery_userinprivatequeue.php",
            {},
            function(response, status) {
                // handle callback
                alert(response);
                if (response=='0') {
                    // If not in queue, add to queue
                    url = "privateGame.php";
                    $(location).attr("href", url);
                }else{
                    // go to waiting queue and send response which should be gameid
                    waitPrivateQueue(response);
                }
            });
    });

    $(document).on('click', '#continueGame', function(){
        location.reload();
        //$(location).reload();
    });
    $(document).on('click', '#goHome', function(){
        url = "home.php";
        $(location).attr("href", url);
    });


    function voteresult() {
        // Votes are finished for this round, show who was killed
        $('#waitvote').hide();
        $('#voteresult').show();
        $.post("./jquery_showvoteresults.php",
            {},
            function(response, status) {
                $("#showresults").html(response);
            });
    }

    function waitForVotes() {
        // sit in loop and query database every increment from constant
        // until all players in game have voted
        clearTimeout(timer);

        // get current numbers of players in queue
        $.post("./jquery_getvoted.php",
            {},
            function(response, status) {
                if (response <= 0) {
                    // No more votes needed, switch to show who got killed or won
                    voteresult();
                }else{
                    // show user the queue numbers
                    $("#votesremaining").html(getVotesRemaining(response));

                    timer=setTimeout(waitForVotes, pollInterval*1000);
                }
            });
    }

    function waitPublicQueue(){
        // sit in loop and query database every increment from constant
        // see if there is enough players

       clearTimeout(timer);

        // get current numbers of players in queue
        $.post("./jquery_numuserspublicqueue.php",
            {},
            function(response, status) {
                // handle callback
                numinQueue=response;

                if (numinQueue >= minplay){
                    // We have enough players

                    // get max number of players from queue and add to array
                    // delete those players and add them to a new game
                    $.post("./jquery_playerstogame.php",
                        {gameid: 0, public: 1},
                        function(response, status) {
                            // handle callback
                            if (response == "0") {
                                // All is good, redirect to play game
                                url = "play.php";
                                $(location).attr("href", url);
                            }else{
                                alert("Error. Try again.");
                            }
                        });
                }else{
                    // show user the queue numbers
                    $("#main").html(getQueueScreen(numinQueue));

                    timer=setTimeout(waitPublicQueue, pollInterval*1000);
                }
            });
    };

    function waitPrivateQueue(gameid){
        // sit in loop and query database every increment from constant
        // see if there is enough players

        clearTimeout(timer);

        // get current numbers of players in queue
        $.post("./jquery_numusersprivatequeue.php",
            {gameid: gameid},
            function(response, status) {
                // handle callback
                numArray=response.split(",");
                numinQueue=numArray[0];
                minplay=numArray[1];

                if (numinQueue >= minplay){
                    // We have enough players
                    // get max number of players from queue and add to array
                    // delete those players and add them to a new game
                    $.post("./jquery_playerstogame.php",
                        {gameid: gameid, public: 0},
                        function(response, status) {
                            // handle callback
                            if (response == "0") {
                                // All is good, redirect to play game
                                url = "play.php";
                                $(location).attr("href", url);
                            }else{
                                alert("Error. Try again.");
                            }
                        });
                }else{
                    // show user the queue numbers
                    $("#main").html(getQueueScreen(numinQueue));

                    timer=setTimeout(waitPrivateQueue(gameid), pollInterval*1000);
                }
            });
    };
    function getQueueScreen(numinQueue){
        $html = '<h3>Waiting for other players.</h3><p>Current number in queue: ' + numinQueue;
        $html +=  '<br />Need at least ' + (minplay - numinQueue) + ' more players.</p>';

        return $html;
    }

    function getVotesRemaining(num){
        $html = '<h3>Waiting for ' + num + ' players to vote.</h3>';
        return $html;
    }

});
