<?php
#error_reporting(0);
#ini_set('display_errors', 1);
require_once('includes/header.php');
require_once('classes/functions.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php'; // Composer autoload
$name = $_SESSION['user_name'];
$email=$_SESSION['user_email'] ;
$customer_id = $_SESSION['customer_id'];
$latestRide = $obj->get_journey_details($customer_id);
$carDetails = $obj->get_my_cardetails($customer_id);
$from =$latestRide['from_location'];
$to=$latestRide['to_location'];
$startDate =$latestRide['kickoff_date'];
$startTime= $latestRide['kickoff_time'];


 $user = $obj->get_user_details($email);
            if ($user) {
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
                        $mail->addAddress($email, $name);
                        $mail->isHTML(false);
                        $mail->Subject = 'Welcome to Allops Automotive Services';
                        $mail->Body   = <<<EOT
                        Hello $name,
                        your Toyota Economy ride has been successfully booked!
                       
                        Thank you for trusting Allops and choosing to ride with us.
                        Your journey details are provided below.
                        
                        Location From :  $from
                        location To   :  $to
                        Journey Start Date : $startDate
                        Journey Start Time : $startTime

                        Wishing you a smooth and joyful drive ahead!

                        Best regards,
                        Allops Automotive Services Team
                        EOT;
                        $mail->send();
                       # header("Location: signup.php?success=1");
                       # exit;
                       # echo '<div class="alert alert-success">Signup successful! A welcome email has been sent.Please <a href="login.php">click here</a> to login</div>';
                    } catch (Exception $e) {
                        #echo '<div class="alert alert-warning">Signup worked, but email failed: ' . $mail->ErrorInfo . '</div>';
                    }              
              } else {
                  echo '<div class="alert alert-danger">Signup failed. Please try again.</div>';
              } 

?>
<head>
  <meta charset="UTF-8">
  <title>Journey Planner - Allops Automotive Services</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  </head>
<body>
    <div class="container mt-5 successDiv">
        <h2 style="color:green;text-align:center">Successfully confirmed !</h2>
        <h4 style="color:002D62;text-align:center">Booking complete—get ready to roll!</h4>
        <div class="form-section mb-4">
            <p><strong style="color:#E76F51;text-align:center">Thank you for confirming your ride with Allops!</strong></p>
            <p>Your booking details have been sent to your email. If you have any questions, our team is here for you—anytime, anywhere.</p>
            <h3 style="color:#002D62;">Wishing you a smooth and joyful journey ahead!</h3>
            <h6 style="color:#E76F51;">Drive happy, drive safe.</h6>
        </div>
             <button type="button" id="printBtn"  name="btn_reg"  value="Confirm"  class="btn btn-custom btn_confRide" style="float:right">Print Receipt</button>

    </div>






   <div class="container mt-4 border p-3 d-none" id="receiptDiv">
  <!-- Header Row -->
  <div class="row align-items-center text-center">
    <div class="col-md-4  text-start">
      <img src="img/logo.png" alt="Allops Logo" class="img-fluid" style="max-height: 60px;">
    </div>
    <div class="col-md-4 ">
      <h4 class="fw-bold mb-0">Rental Receipt</h4>
    </div>
    <div class="col-md-4  text-end">
      <img src="img/barcode.jpg" alt="Payment Barcode" class="img-fluid" style="max-height: 60px;">
    </div>
  </div>

  <!-- Row 1 -->
  <div class="row mt-2 text-center">
    <div class="col-md-3 border p-2">
      <h5>Rental Location</h5>
      <p>MEMPHIS INTL ARPT</p>
      <p>2495 WINCHESTER RD</p>
      <p>MEMPHIS, TN USA 38116</p>
      <p>(833) 898-2149</p>
    </div>
    <div class="col-md-3 border p-2">
      <p>RENTAL DATE: 10:00 AM</p>
      <p>RENTAL TIME: 6:00 PM</p>
    </div>
    <div class="col-md-3 border p-2">
      <h5>Return Location</h5>
      <p>MEMPHIS INTL ARPT</p>
      <p>2495 WINCHESTER RD</p>
      <p>MEMPHIS, TN USA 38116</p>
      <p>(833) 898-2149</p>
    </div>
    <div class="col-md-3 border p-2">
      <p>RETURN DATE: 6/6/2025</p>
      <p>RETURN TIME: 6:00 PM</p>
    </div>
  </div>

  <!-- Row 2 -->
  <div class="row mt-2 text-center">
    <div class="col-md-4 border p-2">
      <h5>Renter</h5>
      <p>OLUWASEGUN ADENIYI</p>
      <p>XXXX XXXXXXXXXX XXXX XXXXX</p>
      <p>SPRING, TX USA 77373</p>
      <p>(XXX) XXX-XXXX</p>
    </div>
    <div class="col-md-4 border p-2">
      <p>DRIVER'S LICENSE NUMBER: #ALP12345</p>
      <div class="row">
        <div class="col-6">
          <p>EXP. DATE XX/XX/XXXX</p>
        </div>
        <div class="col-6">
          <p>ISSUING STATE TX</p>
        </div>
      </div>
    </div>
    <div class="col-md-4 border p-2">
      <p>ISSUE DATE</p>
      <p>DOB XX/XX/XXXX</p>
    </div>
  </div>

  <!-- Row 3 -->
  <div class="row mt-2">
    <div class="col-12 border p-2">
      <h5>Rate Rules and Qualifications</h5>
      <p>MONTHLY CHARGE UP TO 31 DAYS</p>
    </div>
  </div>

  <!-- Row 4 -->
  <div class="row mt-2">
    <div class="col-12 border p-2">
      <h5>Local Addenda</h5>
      <p>For rentals originating in the state of Tennessee, the following will either replace or supplement the Additional Terms and Conditions:</p>
      <p>If your Vehicle was not rented under the Enterprise Truck Rental brand, the following are added to the Additional Terms and Conditions:</p>
    </div>
  </div>

  <!-- Row 5 -->
  <div class="row mt-2">
    <div class="col-12 border p-2 text-center">
      <p class="fw-bold">Thank you for choosing Allops. Have a safe journey!</p>
    </div>
  </div>
</div>


</body>
</html>

<script>
    $(document).ready(function(){
     
 $('#printBtn').on('click', function () {
    $('.successDiv').hide();
    const $receipt = $('#receiptDiv');

    // Show the hidden receipt
    $receipt.removeClass('d-none');

    // Wait for DOM to update, then print
    setTimeout(function () {
      window.print();

      // Optional: Hide again after printing
      setTimeout(function () {
        $receipt.addClass('d-none');
         $('.successDiv').show();
      }, 1000);
    }, 100);
  });
    })
</script>