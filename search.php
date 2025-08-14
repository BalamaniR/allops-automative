<?php
error_reporting(0);
#ini_set('display_errors', 1);
require_once('includes/header.php');
require_once('classes/functions.php');



if (isset($_SESSION['location_data'])) {
    $pickup = $_SESSION['location_data']['from'];
    $destination = $_SESSION['location_data']['dropOff'];
}
$carList = $obj->get_car_comapnyList();

if (isset($_REQUEST['btn_search'])) {
    $carCompany  = $_REQUEST['carCompany'] ?? '';
    $carName     = $_REQUEST['carName'] ?? '';
    $fuel        = $_REQUEST['carfuel'] ?? '';
    $seat        = $_REQUEST['carseat'] ?? 'any';

    $cars = $obj->get_car_details($carCompany, $carName, $fuel, $seat);


}
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
      <form method="POST" action="">
        <!--  From & To Locations on Same Line -->
        <div class="row mb-3">
          <div class="col-md-6 d-flex align-items-center">
            <label for="fromLocation" class="form-label me-2">
              <i class="bi bi-geo-alt fs-3" style="color: #E76F51;"></i> From
            </label>
            <input type="text" class="form-control" name="pickup" id="fromLocation" placeholder="Enter pickup location" value="<?php echo $pickup ?>">
          </div>
          <div class="col-md-6 d-flex align-items-center">
            <label for="toLocation" class="form-label me-2">
              <i class="bi bi-geo-alt-fill fs-3" style="color: #E76F51;"></i> To
            </label>
            <input type="text" class="form-control" name="destination" id="toLocation" placeholder="Enter drop-off location" value="<?php echo  $destination ?>">
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

        <div class="row mb-3">
          <div class="col-md-3 d-flex align-items-center">
          <i class="bi bi-car-front-fill fs-3" style="color: #E76F51;padding-right: 5px;"></i>
              <select class="form-select" name="carCompany" id="carCompany">
              <option selected disabled>Select a preferred Car</option>
              <?php foreach ($carList as $car): ?>
                  <option value="<?= htmlspecialchars($car['car_id']) ?>">
                  <?= htmlspecialchars($car['car_company_name']) ?>
                  </option>
              <?php endforeach; ?>
              </select>
          </div>
          <div class="col-md-3 d-flex align-items-center">
          <i class="bi bi-car-front-fill fs-3" style="color: #E76F51;padding-right: 5px;"></i>
                <select class="form-select"  name="carName"  id="carName">
                  <option selected disabled>Select preferred Car Type</option>
                </select>
          </div>
          <div class="col-md-3 d-flex align-items-center">
              <i class="bi bi-fuel-pump fs-3" style="color: #E76F51;padding-right: 5px;"></i>
              <select class="form-select"   name="carfuel"  id="carfuel">
                <option selected disabled>Select a Fuel Type</option>
                <option value="gasoline">Gasoline</option>
                <option value="electric">Electric</option>
                <option value="hybrid">Hybrid</option>
              </select>
          </div>
          <div class="col-md-3 d-flex align-items-center">
          <i class="bi bi-person-fill fs-3" style="color: #E76F51;padding-right: 5px;"></i>
              <select class="form-select"  name="carseat" id="carseat">
                <option selected disabled>Select a seat Type</option>
                <option value="child">Child seat Mandatory</option>
                <option value="any">Any seat type</option>
              </select>
          </div>
        </div>
<button type="submit" name="btn_search" class="btn btn-primary btn_search">Discover Rides</button>
      </form>
    </div>

    <!--  Car List Section -->
    
