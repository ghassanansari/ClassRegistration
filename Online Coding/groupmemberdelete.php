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

	$member=$_GET['member'];
	$id=$_GET['id'];
	$sql = "SELECT * FROM groups WHERE id = '$id'";
	$result = $con->query($sql);
	$row = $result->fetch_assoc();

	$m1=$row['m1'];
	$m2=$row['m2'];
	$m3=$row['m3'];
	$m4=$row['m4'];
	$m5=$row['m5'];


	if ($m1 == $member){
	$sql = "UPDATE groups SET m1 = NULL WHERE id = '$id' ";
	$result = $con->query($sql);
	}	
	if ($m2 == $member){
	$sql = "UPDATE groups SET m2 = NULL WHERE id = '$id' ";
	$result = $con->query($sql);
	}	
	if ($m3 == $member){
	$sql = "UPDATE groups SET m3 = NULL WHERE id = '$id' ";
	$result = $con->query($sql);
	}	
	if ($m4 == $member){
	$sql = "UPDATE groups SET m4 = NULL WHERE id = '$id' ";
	$result = $con->query($sql);
	}
	if ($m5 ==  $member){
	$sql = "UPDATE groups SET m5 = NULL WHERE id = '$id' ";
	$result = $con->query($sql);
	}

	
	header("Location: groupfiles.php?id=".$id);
	die();

?>