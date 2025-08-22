<?php 
#error_reporting(0);

require_once('includes/header.php');
require_once('classes/functions.php');
 $msg ='';
 $class='';
if (isset($_REQUEST['btn_login'])) {
    $email = filter_var($_REQUEST['txt_email'], FILTER_VALIDATE_EMAIL);
    $pass = $_REQUEST['txt_pwd'];
    if($email == ""){
          $msg = 'Email ID Cannot be Empty';
          $class = 'error';
    }else if($pass == ""){
          $msg = 'Password Cannot be Empty';
          $class = 'error';
    }else{
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
                    $_SESSION['customer_id'] = $user['customer_id']; 
                   
                      header("Location: dashboard.php");
                      exit();
                   
                } else {
                // User details not found (very rare if validation passed)
               #  echo '<div class="alert alert-danger">User details not found.</div>';
                    $msg = 'User details not found.';
                    $class = 'error';
                }
          } else {
                    $msg = 'Login failed. Please check your email and password.';
                    $class = 'error';
                #echo '<div class="alert alert-danger">Login failed. Please check your email and password.</div>';
          }
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
    <style>

     .required-label::after {
      content: " *";
      color: red;
    }
    .error{
      color:red;
      text-align: center;
      margin-bottom: 20px;
      font-weight: bold;
    }
   
  </style>
</head>
<body>
  <div class="login-container text-center">
    <h2 class="mb-4">Login to Allops Automative Services</h2>


    <div class="<?php echo $class;?>"><?php echo $msg;?></div>
    <form method="POST">
  <div class="mb-3 text-start">
    <label for="email" class="form-label">Email address</label>
    <input type="email" class="form-control" id="email" name="txt_email" value="<?= htmlspecialchars($_POST['txt_email'] ?? '') ?>" placeholder="Enter email">
  </div>
  <div class="mb-3 text-start">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" id="password"  value="<?= htmlspecialchars($_POST['txt_pwd'] ?? '') ?>"  name="txt_pwd" placeholder="Password">
  </div>
  
  <div class="d-flex justify-content-between mb-3">
    <a href="forgotpwd.php" class="text-decoration-none pgLink"><i>Forgot Password?</i></a>
  </div>

  <button type="submit" name="btn_login" class="btn btn-custom btn-block w-100">Login</button>
</form>
  </div>
</body>
</html>
<?php require_once('includes/footer.php');?>