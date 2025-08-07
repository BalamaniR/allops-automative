<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Allops</title>
  <!-- Bootstrap CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  <style>
    .app_title{
     margin-right: 500px;
      color: #002D62;
      font-weight: bold;
      font-family: Georgia, 'Times New Roman', Times, serif;
      font-size:34px;
    }

  </style>
</head>
<body>

 <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand d-flex flex-column align-items-center" href="#">
      <img src="img/logo.png" alt="Logo" width="80" height="60" class="me-2">
    </a>

    <!-- Hamburger Icon (visible on mobile) -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <?php if (empty($_SESSION['user_email'])) { ?>
          <li class="nav-item">
            <a class="nav-link" href="login.php">Login</a>
          </li>
        <?php } else { ?>
          <li class="nav-item d-flex align-items-center">
            <span class="me-2">Welcome, <?php echo $_SESSION['user_name']; ?></span>
            <a class="nav-link" href="logout.php">Logout</a>
          </li>
        <?php } ?>
      </ul>
    </div>
  </div>  
  <?php if (!empty($_SESSION['user_email'])) { ?>
  <button class="btn border ms-2" id="menuToggle">
    <i class="bi bi-list fs-3"></i> <!-- Bootstrap Icons -->
  </button>
  <?php }?>
</nav>
<?php if (!empty($_SESSION['user_email'])): ?>
<div class="position-relative">
 <div id="customMenu" class="position-absolute top-100 end-0 bg-light border rounded shadow"
     style="display: none; z-index: 1050; width: 220px; padding: 15px;">
  <ul class="list-unstyled mb-0">
    <li><a href="myprofile.php" class="text-dark text-decoration-none d-block py-2 fs-6 bi-person-circle"> Profile</a></li>
    <li><a href="search.php" class="text-dark text-decoration-none d-block py-2 fs-6 bi-car-front-fill"> Book Ride</a></li>
     <li><a href="myhistory.php" class="text-dark text-decoration-none d-block py-2 fs-6 bi-clock-history"> Ride History</a></li>
    <li><a href="#" class="text-dark text-decoration-none d-block py-2 fs-6 bi-gear-fill"> Settings</a></li>
    <li><a href="logout.php" class="text-dark text-decoration-none d-block py-2 fs-6 bi-box-arrow-right"> Logout</a></li>
  </ul>
</div>
</div>
<?php endif; ?>


  <!-- Bootstrap JS -->
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const toggle = document.getElementById('menuToggle');
  const menu = document.getElementById('customMenu');

  if (toggle && menu) {
    toggle.addEventListener('click', function (e) {
      e.stopPropagation();
      menu.style.display = (menu.style.display === 'none' || menu.style.display === '') ? 'block' : 'none';
    });

    document.addEventListener('click', function (e) {
      if (!menu.contains(e.target) && !toggle.contains(e.target)) {
        menu.style.display = 'none';
      }
    });
  }
});
</script>
</body>
</html>
