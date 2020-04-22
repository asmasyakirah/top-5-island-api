<?php

// Required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Call function file
include('../resources/function.php');

// Set default date
$date = "2017-03-01";

// Check if date parameter is passed
if (isset($_GET['d'])&&$_GET['d']!=null) 
{
	$date = $_GET['d'];
}

// Get the result
$result = getTop5ByDate($date);

// Show result
echo json_encode($result);

?>