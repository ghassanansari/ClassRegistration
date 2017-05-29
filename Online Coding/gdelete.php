<?php
	if ( ! isset($_COOKIE['login']) ) {
		echo "Need to log in first";
		header("refresh:2;url=login.html");
		exit;
	}
	$login=$_COOKIE['login'];
	
	require_once('dbs.php');
	$con=mysqli_connect($sql_host, $sql_username, $sql_password);
	
	if ( mysqli_connect_errno()){
		echo "Failed to connect ". mysqli_connect_error();
		exit;
	}
	$con=mysqli_connect($sql_host, $sql_username, $sql_password,$sql_database);

	if(isset($_POST['dgroup']) ){
	$group=$_POST['dgroup'];
	}
	$sql = "DELETE FROM cgroups WHERE user='$login' AND gname = '$group'";
	$result = $con->query($sql);
	
	header("Location: contacts.php");
	die();

?>