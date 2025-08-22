<?php 
error_reporting(0);

require_once('includes/header.php');
require_once('classes/functions.php');
$user=$obj->get_userDetails();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login to Allops Automative Services</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <style>
    @media (min-width: 1400px) {
    .container, .container-lg, .container-md, .container-sm, .container-xl, .container-xxl {
        max-width: 1500px;
    }
}
  </style>
  </head>
    <body>
  <div class="container min-vh-100 mt-5">
    <h2 class="mb-4 text-center mb-5">Rental history overview</h2>
    <div class="p-3 shadow-lg rounded bg-white">
    <table id="carTable" class="table table-striped table-bordered">
      <thead>
        <tr>
            <th>#</th>
            <th>Customer ID</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Address</th>
            <th>License Number</th>
            <th>License Exp.Date</th>
            <th>Policy Number</th>
            <th>Journey Status</th>
            <th>Options</th>
        </tr>
      </thead>
      <tbody>
        <?php 
            $i=0;
            foreach($user as $row){
              $i++;
          ?>
        <tr>
          <td><?php echo $i;?></td>
          <td><?php echo $row['customer_id'];?></td>
          <td><?php echo $row['user_name'];?></td>
          <td><?php echo $row['user_phone'];?></td>
           <td><?php echo $row['user_address'];?></td>
          <td><?php echo $row['user_driver_license_number'];?></td>
          <td><?php echo $row['user_license_expiry_date'];?></td>
          <td><?php echo $row['insurance_policy_number'];?></td>
          <td><?php echo  ($row['journey_status'] == '1') ? 'Started': 'End';?></td>
          <td><a href="edit_user_data.php?cid=<?php echo $row['customer_id']; ?>">Edit</a> / <a href="viewData.php?cid=<?php echo $row['customer_id']; ?>">View</a></td>
        </tr>

        <?php }?>
      </tbody>
    </table>
    </div>
  </div>


    </body>
</html>
<?php require_once('includes/footer.php');?>
  <!-- JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#carTable').DataTable();
    });
  </script>