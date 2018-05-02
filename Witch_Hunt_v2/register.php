<?php
require_once './includes/config.php';

// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT user_id FROM Users WHERE username = ?";

        if($stmt = mysqli_prepare($sqlcon, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Validate password
    if(empty(trim($_POST['password']))){
        $password_err = "Please enter a password.";
    } elseif(strlen(trim($_POST['password'])) < 8){
        $password_err = "Password must have atleast 8 characters.";
    } else{
        $password = trim($_POST['password']);
    }

    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = 'Please confirm password.';
    } else{
        $confirm_password = trim($_POST['confirm_password']);
        if($password != $confirm_password){
            $confirm_password_err = 'Password did not match.';
        }
    }

    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){

        // Prepare an insert statement
        $sql = "INSERT INTO Users (username, password) VALUES (?, ?)";

        if($stmt = mysqli_prepare($sqlcon, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                $_SESSION['account_created']=true;
                header("location: index.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($sqlcon);
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $title;?> - Register</title>
    <?php
    require_once './includes/head.php';
    ?>
  </head>
  <body>
    <h1>Welcome to Witch Hunt</h1>
    <h2>Register below</h2>
    <form id="signIn" action="register.php" method="post">
      <fieldset>
        <input placeholder="Enter a username" name="username" type="text" value="<?php echo $username; ?>">
        <span class="help-block"><?php echo $username_err; ?></span>
      </fieldset>
      <fieldset>
        <input placeholder="Enter a password" name="password" type="password" value="<?php echo $password; ?>">
        <span class="help-block"><?php echo $password_err; ?></span>
      </fieldset>
      <fieldset>
        <input placeholder="Confirm your password" name="confirm_password" type="password" value="<?php echo $confirm_password; ?>">
         <span class="help-block"><?php echo $confirm_password_err; ?></span>
      </fieldset>
      <fieldset>
        <button type="submit" name="Register_Button">Register</button>
      </fieldset>
    </form>
    <a href="index.php"><h4>Already a member? Sign In here.</h4></a>
  </body>
</html>
