<?php 
require_once('includes/header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Allops Rental Service</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
  <style>
 
    .form-section {
      max-width: 500px;
      margin: auto;
      padding: 30px;
    }
   
  </style>
</head>
<body>

  <div class="text-center mb-4">
    <h4 class="text-warning regTitle">Sign Up to Start Cruising</h4>
  </div>

  <div class="form-section">
  <form>
    <div class="row mb-3">
      <label for="name" class="col-sm-4 col-form-label">Name</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" id="name" name="name">
      </div>
    </div>

    <div class="row mb-3">
      <label for="phone" class="col-sm-4 col-form-label">Phone</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" id="phone" name="phone">
      </div>
    </div>

    <div class="row mb-3">
      <label for="email" class="col-sm-4 col-form-label">Email</label>
      <div class="col-sm-8">
        <input type="email" class="form-control" id="email" name="email">
      </div>
    </div>

    <div class="row mb-3">
      <label for="address" class="col-sm-4 col-form-label">Address</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" id="address" name="address">
      </div>
    </div>

    <div class="row mb-3">
      <label for="license" class="col-sm-4 col-form-label">Driver’s License Number</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" id="license" name="license">
      </div>
    </div>

    <div class="row mb-3">
      <label for="issue" class="col-sm-4 col-form-label">License Issue Date</label>
      <div class="col-sm-8">
        <input type="date" class="form-control" id="issue" name="issue">
      </div>
    </div>

    <div class="row mb-3">
      <label for="expiry" class="col-sm-4 col-form-label">License Exp. Date</label>
      <div class="col-sm-8">
        <input type="date" class="form-control" id="expiry" name="expiry">
      </div>
    </div>

    <div class="row mb-3">
      <label for="dob" class="col-sm-4 col-form-label">DOB</label>
      <div class="col-sm-8">
        <input type="date" class="form-control" id="dob" name="dob">
      </div>
    </div>

    <button type="submit" class="btn btn-custom w-100">Sign Up</button>
  </form>
</div>

</body>
</html>
<?php require_once('includes/footer.php');?>