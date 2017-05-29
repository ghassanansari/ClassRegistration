<?php
	if ( ! isset($_COOKIE['login']) ) {
		echo "Need to log in first";
		header("refresh:2;url=login.html");
		exit;
	}
	$login=$_COOKIE['login'];
	require_once('dbs.php');			


	$con=mysqli_connect($sql_host, $sql_username, $sql_password, $sql_database);
	
	if ( mysqli_connect_errno()){
		echo "Failed to connect ". mysqli_connect_error();
		exit;
	}   
	$id = $_GET['id'];
	$sql = "DELETE FROM messages WHERE id = '$id'";
	$result = $con->query($sql);			

		header("refresh:1;url=messages.php");

	?>