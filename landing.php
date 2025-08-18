<?php
error_reporting(0);
session_start();
require_once('includes/header.php');
if ($_REQUEST['btn_search'] == 'Search') {
    $fromLocation = htmlspecialchars(trim($_REQUEST['pickUp']));
    $toLocation   = htmlspecialchars(trim($_REQUEST['dropOff']));
        $_SESSION['location_data'] = [
          'from' =>  $fromLocation ,
          'dropOff' => $toLocation ,
          // Add other fields as needed
        ];
   # header("Location: search.php?from=" . urlencode($fromLocation) . "&to=" . urlencode($toLocation));
  #  exit(); // Always call exit after header redirect
}

?>
<head>
  <link href="css/style.css" rel="stylesheet">
  <style>
    .modal-title {
  flex: 1;
  text-align: center;
}
  </style>
</head>
<body>
      <!-- Optional content below header -->
  <div class="container mt-5 text-center">
    <h1>Step In, Gear Up, Drive On — Welcome to Allops Automotive Services.</h1>
    <p style="color:#E76F51;font-weight:bold"><i>Crafted for comfort, created for you.</i></p>
  </div>
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <form class="d-flex gap-3" method="post">
        <input type="text" name="pickUp" class="form-control" placeholder="Enter Pickup Location">
        <input type="text" name="dropOff" class="form-control" placeholder="Enter Destination">
        <button type="button" class="btn btn-warning" name="btn_search"  id="btn_search"  value="Search">Explore</button>
      </form>
    </div>
  </div>
</div>
<div class="container search-row">
    <div class="row text-center">
      <div class="col-md-4 mb-4">
        <img src="img/usa.png" alt="Economy Ride" class="feature-img">
        <div class="image-caption">Nearly 300 repeat riders — because once is never enough with Allops!</div>
      </div>
      <div class="col-md-4 mb-4">
        <img src="img/distancecovered.jpg" alt="Comfort Ride" class="feature-img" style="height:256px">
        <div class="image-caption">Tested, Trusted, Taken: Over 1,000 Secure Rides Delivered.</div>
      </div>
      <div class="col-md-4 mb-4">
        <img src="img/car.jpg" alt="Luxury Ride" class="feature-img" style="height:256px">
        <div class="image-caption">From Sedans to SUVs Vehicles Ready to Roll!</div>
      </div>
    </div>
  </div>




  <div class="modal fade" id="privacyModal" tabindex="-1" aria-labelledby="privacyModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="privacyModalLabel" style="color:#E76F51;">Privacy & Policy</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <div class="modal-body">
                  <p><strong style="color: #E76F51;">Effective Date:</strong> August 18, 2025</p>
                  <p><strong  style="color: #E76F51;">Allops Automotive - Local Addendum (Texas Rentals)</strong><br/>
          For rentals originating in the state of <strong style="color: #E76F51;">Texas</strong>, the following terms apply in addition to Allops Automotive’s standard rental agreement:<br/>
          <strong style="color: #E76F51;">Optional Protection Products Disclosure</strong><br/>
          At Allops Automotive, we offer a range of optional protection products, including <strong style="color: #E76F51;">damage waivers </strong>and <strong style="color: #E76F51;">supplemental insurance coverage.</strong><br/>
          These products are <strong style="color: #E76F51;">not required </strong> to rent a vehicle.<br/>
          <strong style="color: #E76F51;">Important Notice: </strong> you have personal auto insurance, it may already provide coverage for rental vehicles. If such coverage exists and is
          confirmed, you may request that Allops Automotive submit any applicable claims to your personal insurance provider on your behalf.
          We encourage you to review your personal insurance policy or consult your insurance provider before purchasing any optional coverage.<br/>
          <strong style="color: #E76F51;">Damage Waiver Limitations</strong><br/>
          The<strong style="color: #E76F51;"> damage waiver</strong> does not cover:
          <ul>
          <li>Improper fueling</li>
          <li> Overhead damage to the vehicle</li>
          <li> Damage resulting from prohibited uses as outlined in the rental agreement.</li>
          </ul>
          Please refer to the full rental terms for a complete description of coverage, exclusions, and limitations.<br/>
          <strong style="color: #E76F51;">Child Safety Seats</strong><br/>
          Child safety seats that meet federal motor vehicle safety standards are available upon request for an additional fee. Availability may vary by
          location. Please request in advance to ensure availability.</p>
                  <!-- Add more sections as needed -->
      </div>

      <div class="modal-footer">
        <button id="acceptPrivacy" type="button" class="btn btn-success">
           Yes, I have read and accept the Privacy & Policy
        </button>
      </div>
    </div>
  </div>
</div>



