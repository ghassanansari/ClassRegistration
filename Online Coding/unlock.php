<?php
	$login=$_COOKIE['login'];
	if(isset($_POST['path'])){
		$path=$_POST['path'];
	}elseif(isset($_POST['pathn'])){
		$path="./".$_POST['pathn'];
	}
	require_once('dbs.php');
	$con=mysqli_connect($sql_host, $sql_username, $sql_password);
	
	if ( mysqli_connect_errno()){
		echo "Failed to connect ". mysqli_connect_error();
		exit;
	}
	mysqli_query($con, "CREATE DATABASE IF NOT EXISTS $sql_database");
	$con=mysqli_connect($sql_host, $sql_username, $sql_password, $sql_database);
	$sql = "DELETE FROM filelock WHERE user = '$login' AND filepath = '$path'";
	$con->query($sql);
	
	?>