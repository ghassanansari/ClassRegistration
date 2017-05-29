<?php
	
	require_once('dbs.php');
	$con=mysqli_connect($sql_host, $sql_username, $sql_password);
	
	if ( mysqli_connect_errno()){
		echo "Failed to connect ". mysqli_connect_error();
		exit;
	}
	$sql = "CREATE DATABASE IF NOT EXISTS $sql_database" ;
	mysqli_query($con, $sql);
	
	$con=mysqli_connect($sql_host, $sql_username, $sql_password, $sql_database);
	$sql = "CREATE TABLE IF NOT EXISTS userslist(
		login VARCHAR(255),
		firstname VARCHAR(255),
		lastname VARCHAR(255),
		skype VARCHAR(255),
		password VARCHAR(100),
		PRIMARY KEY (login)
	)";
	mysqli_query($con, $sql);
	
	
	$login = $_POST['login'];
	if (isset($_POST['firstname'])){
		$firstname = $_POST['firstname'];
	}
	if (isset($_POST['lastname'])){
		$lastname = $_POST['lastname'];
	}	
	if (isset($_POST['skype'])){
		$skype = $_POST['skype'];
	}
	$pass1 = $_POST['password'];
	$pass2 = $_POST['password2'];
	
	if (preg_match('/[^a-zA-Z0-9]+/', $login) != 0)
{
  header("Refresh: 4; url=register.html");
    die("Username should only consist of alphanumeric characters. ". mysqli_error($con));
}
	
	
	if ($pass1 != $pass2){
	echo "Passwords are not identical!". mysqli_error($con);
	header("Refresh: 4; url=register.html");
	} elseif (strlen($pass1) < 6){
	header("Refresh: 4; url=register.html");
	die("Password is too short!". mysqli_error($con));
	}
	$login = mysqli_real_escape_string($con, $login);
	$chk=mysqli_query($con, "SELECT login FROM userslist WHERE login='".$login."'");
	if(mysqli_num_rows($chk)>0)
   {
    echo"<br/>Username already exists";
	header("Refresh: 4; url=register.html");
   }
	else
    {
   $sql = "INSERT INTO userslist VALUES('$login', '$firstname', '$lastname', '$skype', '$pass1')";
	if($con->query($sql)){
		echo "<br/>Registration complete";
		header("Refresh: 3; url=login.html");
	}else{
		echo "<br/>The record cannot be added ". mysqli_error($con);
		header("Refresh: 4; url=register.html");
	}
    }
	
	
	
	
	
	
	
	
	
?>