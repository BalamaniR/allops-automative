<?php 
require_once('includes/header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Profile - Allops Automative Services</title>
   <link href="css/style.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    .profile-card {
      max-width: 600px;
      margin: auto;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>

<div class="container mt-5">
  <h4 style="color: #E76F51!important;font-weight:bold"><i class="bi bi-person-circle me-2"></i> Edit Profile</h4>
  <form class="row g-3">
    <!-- Name (non-editable) -->
    <div class="col-md-6">
      <label class="form-label d-flex align-items-center">
        <i class="bi bi-person-fill me-1"></i> <span>Name</span>
      </label>
      <input type="text" class="form-control" value="Jessica" disabled>
    </div>

    <!-- Email (non-editable) -->
    <div class="col-md-6">
      <label class="form-label d-flex align-items-center">
        <i class="bi bi-envelope-fill me-1"></i> <span>Email</span>
      </label>
      <input type="email" class="form-control" value="Jessica@gmail.com" disabled>
    </div>

    <!-- Mobile Number (editable) -->
    <div class="col-md-6">
      <label class="form-label d-flex align-items-center">
        <i class="bi bi-telephone-fill me-1"></i> <span>Mobile</span>
      </label>
      <input type="tel" class="form-control" value="+1(987)654-3210">
    </div>

    <!-- Address (editable) -->
    <div class="col-md-6">
      <label class="form-label d-flex align-items-center">
        <i class="bi bi-geo-alt-fill me-1"></i> <span>Address</span>
      </label>
      <input type="text" class="form-control" value="11209 RICHLAND AVE UNIT 1, LOS ANGELES">
    </div>

    <!-- Date of Birth (non-editable) -->
    <div class="col-md-6">
      <label class="form-label d-flex align-items-center">
        <i class="bi bi-calendar-event-fill me-1"></i> <span>DOB</span>
      </label>
      <input type="date" class="form-control" value="1998-06-21" disabled>
    </div>

    <!-- License No (non-editable) -->
    <div class="col-md-6">
      <label class="form-label d-flex align-items-center">
        <i class="bi bi-card-heading me-1"></i> <span>License No</span>
      </label>
      <input type="text" class="form-control" value="C5483921" disabled>
    </div>

    <!-- License Expiry (editable) -->
    <div class="col-md-6">
      <label class="form-label d-flex align-items-center">
        <i class="bi bi-calendar-check-fill me-1"></i> <span>Expiry</span>
      </label>
      <input type="date" class="form-control" value="2030-06-21">
    </div>

    <!-- Profile Photo (editable) -->
    <div class="col-md-6">
      <label class="form-label d-flex align-items-center">
        <i class="bi bi-image-fill me-1"></i> <span>Photo</span>
      </label>
      <input type="file" class="form-control">
    </div>

    <!-- Save Button -->
    <div class="col-12">
      <button type="submit" class="btn btn-primary btn-custom" style="float:right;">
        <i class="bi bi-save me-1"></i> Save Changes
      </button>
    </div>
  </form>
</div>
</body>
</html>
<?php require_once('includes/footer.php');?>