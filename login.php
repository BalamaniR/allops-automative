<?php 
//error_reporting(0);

require_once('includes/header.php');
require_once('classes/functions.php');
if (isset($_REQUEST['btn_login'])) {

    $email = filter_var($_REQUEST['txt_email'], FILTER_VALIDATE_EMAIL);
    $pass = $_REQUEST['txt_pwd'];

    // Validate user credentials first
    $validate = $obj->validate_user_password($email, $pass);

    if ($validate == 1) {
        // Get user details including user ID from email
        $user = $obj->get_user_by_email($email);

        if ($user) {
            // Set session variables AFTER successful validation
            $_SESSION['user_email'] = $email;
            $_SESSION['user_id'] = $user['user_id'];  // or whatever your ID column is called
            $_SESSION['user_name'] = $user['user_name']; 
            $flagVal = $obj->get_pwd_change_flag($email);
            $flag = $flagVal['user_pwd_update'];

            if ($flag =="" || $flag== 2 || $flag ==0) {
                header("Location: changepassword.php");
                exit();
            } else {
                header("Location: search.php");
                exit();
            }
        } else {
            // User details not found (very rare if validation passed)
            echo '<div class="alert alert-danger">User details not found.</div>';
        }
    } else {
        echo '<div class="alert alert-danger">Login failed. Please check your email and password.</div>';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login to Allops Automative Services</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>
<body>
  <div class="login-container text-center">
    <h2 class="mb-4">Login to Allops Automative Services</h2>
    <form method="POST">
  <div class="mb-3 text-start">
    <label for="email" class="form-label">Email address</label>
    <input type="email" class="form-control" id="email" name="txt_email" placeholder="Enter email">
  </div>
  <div class="mb-3 text-start">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" id="password" name="txt_pwd" placeholder="Password">
  </div>
  
  <div class="d-flex justify-content-between mb-3">
    <a href="forgotpwd.php" class="text-decoration-none pgLink"><i>Forgot Password?</i></a>
    <a href="signup.php" class="text-decoration-none pgLink"><i>New User? Register</i></a>
  </div>

  <button type="submit" name="btn_login" class="btn btn-custom btn-block w-100">Login</button>
</form>
  </div>
</body>
</html>
<?php require_once('includes/footer.php');?>