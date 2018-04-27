<?php 
require_once './includes/config.php'; 


// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = 'Please enter username.';
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST['password']))){
        $password_err = 'Please enter your password.';
    } else{
        $password = trim($_POST['password']);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT user_id, username, password FROM Users WHERE username = ?";

        if($stmt = mysqli_prepare($sqlcon, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $user_id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){                        
                            /* Password is correct, so start a new session and
                            save the username to the session */
                            session_start();
                            $_SESSION['username'] = $username;
                            $_SESSION['user_id'] = $user_id;
                            header("location: home.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = 'The password you entered was not valid.';
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = 'No account found with that username.';
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            // Close statement
            mysqli_stmt_close($stmt);
        }else{
            echo "ERROR LOGGING IN.";
        }
        

    }
    
    // Close connection
    mysqli_close($sqlcon);
}



?>
<!DOCTYPE html>
<html>
  <head>     
      <title><?php echo $title;?></title>
      <style>
          #main {
              display: none;
          }
      </style>
      <?php
      require_once './includes/head.php';
      ?>
      <script>
          $(document).ready(function() {
              $("#noJS").hide();
              $("#main").show();
          });
      </script>

  </head>
  <body>
    <h1>Welcome to Witch Hunt</h1>
    <div id="main">
      <?php
      // Check if we came from the create account post form where a user just created their account
      if(isset($_SESSION['account_created']) || !empty($_SESSION['account_created'])){
          echo "<h3>Your account was succesfully created.</h3>";
          // Clear that variable out again.
          $_SESSION['account_created']=null;
      }?>
        <h2>Sign In below</h2>
        <form id="signIn" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <fieldset>
            <input placeholder="Enter your username" name="username" type="text" value="<?php echo $username; ?>">
              <span class="help-block"><?php echo $username_err; ?></span>
          </fieldset>
          <fieldset>
            <input placeholder="Enter your password" name="password" type="password" >
              <span class="help-block"><?php echo $password_err; ?></span>
          </fieldset>
          <fieldset>
            <button type="submit" name="Sign_In_Button">Sign In</button>
          </fieldset>
        </form>
        <a href="register.php"><h4>New Member? Click here to sign up.</h4></a>
    </div>
    <div id="noJS">
        <h4>This app needs Javascript enabled to operate properly.<br />
            Please enable Javascript and try again.</h4>
    </div>
  </body>
</html>
