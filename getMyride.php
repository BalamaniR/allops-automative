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
    $cname = $obj->get_car_name($carID);
    $pmtData = $obj->get_pmt_details($customer_id);

?>
<head>
  <meta charset="UTF-8">
  <title>Journey Planner - Allops Automative Services</title>
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

    <!-- Row 2: Booking Details -->
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
<hr/>
    <!-- Row 3: Car Info -->
    <h5 class="card-title mt-4 mb-3 regTitle">Car Specifications</h5>
    <div class="row mb-2">
      <div class="col-md-6">Brand: <span class="value_label"><?php echo $cname['car_company_name'];?></span></div>
      <div class="col-md-6">Type: <span class="value_label"><?php echo $cars['car_type'];?></span></div>
    </div>
    <div class="row mb-2">
      <div class="col-md-6">Fuel Type: <span class="value_label"><?php echo $cars['fuel_type'];?></span></div>
      <div class="col-md-6">Transmission: <span class="value_label"><?php echo $cars['transmission'];?></span></div>
    </div>
    <div class="row mb-2">
      <div class="col-md-6">GPS: <span class="value_label"><?php echo $cars['gps'];?></span></div>
      <div class="col-md-6">A/C: <span class="value_label"><?php echo $cars['air_conditioned'];?></span></div>
    </div>
     <div class="row mb-2">
      <div class="col-md-6">Road Assistance :: <span class="value_label"><?php echo $cars['road_assistance'];?></span></div>
      <div class="col-md-6">Bluetooth: <span class="value_label"><?php echo $cars['bluetooth'];?></span></div>
    </div>
     <div class="row mb-2">
      <div class="col-md-6">Wi-Fi Hotspot: <span class="value_label"><?php echo $cars['wifi_hotspot'];?></span></div>
      <div class="col-md-6">Special Seat For Kid : <span class="value_label"><?php echo $cars['child_seat'];?></span></div>
    </div>
     <div class="row mb-2">
      <div class="col-md-6">Sirius XM: <span class="value_label"><?php echo $cars['sirius_xm'];?></span></div>
      <div class="col-md-6">Pick up Choice: <span class="value_label"><?php echo $cars['pick_up_choice'];?></span></div>
    </div>
     <div class="row mb-2">
      <div class="col-md-6">Self-Serve kiosk: <span class="value_label"><?php echo $cars['self-serve kiosk'];?></span></div>
      <div class="col-md-6">Cost Per Day : <span class="value_label"><?php echo $cars['cost_per_day'];?></span></div>
    </div>
<hr/>
    <!-- Row 4: Payment Info -->
    <h5 class="card-title mt-4 mb-3 regTitle">Transaction Info</h5>
    <div class="row mb-2">
      <div class="col-md-6">Method: <span class="value_label"><?php echo $pmtData['pmt_method']; ?></span></div>
      <div class="col-md-6">Status: <span class="value_label"><?php echo $pmtData['pmt_status']; ?></span></div>
    </div>
   
    <div class="row mb-2">
      <div class="col-md-6">paid Amount: <span class="value_label"><?php echo $pmtData['paid_amt']; ?></span></div>
      <div class="col-md-6">Balance Amount: <span class="value_label"><?php echo $pmtData['balance_amt']; ?></span></div>
    </div>
<hr/>
   

  </div>
</div>
  </div>

</body>


<?php
require_once('includes/footer.php');
?>