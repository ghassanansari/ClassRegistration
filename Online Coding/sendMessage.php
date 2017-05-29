<?php
	if ( ! isset($_COOKIE['login']) ) {
		echo "Need to log in first";
		header("refresh:2;url=login.php");
		exit;
	}
	$login=$_COOKIE['login'];
	require_once('dbs.php');	

	$con=mysqli_connect($sql_host, $sql_username, $sql_password, $sql_database);
	
	if ( mysqli_connect_errno()){
		echo "Failed to connect ". mysqli_connect_error();
		exit;
	}
	$contact = $_POST['contact'];
	$subject = $_POST['subject'];
	$message = $_POST['message'];

	//echo $contact;

	$sql = "INSERT INTO messages (sender,contact,subject,message,viewed,datesent) VALUES ('$login','$contact','$subject','$message',0,NOW())";
	$con->query($sql);

		header("refresh:1;url=messages.php");



	?>