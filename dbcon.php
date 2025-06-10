<?php
	$conn = new mysqli('localhost', 'root', '', 'db_monitoring');//db_monitoring diganti sesuai dengan nama db yang dibuat
	//punyaku db_monitoring
	
	if(!$conn){
		die("Error: Failed to connect to database");
	}
?>	
<?php

// Database configuration 	
$hostname = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname   = "db_monitoring";//db_monitoring diganti sesuai dengan nama db yang dibuat
 
// Create database connection 
$con = new mysqli($hostname, $username, $password, $dbname); 
 
// Check connection 
if ($con->connect_error) { 
	die("Connection failed: " . $con->connect_error); 
}

?>