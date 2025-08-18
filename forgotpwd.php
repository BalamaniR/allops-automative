<?php 
error_reporting(0);
require_once('includes/header.php');
require_once('includes/header.php');
require_once('classes/functions.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php'; // Composer autoload
if (isset($_REQUEST['btn_forgotpwd'])) {
  $email = filter_var($_REQUEST['txt_email'], FILTER_VALIDATE_EMAIL);
   $sendPwd = $obj->get_user_password($email);
   $password = $sendPwd['user_password'];
   $updatepass = $obj->update_password_flag($email);

    if ($sendPwd) {
      $mail = new PHPMailer(true);
      try {
          $mail->isSMTP();
          $mail->Host       = 'smtp.gmail.com';
          $mail->SMTPAuth   = true;
          $mail->Username   = 'bala621986@gmail.com';
          $mail->Password   = 'bsvv tpfm pyqy ilig';
          $mail->SMTPSecure = 'tls';
          $mail->Port       = 587;
          $mail->setFrom('support@allops.com', 'Allops Automotive services Team');
          $mail->addAddress($email, $uname);
          $mail->isHTML(false);
          $mail->Subject = 'Your Temporary Password - Allops Automotive Services';
          $mail->Body    = <<<EOT
                        Hello $uname,
                        Welcome to Allops Automotive Services!
                        Your temporary password is: $password
                        Please change it after your first login for security reasons.
                        Best regards,
                        Allops Automotive Services Team
                        EOT;
          $mail->send();
          echo '<div class="alert alert-success">Password  successfully sent to your registered email ID!  Please <a href="login.php">click here</a> to login.</div>';
      } catch (Exception $e) {
          echo '<div class="alert alert-warning">Email Sent failed: ' . htmlspecialchars($mail->ErrorInfo) . '</div>';
      }
  } else {
      echo '<div class="alert alert-danger">Login failed. Please check the given Email ID is Registered with us or not.</div>';
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
</head>
<body>
 
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card p-4 shadow">
                <div class="text-center mb-4">
                        <h4 class="text-warning regTitle">Trouble signing in? Need a reset?</h4>
                </div>
          
          <!-- Step 1: Request email or phone -->
          <form method="POST">
            <div class="mb-3">
              <label for="userContact" class="form-label">Email</label>
              <input type="text" class="form-control" id="userEmail" name="txt_email" placeholder="Enter email or phone" required>
            </div>
            <button type="submit"  name="btn_forgotpwd"  value="Send" class="btn btn-primary btn-custom w-100">Send</button>
          </form>

          <hr>


        </div>
      </div>
    </div>
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