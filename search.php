<?php
error_reporting(0);
#ini_set('display_errors', 1);
require_once('includes/header.php');
require_once('classes/functions.php');
if (isset($_SESSION['location_data'])) {
    $pickup = $_SESSION['location_data']['from'];
    $destination = $_SESSION['location_data']['dropOff'];
}
$uid         = $_SESSION['user_id'];
$customer_id = $_SESSION['customer_id'];

if($_SESSION['user_id'] != ''){
  $bookurl = 'getMyride.php';
}else{
  $bookurl = 'login.php';
}
$msg = '';
$class = '';
$showResults = false;
$carList = $obj->get_car_comapnyList();
if (isset($_REQUEST['btn_search'])) {
    $from = $_REQUEST['pickup'];
    $pickup = $_SESSION['location_data'][$from];
    $to = $_REQUEST['destination'];
    $destination = $_SESSION['location_data'][$to];
    $journeyType = $_POST['journeyType'] ?? '';
    $departDate = $_REQUEST['departureDate'];
  echo "---".  $departTime = $_REQUEST['departureTime'];
    $carCompany  = $_REQUEST['carCompany'] ?? '';
    $carName     = $_REQUEST['carName'] ?? '';
    $fuel        = $_REQUEST['carfuel'] ?? '';
    $seat        = $_REQUEST['carseat'] ?? 'any';

         $errors = [
          'from' => 'Journey start Location cannot be empty',
          'to' => 'Journey Destination Location cannot be empty',
          'journeyType' => 'Journey type cannot be empty',
          'departDate' =>'Departure date cannot be empty',
          'departTime' =>'Departure time cannot be empty',
         
      ];

      foreach ($errors as $field => $message) {
          if (empty($$field)) {
              $msg = $message;
              $class = 'error';
              break;
          }
      }

      if($_SESSION['user_id'] != ''){
          $status= 'Booked';
          $booked_date = date("Y-m-d");
          $journyDetails = $obj->add_user_journeyData($uid,$customer_id,$from,$to,$journeyType,$departDate,$departTime, $status, $booked_date);
          $bookurl = 'getMyride.php';
      }else{
           $bookurl = 'login.php';
      }
    
      if (empty($msg)) {
        $showResults = true;
      }
    $cars = $obj->get_car_details($carCompany, $carName, $fuel, $seat);
    $carCount = count($cars);
    
}
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
    .error{
      color:red;
      text-align: center;
      margin-bottom: 20px;
      font-weight: bold;
    }
   .required-label::after {
      content: " *";
      color: red;
    }
  </style>
</head>
<body>
 
  <div class="container mt-5">

  <div class="<?php echo $class;?>"><?php echo $msg;?></div>

    <!--  Form Section -->
    <div class="form-section mb-4">
      <h3 class="mb-4 text-center">Your Trip, Our Wheels </h3>
      <form method="POST" action="">
        <!--  From & To Locations on Same Line -->
        <div class="row mb-3">
          <div class="col-md-6 d-flex align-items-center">
            <label for="fromLocation" class="form-label me-2 required-label">
              <i class="bi bi-geo-alt fs-3" style="color: #E76F51;"></i> From
            </label>
            <input type="text" class="form-control" name="pickup" id="fromLocation" placeholder="Enter pickup location" value="<?php if($pickup ==''){ echo $_REQUEST['pickup'];}else{echo $pickup;} ?>">
          </div>
          <div class="col-md-6 d-flex align-items-center">
            <label for="toLocation" class="form-label me-2 required-label">
              <i class="bi bi-geo-alt-fill fs-3" style="color: #E76F51;"></i> To
            </label>
            <input type="text" class="form-control" name="destination" id="toLocation" placeholder="Enter drop-off location" value="<?php if($destination ==''){ echo $_REQUEST['destination'];}else{echo $destination;} ?>">
          </div>
        </div>
    
       <div class="row mb-4 mt-5">
          <div class="col-md-4 d-flex align-items-center">
            <label class="me-2 mb-0 required-label">
              <i class="bi bi-arrows-collapse fs-3" style="color: #E76F51;"></i> Journey Type
            </label>
            <div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="journeyType" id="oneWay" value="One Way"
                  <?= (isset($_POST['journeyType']) && $_POST['journeyType'] === 'One Way') ? 'checked' : '' ?>>
                <label class="form-check-label" for="oneWay">One Way</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="journeyType" id="roundTrip" value="Round Trip"
                  <?= (isset($_POST['journeyType']) && $_POST['journeyType'] === 'Round Trip') ? 'checked' : '' ?>>
                <label class="form-check-label" for="roundTrip">Round Trip</label>
              </div>
            </div>
          </div>
          <div class="col-md-4 d-flex align-items-center">
            <label for="departureDate" class="me-2 mb-0 required-label ">
              <i class="bi bi-calendar-date fs-3" style="color: #E76F51;"></i> Kickoff Date
            </label>
            <input type="date" name="departureDate" class="form-control"
              id="departureDate"
              value="<?= isset($_POST['departureDate']) ? htmlspecialchars($_POST['departureDate']) : '' ?>">
          </div>
          <div class="col-md-4 d-flex align-items-center">
            <label for="departureTime" class="me-2 mb-0 required-label">
              <i class="bi bi-clock fs-3" style="color: #E76F51;"></i> Kickoff Time
            </label>
            <input type="time" name="departureTime" class="form-control"
              id="departureTime"
              value="<?= isset($_POST['departureTime']) ? htmlspecialchars($_POST['departureTime']) : '' ?>">
          </div>
        </div>

        <div class="row mb-4 mt-5">
          <div class="col-md-3 d-flex align-items-center">
          <i class="bi bi-car-front-fill fs-3" style="color: #E76F51;padding-right: 5px;"></i>
           <select class="form-select" name="carCompany" id="carCompany">
              <option disabled <?= empty($_POST['carCompany']) ? 'selected' : '' ?>>Select a preferred Car</option>
              <?php foreach ($carList as $car): 
                $selected = (isset($_POST['carCompany']) && $_POST['carCompany'] == $car['car_id']) ? 'selected' : '';
              ?>
                <option value="<?= htmlspecialchars($car['car_id']) ?>" <?= $selected ?>>
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
            <select class="form-select" name="carfuel" id="carfuel">
            <option disabled <?= !isset($_POST['carfuel']) ? 'selected' : '' ?>>Select a Fuel Type</option>
            <option value="gasoline" <?= (isset($_POST['carfuel']) && $_POST['carfuel'] === 'gasoline') ? 'selected' : '' ?>>Gasoline</option>
            <option value="electric" <?= (isset($_POST['carfuel']) && $_POST['carfuel'] === 'electric') ? 'selected' : '' ?>>Electric</option>
            <option value="hybrid" <?= (isset($_POST['carfuel']) && $_POST['carfuel'] === 'hybrid') ? 'selected' : '' ?>>Hybrid</option>
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
        <button type="submit" name="btn_search" class="btn btn-primary btn_search ">Discover Rides</button>
      </form>
    </div>

    <!--  Car List Section -->
