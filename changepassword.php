<?php 
error_reporting(0);
session_start(); 

require_once('includes/header.php');
require_once('classes/functions.php');
if (isset($_REQUEST['btn_update'])) {
  $pwd = $_REQUEST['txt_npass'];
  $cpwd = $_REQUEST['txt_cpass'];
  $email= $_SESSION['user_email']; 
  if(TRIM($pwd) == TRIM($cpwd)){
    $pwd= base64_encode($pwd);
    $updatepwd = $obj->update_change_password($email,$pwd);
     header("Location: search.php");
        exit();
  }else if(TRIM($pwd) != TRIM($cpwd)){
  echo '<div class="alert alert-danger">Confirm Password is mismatch with new password.</div>';
  }else{
      echo '<div class="alert alert-danger">Failed to Update password.</div>';
  }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login to Allops Automotive Services</title>
  
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
    <style>
 
    .form-section {
      max-width: 500px;
      margin: auto;
      padding: 30px;
    }
    .required-label::after {
      content: " *";
      color: red;
    }
   
  </style>
</head>
<body>
 <div class="text-center mb-4">
    <h4 class="text-warning regTitle">Change your password Securely</h4>
  </div>

  <div class="form-section">
  <form method="POST">
    <div class="row mb-3">
      <label for="npass" class="col-sm-4 col-form-label required-label">New Password</label>
      <div class="col-sm-8">
        <input type="password" class="form-control" id="txt_npass" name="txt_npass">
      </div>
    </div>

    <div class="row mb-3">
      <label for="cpass" class="col-sm-4 col-form-label required-label">Confirm Password</label>
      <div class="col-sm-8">
        <input type="password" class="form-control" id="txt_cpass" name="txt_cpass">
      </div>
    </div>

    <button type="submit"  name="btn_update"  value="Update"  class="btn btn-custom w-100">Update</button>
  </form>
</div>
</body>
</html>
<?php require_once('includes/footer.php');?>
<script>
  $(document).ready(function () {
    // Handle request for OTP
    $('#requestForm').on('submit', function (e) {
      e.preventDefault();
      alert("OTP sent successfully!");
      $('#otpForm').show(); // reveal OTP section
    });

    // Handle OTP verification
    $('#otpForm').on('submit', function (e) {
      e.preventDefault();
      alert("OTP Verified. You may now reset your password.");
    });
  });
</script>