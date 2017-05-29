<?php
	require_once('dbs.php');
	$con=mysqli_connect($sql_host, $sql_username, $sql_password, $sql_database);
	
	$password = "123'; DELETE FROM userslist WHERE 1='1";
	$sql = "SELECT * FROM userslist WHERE login='omer' 
		AND password='$password'";
	echo $sql."<br/>";
	
	$con->multi_query($sql);
	echo 'ok';
?>