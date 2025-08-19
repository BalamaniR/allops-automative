<?php 
error_reporting(0);
require_once('includes/header.php');
require_once('classes/functions.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php'; // Composer autoload
 $msg ='';
 $class='';
 $age = null;
 $userLicissueDate = null;
 $userLicexpiryDate = null;
function generateTempPassword($length = 10) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    return substr(str_shuffle($chars), 0, $length);
}

$uploadDir = 'uploads/insurance_copy/';
$insuranceCopyPath = null;
if (isset($_GET['success'])) {
    echo '<div class="alert alert-success">Signup successful! A welcome email has been sent. Please <a href="login.php">click here</a> to login.</div>';
}
if (isset($_REQUEST['btn_reg'])) {
  $uname = $_REQUEST['name'];
$phone = $_REQUEST['phone'];
$email = filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL);
$address = $_REQUEST['address'];
$dobInput = $_REQUEST['dob'];
$license_num = $_REQUEST['license'];
$license_issueDate = $_REQUEST['lic_issueDate'];
$license_exp_date = $_REQUEST['lic_exp_date'];
$policyNumber = $_REQUEST['policyno'];
$policyCompany = $_REQUEST['incuranceCompany'];
$insuranceCopy = $_FILES['insurance_copy'] ?? null;

$userExistance = $obj->get_user_details($email);

// Required field checks
$requiredFields = [
    'uname' => 'Name field cannot be empty',
    'phone' => 'Phone number cannot be empty',
    'email' => 'Email ID cannot be empty',
    'address' => 'Address cannot be empty',
    'dobInput' => 'Date of birth cannot be empty',
    'license_num' => 'License Number cannot be empty',
    'license_issueDate' => 'License issue date cannot be empty',
    'license_exp_date' => 'License Expiry date cannot be empty',
    'policyNumber'=>'Policy Number Cannot be empty',
    'policyCompany'=>'Policy Company Cannot be empty'
];

foreach ($requiredFields as $field => $message) {
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

// Validate DOB and age
if (empty($msg)) {
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
}



// Validate license dates
if (empty($msg)) {
    try {
        $userLicissueDate = new DateTime($license_issueDate);
        $userLicexpiryDate = new DateTime($license_exp_date);
        $currentDate = new DateTime();
        if ($userLicexpiryDate <= $userLicissueDate) {
            $msg = "Expiry date must be after the issue date.";
            $class = "error";
        }
        if ($userLicexpiryDate < $currentDate) {
            $msg = "License got Expired.";
            $class = "error";
        }
    } catch (Exception $e) {
        $msg = "Invalid license date format.";
        $class = "error";
    }
}

// Validate license issuance age
if (empty($msg) && isset($age) && $userLicissueDate instanceof DateTime) {
    $error = $obj->validateLicense($age, $userLicissueDate,$dob);
    if ($error) {
        $msg = $error;
        $class = "error";
    }
}

// Insurance validation
$insuranceErrors = [];
if (empty($msg)) {
    $insuranceErrors = [];

    if (empty($insuranceCopy['name'])) {
        $insuranceErrors[] = "Insurance copy is mandatory.";
    } elseif ($insuranceCopy['error'] !== UPLOAD_ERR_OK) {
        $insuranceErrors[] = "File uploading error.";
    }

    if (!empty($insuranceErrors)) {
        $msg = implode('<br>', $insuranceErrors);
        $class = "error";
    }


      if (isset($_FILES['insurance_copy']) && $_FILES['insurance_copy']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['insurance_copy']['tmp_name'];
        $fileName    = basename($_FILES['insurance_copy']['name']);
        $fileSize    = $_FILES['insurance_copy']['size'];
        $fileType    = mime_content_type($fileTmpPath);
        $allowedTypes = ['image/jpeg', 'image/png','image/pdf', 'image/gif'];
        if (in_array($fileType, $allowedTypes)) {
            $safeFileName = preg_replace("/[^a-zA-Z0-9\._-]/", "_", $fileName);
            $newFileName  = uniqid('insurance_', true) . '.' . pathinfo($safeFileName, PATHINFO_EXTENSION);
            $destPath     = $uploadDir . $newFileName;
            // Create directory if it doesn't exist
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                $insuranceCopyPath = $destPath;
            } else {
                echo '<div class="alert alert-danger">Failed to move uploaded file.</div>';
                return;
            }
        } else {
            echo '<div class="alert alert-danger">Invalid image type. Only JPG, PNG, and GIF are allowed.</div>';
            return;
        }
}
      // If no errors, proceed with DB insert and email
      if (empty($msg)) {
            $user = $obj->add_user_data($uname,$phone, $email, $address,$license_num,$license_issueDate,$license_exp_date,$dobInput,$policyNumber,$policyCompany,$insuranceCopyPath);
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
                        $mail->setFrom('bala621986@gmail.com', 'Allops Automotive services Team');
                        $mail->addAddress($email, $uname);
                        $mail->isHTML(false);
                        $mail->Subject = 'Welcome to Allops Automotive Services';
                        $mail->Body    = "Hello $uname,\n\nWelcome to allops Automotive Services!\nYour temporary password is: 
                        $tempPassword\nPlease change it after your first login.\n\nBest,\nAllops Automotive Services Team";
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
     
}     

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Allops Allops Automotive Services</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
  <style>
 
    .form-section {
      max-width: 650px;
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
  <form id="RegistrationForm"  method="POST" enctype="multipart/form-data">
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
      
  <div id="insuranceDiv">
    <div class="row mb-3">
      <label for="policy" class="col-sm-4 col-form-label required-label">Policy Number</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" id="policyno" name="policyno" value="<?= htmlspecialchars($_POST['policyno'] ?? '') ?>" >
      </div>
    </div>
 
    <div class="row mb-3">
      <label for="inscomp" class="col-sm-4 col-form-label required-label">Insurance Company</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" id="incuranceCompany" name="incuranceCompany" value="<?= htmlspecialchars($_POST['incuranceCompany'] ?? '') ?>" >
      </div>
    </div>

     <div class="row mb-3">
      <label for="inscopy" class="col-sm-4 col-form-label required-label">Insurance Copy</label>
      <div class="col-sm-8">
        <input type="file" name="insurance_copy" id="insurance_copy" accept="image/*">      
      </div>
    </div>

  </div>
    
    <button type="submit"  name="btn_reg"  value="SignUp"  class="btn btn-custom w-100">Sign Up</button>
  </form>
</div>

</body>
</html>
<?php require_once('includes/footer.php');?>
<script>
  $(document).ready(function(){
   // $('#insuranceDiv').hide();
    $('input[name="insurance"]').on('change', function () {
      console.log($(this).val());
    if ($(this).val() === 'Yes') {
      
      $('#insuranceDiv').slideDown(); // Show with animation
    } else {
      $('#insuranceDiv').slideUp(); // Hide with animation
    }
  });
  })
</script>