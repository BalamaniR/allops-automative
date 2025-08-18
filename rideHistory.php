<?php
error_reporting(0);
session_start();
require_once('includes/header.php');
require_once('classes/functions.php');
$uid         = $_SESSION['user_id'];
$customer_id = $_SESSION['customer_id'];

$history = $obj->get_myride_history($customer_id);
#$carData = $obj->get_myride_history($customer_id);
$pmt = $obj->get_pmt_details($customer_id);
?>
<head>
  <meta charset="UTF-8">
  <title>Journey Planner - Allops Automotive Services</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  </head>
<body>
<div class="container mt-5">
        <!--  Form Section -->
    <div class="form-section mb-4">
        <h2 style="text-align: center;">Rental Timeline</h2>
        <table class="table table-hover">
            <thead>
                <tr>
                <th scope="col" style="color:#E76F51;">#</th>
                <th scope="col" style="color:#E76F51;">From Location</th>
                <th scope="col" style="color:#E76F51;">To Location</th>
                <th scope="col" style="color:#E76F51;">Kick Off Date</th>
                <th scope="col" style="color:#E76F51;">Kick Of Time</th>
                <th scope="col" style="color:#E76F51;">Drop off Date</th>
                <th scope="col" style="color:#E76F51;">Drop Off Time</th>
                <th scope="col" style="color:#E76F51;">Days</th>
                <th scope="col" style="color:#E76F51;">Car</th>
                <th scope="col" style="color:#E76F51;">Amount Paid</th>
                </tr>
            </thead>
        <tbody>
           <?php $i=0;
           if (!empty($history)) {
             foreach($history as $data){
                $i++;
                $pmt = $obj->get_pmt_details($customer_id);
            
            ?>
                <tr>
                    <td><?php echo $i;?></td>
                    <td><?php echo $data['from_location'];?></td>
                    <td><?php echo $data['to_location'];?></td>
                    <td><?php echo $data['kickoff_date'];?></td>
                    <td><?php echo $data['kickoff_time'];?></td>
                    <td><?php echo $data['dropoff_date'];?></td>
                    <td><?php echo $data['dropoff_time'];?></td>
                    <td><?php echo $data['journeyDays'];?></td>
                    <td><?php echo "Toyato"?></td>
                    <td><?php echo $pmt['paid_amt'];?></td>
                </tr>
            <?php }} else {
                echo "No cars found or error in query.";
            }?>
</body>

</html>