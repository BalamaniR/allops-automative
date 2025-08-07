<?php

//error_reporting(0);

require_once('includes/header.php');
require_once('classes/functions.php');
$email= $_SESSION['user_email'];
$userId = $_SESSION['user_id']; // user is logged in


$uploadDir = 'uploads/profile_photos/';
$profilePhotoPath = null;

if (isset($_REQUEST['btn_update_profile'])) {
    // Assuming $userId is defined somewhere in your session or passed in
    if (!isset($userId)) {
        echo '<div class="alert alert-danger">User not logged in.</div>';
        return;
    }

    // Sanitize input values
    $phone       = trim($_REQUEST['phone']);
    $address     = trim($_REQUEST['address']);
    $issuedDate  = trim($_REQUEST['lic_issueDate']);
    $expDate     = trim($_REQUEST['lic_exp_date']);

    // Handle profile photo upload
    if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profile_photo']['tmp_name'];
        $fileName    = basename($_FILES['profile_photo']['name']);
        $fileSize    = $_FILES['profile_photo']['size'];
        $fileType    = mime_content_type($fileTmpPath);
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

        if (in_array($fileType, $allowedTypes)) {
            $safeFileName = preg_replace("/[^a-zA-Z0-9\._-]/", "_", $fileName);
            $newFileName  = uniqid('profile_', true) . '.' . pathinfo($safeFileName, PATHINFO_EXTENSION);
            $destPath     = $uploadDir . $newFileName;

            // Create directory if it doesn't exist
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            if (move_uploaded_file($fileTmpPath, $destPath)) {
                $profilePhotoPath = $destPath;
            } else {
                echo '<div class="alert alert-danger">Failed to move uploaded file.</div>';
                return;
            }
        } else {
            echo '<div class="alert alert-danger">Invalid image type. Only JPG, PNG, and GIF are allowed.</div>';
            return;
        }
    }

    // Proceed with updating user data
    if ($profilePhotoPath !== null) {
        $updateSuccess = $obj->update_user_details($userId, $phone, $address, $issuedDate, $expDate, $profilePhotoPath);

        if ($updateSuccess) {
            echo '<div class="alert alert-success">Profile updated successfully!</div>';
        }
    } else {
        echo '<div class="alert alert-danger">Profile picture update failed.</div>';
    }
}



$result = $obj->get_user_details($email);
$dob= date("Y-m-d", strtotime($result['user_dob']));
$issueDate =date("Y-m-d", strtotime($result['user_license_issue_date']));
$expiryDate =date("Y-m-d", strtotime($result['user_license_expiry_date']));
$profilePhotoPath=htmlspecialchars($result['profile_photo']);

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
      max-width: 800px;
      margin: auto;
      padding: 30px;
    }
    .required-label::after {
      content: " *";
      color: red;
    }
    .readonly-field {
    background-color: #e9ecef;
    border: 1px solid #ced4da;
    color: #495057;
  }

  .regTitle {
    font-weight: 600;
    font-size: 1.5rem;
  }
   
  </style>
</head>
<body>

  <div class="text-center mb-4">
    <h4 class="text-warning regTitle">Tune Up Your Info</h4>
  </div>

  <div class="form-section">
<div class="profile-card text-center">
      <img src="<?php echo $profilePhotoPath; ?>" alt="Profile Photo" class="rounded-circle mb-3" width="100">
      <h4 class="fw-bold" style="color: #E76F51!important;font-weight:bold"><?php echo  $result['user_name']; ?></h4>
      <p class="text-muted"><b><i>Customer ID: <?php echo  $result['customer_id']; ?></i></b></p>

      <hr>
  <form method="POST" enctype="multipart/form-data">

  
    <div class="row mb-3">
      <label for="name" class="col-sm-4 col-form-label required-label">Name</label>
      <div class="col-sm-8">
        <input type="text" class="form-control readonly-field" id="name" name="name" readonly value=" <?php echo  $result['user_name']; ?>">
      </div>
    </div>


    <div class="row mb-3">
      <label for="email" class="col-sm-4 col-form-label required-label">Email</label>
      <div class="col-sm-8">
        <input type="email" class="form-control readonly-field" id="email" name="email"  readonly  value="<?php echo  $result['user_email']; ?>">
      </div>
    </div>
    
    <div class="row mb-3">
      <label for="phone" class="col-sm-4 col-form-label required-label">Phone</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" id="phone" name="phone"  value=" <?php echo  $result['user_phone']; ?>">
      </div>
    </div>

    <div class="row mb-3">
      <label for="address" class="col-sm-4 col-form-label required-label">Address</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" id="address" name="address" value=" <?php echo  $result['user_address']; ?>">
      </div>
    </div>

    <div class="row mb-3">
      <label for="dob" class="col-sm-4 col-form-label required-label">DOB</label>
      <div class="col-sm-8">
        <input type="date" class="form-control readonly-field" id="dob" name="dob" readonly value="<?php echo htmlspecialchars($dob); ?>">
      </div>
    </div>

    <div class="row mb-3">
      <label for="license" class="col-sm-4 col-form-label required-label">Driver’s License Number</label>
      <div class="col-sm-8">
        <input type="text" class="form-control readonly-field" id="license" name="license" readonly value=" <?php echo  $result['user_driver_license_number']; ?>">
      </div>
    </div>

    <div class="row mb-3">
      <label for="issue" class="col-sm-4 col-form-label required-label">License Issue Date</label>
      <div class="col-sm-8">
        <input type="date" class="form-control" id="issue" name="lic_issueDate" value="<?php echo htmlspecialchars($issueDate); ?>">
      </div>
    </div>

    <div class="row mb-3">
      <label for="expiry" class="col-sm-4 col-form-label required-label">License Exp. Date</label>
      <div class="col-sm-8">
        <input type="date" class="form-control" id="expiry" name="lic_exp_date" value="<?php echo htmlspecialchars($expiryDate); ?>">
      </div>
    </div>


    <div class="row mb-3">
      <label for="dob" class="col-sm-4 col-form-label required-label">Profile picture</label>
      <div class="col-sm-8">
      <input type="file" name="profile_photo" id="profile_photo" accept="image/*">      </div>
    </div>

    <button type="submit"  name="btn_update_profile"  value="Update Profile"  class="btn btn-custom w-100">Update Profile</button>
  </form>
</div>
  </div>
</body>
</html>
<?php require_once('includes/footer.php');?>