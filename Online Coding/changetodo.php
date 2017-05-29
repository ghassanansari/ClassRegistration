<?php
	if ( ! isset($_COOKIE['login']) ) {
		echo "Need to log in first";
		header("refresh:2;url=login.php");
		exit;
	}
	$login=$_COOKIE['login'];
	require_once('dbs.php');	

	$con=mysqli_connect($sql_host, $sql_username, $sql_password, $todolist_database);
	
	if ( mysqli_connect_errno()){
		echo "Failed to connect ". mysqli_connect_error();
		exit;
	}
	if(isset($_POST['task']) ){
	$id=$_POST['task'];
		$sql = "UPDATE $login SET done = 1 WHERE id = '$id' ";
	$con->query($sql);
	}

	if(isset($_POST['task2']) ){
	$id=$_POST['task2'];
		$sql = "UPDATE $login SET done = 0 WHERE id = '$id'";
	$con->query($sql);
	}


		header("refresh:1;url=todolist.php");



	?>