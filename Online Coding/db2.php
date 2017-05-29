<?php
	require_once('dbs.php');
	$con=mysqli_connect($sql_host, $sql_username, $sql_password);
	if ( mysqli_connect_errno()){
		echo "Failed to connect ". mysqli_connect_error();
		exit;
	}
	$login = $_POST['login'];	
	$password = $_POST['password'];
		$con=mysqli_connect($sql_host, $sql_username, $sql_password, $sql_database);
	$sql = "SELECT * FROM userslist WHERE login='$login' 
		AND password='$password'";
	
	$rows = $con->query($sql);
	$num = $rows->num_rows;
	if($num>0){
		echo "You are in";

		setcookie("login", "$login", time()+3600 );

		header("Location: myaccount.php");	
	}else{
		echo "Error in login";
		header("refresh:3;url=login.html");
	}

?>