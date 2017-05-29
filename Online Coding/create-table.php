<?php 
require_once('dbs.php');
	$con=mysqli_connect($sql_host, $sql_username, $sql_password);
	
	if ( mysqli_connect_errno()){
		echo "Failed to connect ". mysqli_connect_error();
		exit;
	}
	mysqli_query($con, "CREATE DATABASE IF NOT EXISTS $sql_database");
	$con=mysqli_connect($sql_host, $sql_username, $sql_password, $sql_database);
//Create the table
mysqli_query($con,"create table chat(
   time int(11) NOT NULL, 
   name varchar(30) NOT NULL, 
   ip varchar(15) NOT NULL, 
   message varchar(255) NOT NULL, 
   PRIMARY KEY (time)
)");
?>