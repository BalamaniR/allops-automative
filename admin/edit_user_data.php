<?php 
error_reporting(0);

require_once('includes/header.php');
require_once('classes/functions.php');
$cid= $_REQUEST['cid'];
$user = $obj->get_user_journey_details($cid);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login to Allops Automative Services</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <style>

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
                <div class="col-md-6">Customer ID: <span class="value_label"><em><?php echo $cid;?></em></span></div>
                <div class="col-md-6">Name: <span class="value_label"><em><?php echo $user['user_name'];?></em></span></div>
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
                <div class="col-md-6">Pickup: <span class="value_label"><?php echo $user['from_location'];?></span></div>
                <div class="col-md-6">Dropoff: <span class="value_label"><?php echo $user['to_location'];?></span></div>
                </div>
                <div class="row mb-2">
                <div class="col-md-6">Journey Type: <span class="value_label"><?php echo $user['journey_type']?></span></div>
                <div class="col-md-6">Start Date: <span class="value_label"><?php echo $user['kickoff_date']?></span></div>
                </div>
                <div class="row mb-2">
                <div class="col-md-6">Start Time: <span class="value_label"><?php echo $user['kickoff_time']?></span></div>
                </div>
                <!-- Row 3: Car Info -->
            <hr/>
            <form class="row g-3 align-items-center p-3 border rounded shadow mt-5">
             <h5 class="card-title mb-3 regTitle">Payment Details</h5>

            <div class="col-md-auto">
                <label for="amountPaid" class="form-label">Amount (₹)</label>
                <input type="number" class="form-control" id="amountPaid" name="amount_paid" placeholder="₹0" required>
            </div>

            <div class="col-md-auto">
                <label for="paymentType" class="form-label">Type</label>
                <select class="form-select" id="paymentType" name="payment_type" required>
                <option value="">Choose</option>
                <option value="Full">Full</option>
                <option value="Partial">Partial</option>
                </select>
            </div>

            <div class="col-md-auto">
                <label for="paymentMethod" class="form-label">Method</label>
                <select class="form-select" id="paymentMethod" name="payment_method" required>
                <option value="">Choose</option>
                <option value="Online">Online</option>
                <option value="Cash">Cash</option>
                <option value="UPI">UPI</option>
                <option value="Card">Card</option>
                </select>
            </div>

             <div class="col-md-auto">
                <label for="journeystatus" class="form-label">Journey Status</label>
                <select class="form-select" id="journeystatus" name="journeystatus" required>
                <option value="">Choose</option>
                <option value="Online">Started</option>
                <option value="Card">Cancelled</option>
                <option value="Card">End</option>
                </select>
            </div>

            <div class="col-md-auto">
                <label for="paidTo" class="form-label">Paid To</label>
                <input type="text" class="form-control" id="paidTo" name="paid_to" placeholder="Recipient" required>
            </div>

            <div class="col-md-auto mt-4">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
        </div>
    </div>
 </div>


   </body>
</html>
<?php require_once('includes/footer.php');?>