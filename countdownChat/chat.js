$(document).ready(function () {
    var $userName = $("#userName");
    var $chatOutput = $("#chatOutput");
    var $chatInput = $("#chatInput");
    var $chatSend = $("#chatSend");

    var countdown = 5;
    $("#test1").text(countdown);

    function sendMessage() {
        var userNameString = $userName.val();
        var chatInputString = $chatInput.val();

        $.get("write.php", {
            username: userNameString,
            text: chatInputString
        });

        $userName.val("");
        retrieveMessages();
    }

    function retrieveMessages() {
        $.get("read.php", function (data) {
            $chatOutput.html(data); //Paste content into chat output
        });
    }

    function redirectToVote() {
      $.get("vote.php", function () {
        alert("Returning to vote");
      });
    }

    $chatSend.click(function () {
        sendMessage();
    });

    var timer = setInterval(function () {
        retrieveMessages();
        countdown--;
        $("#test1").text(countdown);
        if (countdown == 0) {
          alert("Chat time is over.");
          clearInterval(timer);
          var url = "vote.php";
          $(location).attr("href", url);
        }
    }, 1000);
});
