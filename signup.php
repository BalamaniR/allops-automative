<?php 
#error_reporting(0);
require_once('includes/header.php');
require_once('classes/functions.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php'; // Composer autoload
 $msg ='';
 $class='';
function generateTempPassword($length = 10) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    return substr(str_shuffle($chars), 0, $length);
}



if (isset($_GET['success'])) {
    echo '<div class="alert alert-success">Signup successful! A welcome email has been sent. Please <a href="login.php">click here</a> to login.</div>';
}
if (isset($_REQUEST['btn_reg'])) {
      $uname = $_REQUEST['name'];
      $phone = $_REQUEST['phone'];
      $email = filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL);
      $address = $_REQUEST['address'];
      $license_num = $_REQUEST['license'];
      $license_issueDate = $_REQUEST['lic_issueDate'];
      $license_exp_date = $_REQUEST['lic_exp_date'];
      $userExistance = $obj->get_user_details($email);
      $issueDate =$_REQUEST['lic_issueDate'];
      $expiryDate =$_REQUEST['lic_exp_date'];
      $dobInput = $_REQUEST['dob'];

      $errors = [
          'uname' => 'Name field cannot be empty',
          'phone' => 'Phone number cannot be empty',
          'email' => 'Email ID cannot be empty',
          'address' =>'Address cannot be empty',
          'license_num' => 'License Number cannot be empty',
          'license_issueDate' => 'License issue date  cannot be empty',
          'license_exp_date' => 'License Expiry date cannot be empty',
          'dobInput' =>'Date of birth cannot be empty'
      ];

      foreach ($errors as $field => $message) {
          if (empty($$field)) {
              $msg = $message;
              $class = 'error';
              break;
          }
      }

      // Check for existing user
      if (empty($msg) && !empty($userExistance)) {
          $msg = 'Email ID already Exists';
          $class = 'error';
      }

      if (!empty($dobInput)) {
          try {
              $dob = new DateTime($dobInput);
              $today = new DateTime();
              $age = $dob->diff($today)->y;

              if ($age < 16) {
                  $msg = "You must be at least 16 years old to sign up.";
                  $class = 'error';
              }
          } catch (Exception $e) {
              $msg = "Invalid date format. Please enter DOB in YYYY-MM-DD format.";
              $class = 'error';
          }
      } else {
          $msg = "Date of birth cannot be empty.";
          $class = 'error';
      }
    
      // Validate license dates
      if (empty($msg)) {
          try {
              $userLicissueDate = new DateTime($license_issueDate);
              $userLicexpiryDate = new DateTime($license_exp_date);

              if ($userLicexpiryDate <= $userLicissueDate) {
                  $msg = "Expiry date must be after the issue date.";
                  $class = "error";
              }
          } catch (Exception $e) {
              $msg = "Invalid license date format.";
              $class = "error";
          }
      }

     $error = validateLicense($age, $issueDate);
      if ($error) {
         $msg = $error;
         $class= "error";
      }
      // If no errors, proceed with DB insert and email
      if (empty($msg)) {
            $user = $obj->add_user_data($uname,$phone, $email, $address,$license_num,$issueDate,$expiryDate,$dobInput);
            $tempPassword = generateTempPassword();
            if ($user) {
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
                        header("Location: signup.php?success=1");
                        exit;
                       # echo '<div class="alert alert-success">Signup successful! A welcome email has been sent.Please <a href="login.php">click here</a> to login</div>';
                    } catch (Exception $e) {
                        #echo '<div class="alert alert-warning">Signup worked, but email failed: ' . $mail->ErrorInfo . '</div>';
                    }              
              } else {
                  echo '<div class="alert alert-danger">Signup failed. Please try again.</div>';
              } 
        }

  }
function validateLicense($age, $userLicissueDate) {
    $today = new DateTime();
    $licenseIssued = new DateTime($userLicissueDate);
    $interval = $today->diff($licenseIssued);
    $licenseYearsAgo = $interval->y;

  
    if ($age < $licenseYearsAgo ) {
        return "Invalid license: Issued too early for the user's age.";
    }
    return null; // No error
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
    .error{
      color:red;
      text-align: center;
      margin-bottom: 20px;
      font-weight: bold;
    }
   
  </style>
</head>
<body>

  <div class="text-center mb-4">
    <h4 class="text-warning regTitle">Sign Up to Start Cruising</h4>
  </div>
<div class="<?php echo $class;?>"><?php echo $msg;?></div>

  <div class="form-section">
  <form id="RegistrationForm"  method="POST">
    <div class="row mb-3">
      <label for="name" class="col-sm-4 col-form-label required-label">Name</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
      </div>
    </div>

    <div class="row mb-3">
      <label for="phone" class="col-sm-4 col-form-label required-label">Phone</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
      </div>
    </div>

    <div class="row mb-3">
      <label for="email" class="col-sm-4 col-form-label required-label">Email</label>
      <div class="col-sm-8">
        <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
      </div>
    </div>

    <div class="row mb-3">
      <label for="address" class="col-sm-4 col-form-label required-label">Address</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" id="address" name="address" value="<?= htmlspecialchars($_POST['address'] ?? '') ?>">
      </div>
    </div>

    <div class="row mb-3">
      <label for="dob" class="col-sm-4 col-form-label required-label">DOB</label>
      <div class="col-sm-8">
        <input type="date" class="form-control" id="dob" name="dob" value="<?= htmlspecialchars($_POST['dob'] ?? '') ?>">
      </div>
    </div>

    <div class="row mb-3">
      <label for="license" class="col-sm-4 col-form-label required-label">Driver’s License Number</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" id="license" name="license" value="<?= htmlspecialchars($_POST['license'] ?? '') ?>">
      </div>
    </div>

    <div class="row mb-3">
      <label for="issue" class="col-sm-4 col-form-label required-label">License Issue Date</label>
      <div class="col-sm-8">
        <input type="date" class="form-control" id="issue" name="lic_issueDate" value="<?= htmlspecialchars($_POST['lic_issueDate'] ?? '') ?>">
      </div>
    </div>

    <div class="row mb-3">
      <label for="expiry" class="col-sm-4 col-form-label required-label">License Exp. Date</label>
      <div class="col-sm-8">
        <input type="date" class="form-control" id="expiry" name="lic_exp_date" value="<?= htmlspecialchars($_POST['lic_exp_date'] ?? '') ?>">
      </div>
    </div>

    
    <button type="submit"  name="btn_reg"  value="SignUp"  class="btn btn-custom w-100">Sign Up</button>
  </form>
</div>

</body>
</html>
<?php require_once('includes/footer.php');?>
