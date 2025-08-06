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
    <div class="profile-card text-center">
      <img src="img/profilepic.jpg" alt="Profile Photo" class="rounded-circle mb-3" width="100">
      <h4 class="fw-bold" style="color: #E76F51!important;font-weight:bold">Jessica</h4>
      <p class="text-muted"><b><i>Customer ID: ALLOPS-43125</i></b></p>

      <hr>

      <div class="text-start">
        <p><i class="bi bi-person-fill me-2"></i><strong>Name:</strong> Jessica </p>
        <p><i class="bi bi-envelope-fill me-2"></i><strong>Email:</strong> Jessica@gmail.com</p>
        <p><i class="bi bi-phone-fill me-2"></i><strong>Phone:</strong> +1(987)654-3210</p>
        <p><i class="bi bi-geo-alt-fill me-2"></i><strong>Address:</strong> 11209 RICHLAND AVE UNIT 1,LOS ANGELES, CA, USA</p>
        <p><i class="bi bi-calendar-fill me-2"></i><strong>Date of Birth:</strong> 1998-06-21</p>
        <p><i class="bi bi-card-text me-2"></i><strong>License No:</strong> C5483921</p>
        <p><i class="bi bi-calendar-check-fill me-2"></i><strong>License Expiry:</strong> 2030-06-21</p>
      </div>

      <hr>
    
        <h5 class="text-start mb-3" style="color: #E76F51!important;font-weight:bold"><i class="bi bi-clock-history me-2"></i> Ride Summary</h5>

        <div class="text-start">
        <p><i class="bi bi-car-front-fill me-2"></i><strong>Total Rides:</strong> 27</p>
        <p><i class="bi bi-calendar-event-fill me-2"></i><strong>Last Ride:</strong> July 25, 2025</p>
        <p><i class="bi bi-geo-fill me-2"></i><strong>Route:</strong> Los Angeles → Texas</p>
        <p><i class="bi bi-currency-dollar me-2"></i><strong>Cost:</strong> $2,450</p>
        <hr>
        <div class="text-end mt-3">
            <button class="btn btn-warning me-2">
                <i class="bi bi-pencil-square"></i> Edit Profile
            </button>
            <button class="btn btn-danger">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </div>
    </div>
  </div>
  </div>
</body>
</html>
<?php require_once('includes/footer.php');?>