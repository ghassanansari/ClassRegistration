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
	$todo = $_POST['todo'];
	$due = $_POST['due'];

	$sql = "INSERT INTO $login (todo,due,done) VALUES ('$todo','$due',0)";
	$con->query($sql);

		header("refresh:1;url=todolist.php");



	?>