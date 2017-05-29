<?php

require_once('dbs.php');
	$con=mysqli_connect($sql_host, $sql_username, $sql_password);
	
	if ( mysqli_connect_errno()){
		echo "Failed to connect ". mysqli_connect_error();
		exit;
	}
	mysqli_query($con, "CREATE DATABASE IF NOT EXISTS $sql_database");
	$con=mysqli_connect($sql_host, $sql_username, $sql_password, $sql_database);
	$user=$_COOKIE['login'];

$contact = trim(strtolower($_POST['contact']));
$contact = mysqli_real_escape_string($con,$contact);

$query = "SELECT login FROM userslist WHERE login = '$contact' AND login!='$user'";
$result = mysqli_query($con,$query);
$num = mysqli_num_rows($result);

echo $num;
mysqli_close($con);
