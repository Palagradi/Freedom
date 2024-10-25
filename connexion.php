<?php
	$host = 'localhost';
	$db   = 'efreedom';
	$user = 'root';
	$pass = '';
	$charset = 'utf8mb4';
	
	$con=mysqli_connect($host,$user,$pass,$db);
	if (!$con)
	  {
	  die("Connection error: " . mysqli_connect_errno());
	  }
	 //8bXQOwWvAHqq50KD
	 //UPDATE USER SET password=PASSWORD("8bXQOwWvAHqq50KD") WHERE USER='root'; flush privileges 
	 
	$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
?>