<?php if ($showResults): ?>    
<div class="row res_available">
 
<h4 class="mb-3" style="color:#002D62">Available Fleet&nbsp;- <span style="color:#E76F51;font-weight:bold"><?php echo $carCount ?></span></h4>
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

                      <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-currency-dollar  text-info me-2" title="AC"></i>
                        <strong class="me-2">Cost Per Day :</strong>
                        <span style="color:#E76F51;"><em><?php echo (strtolower($car['cost_per_day']) === 'y') ? 'Yes' : 'No'; ?></em></span>
                      </div>

                  </div>
          </div>
          <button type="submit" name="btn_book" class="btn btn-primary btn_book">Book Rides</button>

        </div>
    </div>
   
    <?php }} else {
    echo "No cars found or error in query.";
}?>
</div>
<?php endif; ?>
  </div>
</body>


<?php
require_once('includes/footer.php');
?>
<script>
$(document).ready(function(){

$('.btn_book').click(function(){

const pickup = $('#fromLocation').val();
const dropoff = $('#toLocation').val();
const journeyType = $('input[name="journeyType"]:checked').val();
const carBrand = '<?php echo  $carCompany ?>';
const carType = '<?php echo $carName ?>';
const fuelType = $('#carfuel').val();
const startDate = $('#departureDate').val();
const startTime = $('#departureTime').val();


   const url = `search.php?pickup=${encodeURIComponent(pickup)}&dropoff=${encodeURIComponent(dropoff)}&carbrand=${encodeURIComponent(carBrand)}&carType=${encodeURIComponent(carType)}&journey=${encodeURIComponent(journeyType)}&startDate=${encodeURIComponent(startDate)}&startTime=${encodeURIComponent(startTime)}&fuelType=${encodeURIComponent(fuelType)}`;
window.location.href = '<?= $bookurl ?>' + 
  '?pickup=' + encodeURIComponent(pickup) +
  '&dropoff=' + encodeURIComponent(dropoff) +
  '&carbrand=' + encodeURIComponent(carBrand) +
  '&carType=' + encodeURIComponent(carType) +
  '&journey=' + encodeURIComponent(journeyType) +
  '&startDate=' + encodeURIComponent(startDate) +
  '&startTime=' + encodeURIComponent(startTime) +
  '&fuelType=' + encodeURIComponent(fuelType);
})


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
                    $.each(data, function (index, car) {
                      console.log(car.car_id);
                      options += `<option value="${car.car_type}">${car.car_type}</option>`;
                    });
                    $('#carName').html(options);
        }
          
      });
    }

  $('#carCompany').on('change', function () {
     const selected = $(this).val();
    localStorage.setItem('carType', selected);
  });


    })

    


 
});
</script>