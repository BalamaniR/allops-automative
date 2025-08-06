<?php
error_reporting(0);

require_once('includes/header.php');

?>

<head>
  <meta charset="UTF-8">
  <title>Journey Planner - Allops Automative Services</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>
<body>

  <div class="container mt-5">
    <!--  Form Section -->
    <div class="form-section mb-4">
      <h3 class="mb-4 text-center">Your Trip, Our Wheels </h3>
     <form>
  <!--  From & To Locations on Same Line -->
  <div class="row mb-3">
    <div class="col-md-6 d-flex align-items-center">
      <label for="fromLocation" class="form-label me-2">
        <i class="bi bi-geo-alt fs-3" style="color: #E76F51;"></i> From
      </label>
      <input type="text" class="form-control" id="fromLocation" placeholder="Enter pickup location" value="<?php echo $_REQUEST['from']; ?>">
    </div>
    <div class="col-md-6 d-flex align-items-center">
      <label for="toLocation" class="form-label me-2">
        <i class="bi bi-geo-alt-fill fs-3" style="color: #E76F51;"></i> To
      </label>
      <input type="text" class="form-control" id="toLocation" placeholder="Enter drop-off location" value="<?php echo $_REQUEST['to']; ?>">
    </div>
  </div>

  <!--  Journey Type & Options Inline -->
  <div class="row mb-3 align-items-center">
    <div class="col-auto">
      <label class="form-label mb-0"><i class="bi bi-arrows-collapse fs-3" style="color: #E76F51;"></i> Journey Type</label>
    </div>
    <div class="col-auto">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="journeyType" id="oneWay" value="One Way" checked>
        <label class="form-check-label" for="oneWay">One Way</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="journeyType" id="roundTrip" value="Round Trip">
        <label class="form-check-label" for="roundTrip">Round Trip</label>
      </div>
    </div>
  </div>

  <!--  Departure Date Inline -->
  <div class="row mb-3 align-items-center">
    <div class="col-auto">
      <label for="departureDate" class="form-label mb-0"><i class="bi bi-calendar-date fs-3" style="color: #E76F51;"></i> Kickoff Date</label>
    </div>
    <div class="col-auto">
      <input type="date" class="form-control" id="departureDate">
    </div>
  </div>
<!--  Departure Time Inline -->
<div class="row mb-3 align-items-center">
  <div class="col-auto">
    <label for="departureTime" class="form-label mb-0">
      <i class="bi bi-clock fs-3" style="color: #E76F51;"></i> Kickoff Time
    </label>
  </div>
  <div class="col-auto">
    <input type="time" class="form-control" id="departureTime">
  </div>
</div>
  <button type="submit" class="btn btn-primary btn_search">Discover Rides </button>
</form>

    </div>

    <!--  Car List Section -->
    
