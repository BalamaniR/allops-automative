<?php
#error_reporting(0);
require_once('classes/functions.php');
$carId = $_REQUEST['cid'];
$carData = $obj->get_carnames($carId);
echo json_encode($carData);
?>