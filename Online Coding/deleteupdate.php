<?php
	if ( ! isset($_COOKIE['login']) ) {
		echo "Need to log in first";
		header("refresh:2;url=login.html");
		exit;
	}
	$login=$_COOKIE['login'];
	
	require_once('dbs.php');

	if ( mysqli_connect_errno()){
		echo "Failed to connect ". mysqli_connect_error();
		exit;
	}
	$con=mysqli_connect($sql_host, $sql_username, $sql_password,$update_database);

	$id=$_GET['id'];
	$gname = $_GET["groupname"];
	$groupid = $_GET["groupid"];
	

	$sql = "DELETE FROM $gname WHERE id = '$id'";
	$result = $con->query($sql);
	header("Location: groupfiles.php?id=".$groupid);
	die();

?>
