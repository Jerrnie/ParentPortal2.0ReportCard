<?php
date_default_timezone_set("Asia/Manila");
$database = "PPtest";
$host = "52.74.3.44";
$username = "smsuser";
$password = "smspass";

$conn = mysqli_connect($host, $username, $password, $database);

if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
// error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);

?>