<div class="row res_available">
<h4 class="mb-3">Available Fleet</h4>
<?php if (!empty($cars)) { foreach($cars as $car){
  
  $carId = $car['car_id'];
  $cname = $obj->get_car_name($carId);
  
  ?>
    <div class="col-md-4 mb-4">
        <div class="card car-card">
          <img src="<?php echo $car['car_img_path']?>" alt="Sedan Car"  style="height: 275px;">
          <div class="card-body">
            <h5 class="card-title" style="text-align:center;color:#E76F51;font-weight:bold"><i><?php echo $cname['car_company_name']?></i></h5>    
            <h6 class="card-title" style="text-align:center;color:#002D62;font-weight:bold;margin-bottom: 30px;margin-top: 20px;"><i><?php echo $car['car_type']?></i></h6>  
               <div class="card-text">
                      <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-battery-charging text-success me-2" title="Electric"></i>
                        <i class="bi bi-fuel-pump text-warning me-2" title="Fuel"></i>
                        <strong class="me-2">Fuel Type:</strong>
                        <span style="color:#E76F51;"><em><?php echo $car['fuel_type']; ?></em></span>
                      </div>

                      <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-gear-fill text-primary me-2" title="Transmission"></i>
                        <strong class="me-2">Transmission:</strong>
                        <span style="color:#E76F51;"><em><?php echo $car['transmission']; ?></em></span>
                      </div>

                      <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-crosshair  text-info me-2" title="GPS"></i>
                        <strong class="me-2">GPS:</strong>
                        <span style="color:#E76F51;"><em><?php echo (strtolower($car['gps']) === 'y') ? 'Yes' : 'No'; ?></em></span>
                      </div>
                      <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-wind  text-info me-2" title="AC"></i>
                        <strong class="me-2"> A/C :</strong>
                        <span style="color:#E76F51;"><em><?php echo (strtolower($car['air_conditioned']) === 'y') ? 'Yes' : 'No'; ?></em></span>
                      </div>
                      <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-car-front-fill  text-info me-2" title="AC"></i>
                        <strong class="me-2"> Road Assistance :</strong>
                        <span style="color:#E76F51;"><em><?php echo (strtolower($car['road_assistance']) === 'y') ? 'Yes' : 'No'; ?></em></span>
                      </div>
                      <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-bluetooth  text-info me-2" title="AC"></i>
                        <strong class="me-2"> Bluetooth :</strong>
                        <span style="color:#E76F51;"><em><?php echo (strtolower($car['bluetooth']) === 'y') ? 'Yes' : 'No'; ?></em></span>
                      </div>
                      <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-wifi  text-info me-2" title="AC"></i>
                        <strong class="me-2">Wi-Fi Hotspot :</strong>
                        <span style="color:#E76F51;"><em><?php echo (strtolower($car['wifi_hotspot']) === 'y') ? 'Yes' : 'No'; ?></em></span>
                      </div>
                      <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-wifi  text-info me-2" title="AC"></i>
                        <strong class="me-2">Wi-Fi Hotspot :</strong>
                        <span style="color:#E76F51;"><em><?php echo (strtolower($car['wifi_hotspot']) === 'y') ? 'Yes' : 'No'; ?></em></span>
                      </div>

                       <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-person-bounding-box  text-info me-2" title="AC"></i>
                        <strong class="me-2">Special Seat For Kid :</strong>
                        <span style="color:#E76F51;"><em><?php echo (strtolower($car['child_seat']) === 'y') ? 'Yes' : 'No'; ?></em></span>
                      </div>
                      <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-broadcast text-info me-2" title="AC"></i>
                        <strong class="me-2">Sirius XM:</strong>
                        <span style="color:#E76F51;"><em><?php echo (strtolower($car['sirius_xm']) === 'y') ? 'Yes' : 'No'; ?></em></span>
                      </div>
                       <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-person-walking text-info me-2" title="AC"></i>
                        <strong class="me-2">Pick up Choice:</strong>
                        <span style="color:#E76F51;"><em><?php echo (strtolower($car['pick_up_choice']) === 'y') ? 'Yes' : 'No'; ?></em></span>
                      </div>
                      <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-terminal text-info me-2" title="AC"></i>
                        <strong class="me-2">Self-Serve kiosk:</strong>
                        <span style="color:#E76F51;"><em><?php echo (strtolower($car['self-serve kiosk']) === 'y') ? 'Yes' : 'No'; ?></em></span>
                      </div>

                  </div>
          </div>
        </div>
    </div>
    <?php }} else {
    echo "No cars found or error in query.";
}?>
</div>
      <!-- Car Card 1 -->
   <!--   <div class="col-md-4 mb-4">
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
                &nbsp;$40 / Day
                </span>
              </p> 
              <a href="#" class="btn btn-outline-primary w-100 btn_book">Book Now</a>
          </div>
        </div>
      </div>-->

      <!-- Car Card 2 -->
     <!-- <div class="col-md-4 mb-4">
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
                  &nbsp;$30 / Day
                  </span>
                </p> 
              
              <a href="#" class="btn btn-outline-primary w-100 btn_book">Book Now</a>
          </div>
        </div>
      </div>-->

      <!-- Car Card 3 -->
     <!-- <div class="col-md-4 mb-4">
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
                &nbsp;$35 / Day
                </span>
              </p>          
              
              <a href="#" class="btn btn-outline-primary w-100 btn_book ">Book Now</a>
          </div>
        </div>
      </div>

    </div>
  </div>-->

</body>


<?php
require_once('includes/footer.php');
?>
<script>
$(document).ready(function(){
/*$(".res_available").hide();
    $(".btn_search").click(function(e){
      e.preventDefault(); // Stops the page from reloading
      $(".res_available").show();
    });*/
  $('#carCompany').on('change', function () {
    let carid = $(this).val();
    if (carid) {
      $.ajax({
        url: 'get_carDetails.php',
        type: 'POST',
        data: { cid: carid },
        dataType: 'json',
        success: function (data) {
          //  let res = JSON.parse(data);
            console.log(data);
       
                let options = '<option value="">Select Car Type</option>';
                     if(carid == 0){
                     // let cars = [];
                      // Push key-value pairs as objects
                              data.push({ car_id: 0, car_type: 'Any' });
                              data.push({ car_id: 1, car_type: 'Economy' });
                              data.push({ car_id: 2, car_type: 'Standard' });
                              data.push({ car_id: 3, car_type: 'SUV' });
                              data.push({ car_id: 4, car_type: 'Luxury' });
                              data.push({ car_id: 5, car_type: 'Minivan' });
                              data.push({ car_id: 6, car_type: 'Compact' });
                              data.push({ car_id: 7, car_type: 'Full-size' });
                              data.push({ car_id: 8, car_type: 'Premium' });
                              data.push({ car_id: 9, car_type: 'Convertible' });
                              data.push({ car_id: 10, car_type: 'EVs' });
                              data.push({ car_id: 11, car_type: 'Hybrid' });
                              data.push({ car_id: 12, car_type: 'Premium Sedans' });
                              data.push({ car_id: 13, car_type: 'Sports Cars' });
                      }else{
                        data = data;
                      }
                    $.each(data, function (index, car) {
                      console.log(car.car_id);
                      options += `<option value="${car.car_type}">${car.car_type}</option>`;
                    });
                    $('#carName').html(options);
        }
          
      });
    }
    })

    


 
});
</script>