<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// modify these settings according to the account on your database server.
$host = "127.0.0.1:54138";
$port = "3306";
$username = "azure";
$user_pass = "6#vWHD_$";
$database_in_use = "employee_application";

#$mysqli = mysqli_connect($host, $username, $user_pass, $database_in_use);
$mysqli = new mysqli($host, $username, $user_pass, $database_in_use);
if ($mysqli->connect_error) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
echo $mysqli->host_info . "<br>";

?>
