 <?php
$servername = "localhost";
$username   = "scheduler_admin";
$password   = "scheduler admin password DCNI DEMAS";
$dbname = "schedulerdb";

if (!function_exists('mysqli_init') && !extension_loaded('mysqli')) {
	error_log("mysqli dont found");
	exit();
} 
$conn = new mysqli($servername, $username, $password,$dbname);

if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
    exit();
}


?> 