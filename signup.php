<?php 
error_reporting(0);
require_once('includes/header.php');
require_once('classes/functions.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php'; // Composer autoload


if (isset($_REQUEST['btn_reg'])) {


    $uname = $_REQUEST['name'];
    $phone = $_REQUEST['phone'];
    $email = filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL);
    $address = $_REQUEST['address'];
    $license_num = $_REQUEST['license'];
    $license_issueDate = $_REQUEST['lic_issueDate'];
    $license_exp_date = $_REQUEST['lic_exp_date'];
    $dob = $_REQUEST['dob']; 
}
$user = $obj->add_user_data($uname,$phone, $email, $address,$license_num,$license_issueDate,$license_exp_date,$dob);

function generateTempPassword($length = 10) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    return substr(str_shuffle($chars), 0, $length);
}

$tempPassword = generateTempPassword();
if ($user) {
   $pass = 'bsvv tpfm pyqy ilig';
   $updatepass = $obj->update_user_password($user, $tempPassword);

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'bala621986@gmail.com';
        $mail->Password   = 'bsvv tpfm pyqy ilig';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('bala621986@gmail.com', 'Allops Automative services Team');
        $mail->addAddress($email, $uname);

        $mail->isHTML(false);
        $mail->Subject = 'Welcome to Allops Automotive Services';
        $mail->Body    = "Hello $uname,\n\nWelcome to allops automative Services!\nYour temporary password is: 
        $tempPassword\nPlease change it after your first login.\n\nBest,\nAllops Automative Services Team";

        $mail->send();
        echo '<div class="alert alert-success">Signup successful! A welcome email has been sent.Please <a href="login.php">click here</a> to login</div>';


    } catch (Exception $e) {
        echo '<div class="alert alert-warning">Signup worked, but email failed: ' . $mail->ErrorInfo . '</div>';
    }
  
} else {
    echo '<div class="alert alert-danger">Signup failed. Please try again.</div>';
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Allops Allops Automative Services</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
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
    <h4 class="text-warning regTitle">Sign Up to Start Cruising</h4>
  </div>

  <div class="form-section">
  <form method="POST">
    <div class="row mb-3">
      <label for="name" class="col-sm-4 col-form-label required-label">Name</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" id="name" name="name">
      </div>
    </div>

    <div class="row mb-3">
      <label for="phone" class="col-sm-4 col-form-label required-label">Phone</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" id="phone" name="phone">
      </div>
    </div>

    <div class="row mb-3">
      <label for="email" class="col-sm-4 col-form-label required-label">Email</label>
      <div class="col-sm-8">
        <input type="email" class="form-control" id="email" name="email">
      </div>
    </div>

    <div class="row mb-3">
      <label for="address" class="col-sm-4 col-form-label required-label">Address</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" id="address" name="address">
      </div>
    </div>

    <div class="row mb-3">
      <label for="license" class="col-sm-4 col-form-label required-label">Driver’s License Number</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" id="license" name="license">
      </div>
    </div>

    <div class="row mb-3">
      <label for="issue" class="col-sm-4 col-form-label required-label">License Issue Date</label>
      <div class="col-sm-8">
        <input type="date" class="form-control" id="issue" name="lic_issueDate">
      </div>
    </div>

    <div class="row mb-3">
      <label for="expiry" class="col-sm-4 col-form-label required-label">License Exp. Date</label>
      <div class="col-sm-8">
        <input type="date" class="form-control" id="expiry" name="lic_exp_date">
      </div>
    </div>

    <div class="row mb-3">
      <label for="dob" class="col-sm-4 col-form-label required-label">DOB</label>
      <div class="col-sm-8">
        <input type="date" class="form-control" id="dob" name="dob">
      </div>
    </div>

    <button type="submit"  name="btn_reg"  value="SignUp"  class="btn btn-custom w-100">Sign Up</button>
  </form>
</div>

</body>
</html>
<?php require_once('includes/footer.php');?>