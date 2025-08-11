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
    header("Location: search.php?from=" . urlencode($fromLocation) . "&to=" . urlencode($toLocation));
    exit(); // Always call exit after header redirect
}

?>
<head>
  <link href="css/style.css" rel="stylesheet">
</head>
<body>
      <!-- Optional content below header -->
  <div class="container mt-5 text-center">
    <h1>Step In, Gear Up, Drive On — Welcome to Allops Automative Services.</h1>
    <p style="color:#E76F51;font-weight:bold"><i>Crafted for comfort, created for you.</i></p>
  </div>
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <form class="d-flex gap-3" method="post">
        <input type="text" name="pickUp" class="form-control" placeholder="Enter Pickup Location">
        <input type="text" name="dropOff" class="form-control" placeholder="Enter Destination">
        <button type="submit" class="btn btn-warning" name="btn_search" value="Search">Explore</button>
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

  <!-- Bootstrap Icons CDN for the search icon -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.js"></script>
</body>
<?php
require_once('includes/footer.php');
?>