<div class="row res_available">
<h4 class="mb-3">Available Fleet</h4>
      <!-- Car Card 1 -->
      <div class="col-md-4 mb-4">
        <div class="card car-card">
          <img src="img/sedanStandard.jpg" alt="Sedan Car"  style="height: 275px;">
          <div class="card-body">
            <h5 class="card-title"><i>Standard Sedan</i></h5>    
               <p class="card-text">
                    <span class="me-3">
                      <i class="bi bi-battery-charging fw-bold text-success" title="Electric"></i> Electric
                    </span>
                    <span class="feature me-3">
                      <i class="bi bi-fuel-pump fw-bold text-warning" title="Fuel"></i> Fuel
                    </span>         
              </p> 
            <p class="card-text"><label> <i class="bi bi-person text-info"></i> &nbsp;&nbsp;Seaters : &nbsp;&nbsp; </label>Up to 4 passengers.</p>
            <p class="card-text">
                    <span class="feature me-3">
                      <i class="bi bi-wind fw-bold text-info" title="A/C"></i> A/C
                    </span>
                    <span class="feature me-3">
                      <i class="bi bi-geo-alt-fill fw-bold text-primary" title="GPS"></i> GPS
                    </span>
                    <span class="feature">
                      <i class="bi bi-car-front-fill fw-bold text-success" title="Smooth Ride"></i> Smooth Ride
                    </span>
              </p> 
              <p class="card-text">
                <span class="me-3">
                   <i class="bi bi-cpu-fill fw-bold text-primary" title="Automatic"></i> Automatic
                </span>
                <span>
                    <i class="bi bi-gear-fill fw-bold text-warning" title="Manual"></i> Manual
                </span>
              </p>           
              <p class="card-text">
                <span class="price-label">
                <i class="bi bi-cash-stack fw-bold text-success" title="Cost per KM"></i>
                &nbsp;$5/km
                </span>
              </p> 
              
              <a href="login.php" class="btn btn-outline-primary w-100 btn_book">Book Now</a>
          </div>
        </div>
      </div>

      <!-- Car Card 2 -->
      <div class="col-md-4 mb-4">
        <div class="card car-card">
          <img src="img/suv.jpg" alt="SUV Car">
          <div class="card-body">
            <h5 class="card-title"><i>Premium SUV</i></h5>
              <p class="card-text">
                        <span class="me-3">
                          <i class="bi bi-battery-charging fw-bold text-success" title="Electric"></i> Electric
                        </span>
                        <span class="feature me-3">
                          <i class="bi bi-fuel-pump fw-bold text-warning" title="Fuel"></i> Fuel
                        </span>         
                  </p>   
            <p class="card-text"><label> <i class="bi bi-person text-info"></i> &nbsp;&nbsp;Seaters :  &nbsp;&nbsp;</label>Up to 4 passengers.</p>
            <p class="card-text">
                    <span class="feature me-3">
                      <i class="bi bi-wind fw-bold text-info" title="A/C"></i> A/C
                    </span>
                    <span class="feature me-3">
                      <i class="bi bi-geo-alt-fill fw-bold text-primary" title="GPS"></i> GPS
                    </span>
                    <span class="feature">
                      <i class="bi bi-car-front-fill fw-bold text-success" title="Smooth Ride"></i> Smooth Ride
                    </span>
              </p>          
              <p class="card-text">
                <span class="me-3">
                   <i class="bi bi-cpu-fill fw-bold text-primary" title="Automatic"></i> Automatic
                </span>
                <span>
                    <i class="bi bi-gear-fill fw-bold text-warning" title="Manual"></i> Manual
                </span>
              </p> 
              <p class="card-text">
                <span class="price-label">
                <i class="bi bi-cash-stack fw-bold text-success" title="Cost per KM"></i>
                &nbsp;$5/km
                </span>
              </p> 
              
              <a href="login.php" class="btn btn-outline-primary w-100 btn_book">Book Now</a>
          </div>
        </div>
      </div>

      <!-- Car Card 3 -->
      <div class="col-md-4 mb-4">
        <div class="card car-card">
          <img src="img/sedanLux.jpg" alt="Luxury Car" style="height: 275px;">
          <div class="card-body">
            <h5 class="card-title"><i>Luxury Sedan</i></h5>
               <p class="card-text">
                    <span class="me-3">
                      <i class="bi bi-battery-charging fw-bold text-success" title="Electric"></i> Electric
                    </span>
                    <span class="feature me-3">
                      <i class="bi bi-fuel-pump fw-bold text-warning" title="Fuel"></i> Fuel
                    </span>         
              </p> 
              <p class="card-text"><label>    <i class="bi bi-person text-info"></i> &nbsp;&nbsp; Seaters :  &nbsp;&nbsp;</label>Up to 4 passengers.</p>
              <p class="card-text">
                    <span class="feature me-3">
                      <i class="bi bi-wind fw-bold text-info" title="A/C"></i> A/C
                    </span>
                    <span class="feature me-3">
                      <i class="bi bi-geo-alt-fill fw-bold text-primary" title="GPS"></i> GPS
                    </span>
                    <span class="feature">
                      <i class="bi bi-car-front-fill fw-bold text-success" title="Smooth Ride"></i> Smooth Ride
                    </span>
              </p>
              <p class="card-text">
                <span class="me-3">
                   <i class="bi bi-cpu-fill fw-bold text-primary" title="Automatic"></i> Automatic
                </span>
                <span>
                    <i class="bi bi-gear-fill fw-bold text-warning" title="Manual"></i> Manual
                </span>
              </p> 
              <p class="card-text">
                <span class="price-label">
                <i class="bi bi-cash-stack fw-bold text-success" title="Cost per KM"></i>
                &nbsp;$5/km
                </span>
              </p>          
              
              <a href="login.php" class="btn btn-outline-primary w-100 btn_book">Book Now</a>
          </div>
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
  $(".res_available").hide();
 $(".btn_search").click(function(e){
  e.preventDefault(); // Stops the page from reloading
  $(".res_available").show();
});
});
</script>