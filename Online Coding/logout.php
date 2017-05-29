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
	$sql = "DELETE FROM filelock WHERE user = '$login'";
	$con->query($sql);

	setcookie("login", "", time()-3600);
	echo "<p style=\"text-align:center\"><b>You have successfully logged out.
		<br>Redirecting to Login Page</b>";
	header("refresh:2;url=login.html");
?>