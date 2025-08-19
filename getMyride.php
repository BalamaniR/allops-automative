<?php
#error_reporting(0);
#ini_set('display_errors', 1);
require_once('includes/header.php');
require_once('classes/functions.php');


$uid         = $_SESSION['user_id'];
$customer_id = $_SESSION['customer_id'];
$name = $_SESSION['user_name'];
$email=$_SESSION['user_email'] ;
$user = $obj->get_user_details($email);
$insurancecopyParts = explode('/', $user['insurance_copy_path']);

if (isset($insurancecopyParts[2])) {
   $copyName =  $insurancecopyParts[2]; // Output: insurance_68a345231de076.60706087.jpeg
} 
$journeyData = $obj->get_journey_details($customer_id);

    $from = $_REQUEST['pickup'];
    $to = $_REQUEST['dropoff'];
    $journeyType = $_POST['journey'] ?? '';
    $departDate = $_REQUEST['startDate'];
    $departTime = $_REQUEST['startTime'];
    $carID = $_REQUEST['carbrand'] ?? '';
    $carType   = $_REQUEST['carType'] ?? '';
    $fuel        = $_REQUEST['fuelType'] ?? '';
    $seat        = '';
    $cars = $obj->get_my_carData($carID, $carType, $fuel, $seat);
    $cname = $obj->get_car_name($cars['car_id']);
    $pmtData = $obj->get_pmt_details($customer_id);

?>
<head>
  <meta charset="UTF-8">
  <title>Journey Planner - Allops Automotive Services</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <style>
    .btn:hover{
      background-color: #E76F51;
      border-color: #E76F51;
    }
    .col-md-6{
        font-weight: bold;
    }
    .value_label{
        color:#002D62;
    }

  </style>
</head>
<body>
<div class="container mt-5">
<div class="form-section mb-4">
          <h3 class="mb-4 text-center regTitle">Booking Snapshot</h3>
<hr/>
  <div class="card-body">

    <!-- Row 1: Personal Info -->
    <h5 class="card-title mb-3 regTitle">Rider Info</h5>
    <div class="row mb-2">
      <div class="col-md-6">Customer ID: <span class="value_label"><em><?php echo $customer_id;?></em></span></div>
      <div class="col-md-6">Name: <span class="value_label"><em><?php echo $name;?></em></span></div>
    </div>
    <div class="row mb-2">
      <div class="col-md-6">Email: <span class="value_label"><?php echo $user['user_email'];?></span></div>
      <div class="col-md-6">Phone: <span class="value_label"><?php echo $user['user_phone'];?></span></div>
    </div>
<hr/>
    <h5 class="card-title mb-3 regTitle">Driving Permit</h5>
    <div class="row mb-2">
      <div class="col-md-6">License Number: <span class="value_label"><?php echo$user['user_driver_license_number'];?></span></div>
      <div class="col-md-6"> </div>
    </div>
    <div class="row mb-2">
      <div class="col-md-6">License Issued Date: <span class="value_label"><?php echo $user['user_license_issue_date'];?></span></div>
      <div class="col-md-6">License Expiry Date: <span class="value_label"><?php echo $user['user_license_expiry_date'];?></span></div>
    </div>
<hr/>
    <h5 class="card-title mt-4 mb-3 regTitle">Insurance Details</h5>
    <div class="row mb-2">
      <div class="col-md-6">Policy Number: <span class="value_label"><?php echo $user['insurance_policy_number']; ?></span></div>
      <div class="col-md-6">Policy Company: <span class="value_label"><?php echo $user['insurance_policy_company']; ?></span></div>
    </div>
   
    <div class="row mb-2">
      <div class="col-md-6">View Policy Copy: <span class="value_label">
       <a href="#"  class="img-thumbnail" data-bs-toggle="modal" data-bs-target="#imageModal" style="cursor:pointer;"><?php echo $copyName; ?></a></span></div>
    
    </div>
    <!-- Row 2: Booking Details -->
  
