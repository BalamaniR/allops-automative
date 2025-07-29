<?php 
require_once('includes/header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login to Allops Automative</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>
<body>
 
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card p-4 shadow">
                <div class="text-center mb-4">
                        <h4 class="text-warning regTitle">Trouble signing in? Need a reset?</h4>
                </div>
          
          <!-- Step 1: Request email or phone -->
          <form id="requestForm">
            <div class="mb-3">
              <label for="userContact" class="form-label">Email or Phone</label>
              <input type="text" class="form-control" id="userContact" placeholder="Enter email or phone" required>
            </div>
            <button type="submit" class="btn btn-primary btn-custom w-100">Send OTP</button>
          </form>

          <hr>

          <!-- Step 2: Enter OTP -->
          <form id="otpForm" class="mt-3" style="display: none;">
            <div class="mb-3">
              <label for="otpInput" class="form-label">Enter OTP</label>
              <input type="text" class="form-control" id="otpInput" placeholder="Enter received OTP" required>
            </div>
            <button type="submit" class="btn btn-success btn-custom w-100">Verify OTP</button>
          </form>

        </div>
      </div>
    </div>
  </div>
</body>
</html>
<?php require_once('includes/footer.php');?>
<script>
  $(document).ready(function () {
    // Handle request for OTP
    $('#requestForm').on('submit', function (e) {
      e.preventDefault();
      alert("OTP sent successfully!");
      $('#otpForm').show(); // reveal OTP section
    });

    // Handle OTP verification
    $('#otpForm').on('submit', function (e) {
      e.preventDefault();
      alert("OTP Verified. You may now reset your password.");
    });
  });
</script>