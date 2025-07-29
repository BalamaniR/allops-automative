<?php 
require_once('includes/header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login to Allops Automative</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>
<body>
  <div class="login-container text-center">
    <h2 class="mb-4">Login to Allops Automative</h2>
    <form>
  <div class="mb-3 text-start">
    <label for="email" class="form-label">Email address</label>
    <input type="email" class="form-control" id="email" placeholder="Enter email">
  </div>
  <div class="mb-3 text-start">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" id="password" placeholder="Password">
  </div>
  
  <div class="d-flex justify-content-between mb-3">
    <a href="forgotpwd.php" class="text-decoration-none pgLink"><i>Forgot Password?</i></a>
    <a href="signup.php" class="text-decoration-none pgLink"><i>New User? Register</i></a>
  </div>

  <button type="submit" class="btn btn-custom btn-block w-100">Login</button>
</form>
  </div>
</body>
</html>
<?php require_once('includes/footer.php');?>