<hr/>

  <h5 class="card-title mt-4 mb-3 regTitle">Journey Details</h5>
    <div class="row mb-2">
      <div class="col-md-6">Pickup: <span class="value_label"><?php echo $journeyData['from_location'];?></span></div>
      <div class="col-md-6">Dropoff: <span class="value_label"><?php echo $journeyData['to_location'];?></span></div>
    </div>
    <div class="row mb-2">
      <div class="col-md-6">Journey Type: <span class="value_label"><?php echo $journeyData['journey_type'];?></span></div>
      <div class="col-md-6">Start Date: <span class="value_label"><?php echo $journeyData['kickoff_date'];?></span></div>
    </div>
    <div class="row mb-2">
      <div class="col-md-6">Start Time: <span class="value_label"><?php echo $journeyData['kickoff_time'];?></span></div>
      <div class="col-md-6">Booking status: <span class="value_label"><?php  if($journeyData['booking_status'] ==1){ echo "Booked";};?></span></div>
    </div>
    <!-- Row 3: Car Info -->
  
<hr/>
    <!-- Row 4: Payment Info -->
  <h5 class="card-title mt-4 mb-3 regTitle">Car Specifications</h5>
    <div class="row mb-2">
      <div class="col-md-6">Brand: <span class="value_label"><?php echo ($cname['car_company_name'] === 'Y') ? 'Yes' : 'No';?></span></div>
      <div class="col-md-6">Type: <span class="value_label"><?php echo ($cars['car_type'] === 'Y') ? 'Yes' : 'No'; ?></span></div>
    </div>
    <div class="row mb-2">
      <div class="col-md-6">Fuel Type: <span class="value_label"><?php echo ($cars['fuel_type'] === 'Y') ? 'Yes' : 'No'; ?></span></div>
      <div class="col-md-6">Transmission: <span class="value_label"><?php echo ($cars['transmission'] === 'Y') ? 'Yes' : 'No';?></span></div>
    </div>
    <div class="row mb-2">
      <div class="col-md-6">GPS: <span class="value_label"><?php echo ($cars['gps'] === 'Y') ? 'Yes' : 'No';?></span></div>
      <div class="col-md-6">A/C: <span class="value_label"><?php echo ($cars['air_conditioned'] === 'Y') ? 'Yes' : 'No';?></span></div>
    </div>
     <div class="row mb-2">
      <div class="col-md-6">Road Assistance : <span class="value_label"><?php echo ($cars['road_assistance'] === 'Y') ? 'Yes' : 'No';?></span></div>
      <div class="col-md-6">Bluetooth: <span class="value_label"><?php echo ($cars['bluetooth'] === 'Y') ? 'Yes' : 'No'; ?></span></div>
    </div>
     <div class="row mb-2">
      <div class="col-md-6">Wi-Fi Hotspot: <span class="value_label"><?php echo ($cars['wifi_hotspot'] === 'Y') ? 'Yes' : 'No';?></span></div>
      <div class="col-md-6">Special Seat For Kid : <span class="value_label"><?php echo ($cars['child_seat'] === 'Y') ? 'Yes' :'No';?></span></div>
    </div>
     <div class="row mb-2">
      <div class="col-md-6">Sirius XM: <span class="value_label"><?php echo ($cars['sirius_xm'] === 'Y') ? 'Yes': 'No';?></span></div>
      <div class="col-md-6">Pick up Choice: <span class="value_label"><?php echo  ($cars['pick_up_choice'] === 'Y') ? 'Yes' :'No';?></span></div>
    </div>
     <div class="row mb-2">
      <div class="col-md-6">Self-Serve kiosk: <span class="value_label"><?php echo ($cars['self-serve kiosk'] === 'Y') ? 'Yes' :'No';?></span></div>
      <div class="col-md-6">Cost Per Day : <span class="value_label"><?php echo  ($cars['cost_per_day'] === 'Y') ? 'Yes' :'No';?></span></div>
    </div>
<hr/>
   <p style="text-align:center;font-size:24px;"><strong style="color:#E76F51;">Daily Rental Rate for this ride: </strong><strong style="color:green"><?php echo $cars['cost_per_day'];?></strong></p>
<hr/>

 <button type="button"  name="btn_reg"  value="Confirm"  class="btn btn-custom btn_confRide w-100">Confirm My Ride</button>
  </div>
</div>
  </div>
<!-- Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="imageModalLabel">Insurance Copy</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <img src="<?php echo $user['insurance_copy_path']; ?>" class="img-fluid" alt="Insurance Copy" />
      </div>
    </div>
  </div>
</div>
</body>


<?php
require_once('includes/footer.php');
?>
<script>
  $(document).ready(function(){
 
    $('.btn_confRide').click(function(){
         
      window.location.href = 'confirm.php';
    })
  })
</script>