<!-- Terms & Conditions Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="termsModalLabel" style="color:#E76F51;">Terms & Conditions</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form id="termsForm">
          <p><strong style="color: #E76F51;">Terms and Conditions (Check Each Box to Acknowledge and Accept)</strong></p>
          <div class="form-check mb-2">
            <input class="form-check-input term-check" type="checkbox" id="term1">
            <label class="form-check-label" for="term1">1. No Insurance Provided: Allops does NOT provide insurance. The renter is solely responsible for securing appropriate
coverage if desired.</label>
          </div>
          <div class="form-check mb-2">
            <input class="form-check-input term-check" type="checkbox" id="term2">
            <label class="form-check-label" for="term2">2. Vehicle Maintenance: Renter agrees to maintain the vehicle in a good and operable condition during the rental period,
including avoiding misuse or neglect.</label>
          </div>
          <div class="form-check mb-2">
            <input class="form-check-input term-check" type="checkbox" id="term3">
            <label class="form-check-label" for="term3">3. Accident Disclaimer: Allops is not liable for any accidents, injuries, losses, or damages during the rental period, regardless
of fault.</label>
          </div>
          <div class="form-check mb-2">
            <input class="form-check-input term-check" type="checkbox" id="term4">
            <label class="form-check-label" for="term4">4. Full Responsibility for Accidents: In the event of any accident, theft, or damage, the renter accepts full financial and legal
responsibility, including any third-party claims.</label>
          </div>
          <div class="form-check mb-2">
            <input class="form-check-input term-check" type="checkbox" id="term5">
            <label class="form-check-label" for="term5">5. Return Location: Vehicle must be returned to the original pick-up location unless otherwise agreed in writing.</label>
          </div>
          <div class="form-check mb-2">
            <input class="form-check-input term-check" type="checkbox" id="term6">
            <label class="form-check-label" for="term6">6. Condition on Return: Renter agrees to return the vehicle in the same condition (mechanical and cosmetic) as received,
allowing for normal wear and tear.</label>
          </div>
          <div class="form-check mb-2">
            <input class="form-check-input term-check" type="checkbox" id="term7">
            <label class="form-check-label" for="term7">7. Fuel and Cleanliness: Vehicle must be returned with the same fuel level and in a reasonably clean condition, or fees may
apply.</label>
          </div>
          <div class="form-check mb-3">
            <input class="form-check-input term-check" type="checkbox" id="term8">
            <label class="form-check-label" for="term8">8. Late Return Fees: Late returns beyond the agreed time may incur additional hourly or daily charges at Allops’ discretion.</label>
          </div>
           <div class="form-check mb-3">
            <input class="form-check-input term-check" type="checkbox" id="term8">
            <label class="form-check-label" for="term8">☐ 9. Unauthorized Use: Use of the vehicle for illegal purposes, racing, towing, or subleasing is strictly prohibited and may result
in immediate termination of the agreement.</label>
          </div>

          <!-- Accept All Checkbox -->
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="acceptAll">
            <label class="form-check-label fw-bold text-success" for="acceptAll">I Accept All Terms & Conditions</label>
          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button id="confirmTerms" type="button" class="btn btn-success" disabled>
          Proceed to Explore
        </button>
      </div>
    </div>
  </div>
</div>

  <!-- Bootstrap Icons CDN for the search icon -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.js"></script>
</body>
<?php
require_once('includes/footer.php');
?>
<script>
$(document).ready(function () {
  // Show Privacy modal
  $('#btn_search').on('click', function () {
    $('#privacyModal').modal('show');
  });

  // After accepting Privacy, show Terms modal
  $('#acceptPrivacy').on('click', function () {
    $('#privacyModal').modal('hide');

    setTimeout(function () {
      $('#termsModal').modal('show');
    }, 500); // slight delay for smooth transition
  });

  $('#acceptAll').on('change', function () {
    const isChecked = $(this).is(':checked');

    // Check all checkboxes on the page
    $('input[type="checkbox"]').prop('checked', isChecked);

    // Optional: Enable the confirm button only if all modal terms are checked
    toggleConfirmButton();
  });

  // Sync "Accept All" if user manually checks all modal terms
  $('.term-check').on('change', function () {
    const allChecked = $('.term-check:checked').length === $('.term-check').length;
    $('#acceptAll').prop('checked', allChecked);
    toggleConfirmButton();
  });

  function toggleConfirmButton() {
    const allChecked = $('.term-check:checked').length === $('.term-check').length;
    $('#confirmTerms').prop('disabled', !allChecked);
  }

  // Confirm button action
  $('#confirmTerms').on('click', function () {
    alert('All terms accepted. Proceeding to explore...');
    window.location.href = 'search.php';
  });
});


</script>
