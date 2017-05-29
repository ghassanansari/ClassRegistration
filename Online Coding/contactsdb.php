<?php
	$login=$_COOKIE['login'];
	require_once('dbs.php');
	$con=mysqli_connect($sql_host, $sql_username, $sql_password);
	
	if ( mysqli_connect_errno()){
		echo "Failed to connect ". mysqli_connect_error();
		exit;
	}
	mysqli_query($con, "CREATE DATABASE IF NOT EXISTS $sql_database");
	$con=mysqli_connect($sql_host, $sql_username, $sql_password, $sql_database);
	$sql = "CREATE TABLE IF NOT EXISTS notifications(
		id int NOT NULL AUTO_INCREMENT,
		sender VARCHAR(255),
		receiver VARCHAR(255),
		type VARCHAR(255),
		groupname VARCHAR(255),
		PRIMARY KEY (id)
	)";
	$con->query($sql);
	
	$contact = $_POST['contact'];
	
	$i=0;
	$query = "SELECT * FROM `userslist`WHERE `login`='$contact'";
	$result = mysqli_query($con,$query);
	while($row = mysqli_fetch_array($result)){
		$i=1;
	}
	if ($i==1){
		$sql = "INSERT INTO notifications(sender,receiver,type) VALUES ('$login','$contact','contact')";
		$con->query($sql);
	}
	else{
		echo "user not found </br>";
	}
		header("refresh:1;url=contacts.php");
?>