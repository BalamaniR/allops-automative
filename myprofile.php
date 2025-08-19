<?php 
error_reporting(0);
require_once('includes/header.php');
require_once('classes/functions.php');
 $email= $_SESSION['user_email'];
 $uid         = $_SESSION['user_id'];
 $customer_id = $_SESSION['customer_id'];
 $result = $obj->get_user_details($email);
 $profilePhotoPath=htmlspecialchars($result['profile_photo']);
 $totalrides = $obj->get_ride_count($uid);
 $latestRide = $obj->get_journey_details($customer_id);
 $latestpmt = $obj->get_latest_pmt_details($uid);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Profile - Allops Automotive Services</title>
   <link href="css/style.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    .profile-card {
      max-width: 600px;
      margin: auto;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>

  <div class="container mt-5">
    <div class="profile-card text-center">
      <img src="<?php echo $profilePhotoPath; ?>" alt="Profile Photo" class="rounded-circle mb-3" width="100">
      <h4 class="fw-bold" style="color: #E76F51!important;font-weight:bold"><?php echo  $result['user_name']; ?></h4>
      <p class="text-muted"><b><i>Customer ID: <?php echo  $result['customer_id']; ?></i></b></p>

      <hr>

      <div class="text-start">
        <p><i class="bi bi-person-fill me-2"></i><strong>Name:</strong> <?php echo  $result['user_name']; ?> </p>
        <p><i class="bi bi-envelope-fill me-2"></i><strong>Email:</strong> <?php echo  $result['user_email']; ?></p>
        <p><i class="bi bi-phone-fill me-2"></i><strong>Phone:</strong> <?php echo  $result['user_phone']; ?></p>
        <p><i class="bi bi-geo-alt-fill me-2"></i><strong>Address:</strong> <?php echo  $result['user_address']; ?></p>
        <p><i class="bi bi-calendar-fill me-2"></i><strong>Date of Birth:</strong> <?php echo  $result['user_dob']; ?></p>
        <p><i class="bi bi-card-text me-2"></i><strong>License No:</strong><?php echo  $result['user_driver_license_number']; ?></p>
        <p><i class="bi bi-card-text me-2"></i><strong>License Issue Date:</strong><?php echo  $result['user_license_issue_date']; ?></p>
        <p><i class="bi bi-calendar-check-fill me-2"></i><strong>License Expiry:</strong> <?php echo  $result['user_license_expiry_date']; ?></p>
         <p><i class="bi bi-card-text me-2"></i><strong>Insurance Number:</strong><?php echo  $result['insurance_policy_number']; ?></p>
        <p><i class="bi bi-building me-2"></i><strong>Insurance Company:</strong> <?php echo  $result['insurance_policy_company']; ?></p>
      </div>

      <hr>
    
        <h5 class="text-start mb-3" style="color: #E76F51!important;font-weight:bold"><i class="bi bi-clock-history me-2"></i> Ride Summary</h5>

        <div class="text-start">
        <p><i class="bi bi-car-front-fill me-2"></i><strong>Total Rides:</strong> <?php echo  $totalrides['cnt'];?></p>
        <p><i class="bi bi-calendar-event-fill me-2"></i><strong>Last Ride:</strong><?php echo $latestRide['kickoff_date']?></p>
        <p><i class="bi bi-geo-fill me-2"></i><strong>Route:</strong> <?php echo $latestRide['from_location']?> → <?php echo $latestRide['to_location']?></p>
        <p><i class="bi bi-currency-dollar me-2"></i><strong>Cost:</strong> <?php echo $latestpmt['total_amt_paid']?></p>
        <hr>
        <div class="text-end mt-3">
            <a class="btn btn-warning me-2" href="editprofile.php">
                <i class="bi bi-pencil-square"></i> Edit Profile
            </a>
            <button class="btn btn-danger">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </div>
    </div>
  </div>
  </div>
</body>
</html>
<?php require_once('includes/footer.php');?>