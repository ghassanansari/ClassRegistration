<?php
require_once('dbs.php');
	$login = $_COOKIE['login'];
	$con=mysqli_connect($sql_host, $sql_username, $sql_password);
	if ( mysqli_connect_errno()){
		echo "Failed to connect ". mysqli_connect_error();
		exit;
	}
	mysqli_query($con, "CREATE DATABASE IF NOT EXISTS $sql_database");
	$con=mysqli_connect($sql_host, $sql_username, $sql_password, $sql_database);

	if (isset($_POST['contactrequest'])) {
    $ids=$_POST['contactrequest']; 
}
	if (isset($_POST['accept'])){
	if (is_array($ids)){
	foreach($ids as $id){
		$sql = mysqli_query($con,"SELECT * FROM notifications WHERE id = '$id'");
		$row = $sql->fetch_assoc();
		$sender = $row['sender'];
		$receiver = $row['receiver'];
		$type = $row['type'];
		//$sql = mysqli_query($con,"UPDATE notifications SET status='1' WHERE id='$id'");
		//$con->query($sql);
		if ($type == 'contact'){
			//add contact to sender and receiver
			mysqli_query($con, "CREATE DATABASE IF NOT EXISTS $contact_database");
			$con = mysqli_connect($sql_host, $sql_username, $sql_password, $contact_database);
			$sql = "CREATE TABLE IF NOT EXISTS $sender (
				contacts VARCHAR(100),
				status VARCHAR(100),
				PRIMARY KEY (contacts)
				)";
			mysqli_query($con, $sql);
			$sql = mysqli_query($con,"INSERT INTO $sender (contacts,status) VALUES ('$receiver','accepted')");
			$sql = "CREATE TABLE IF NOT EXISTS $receiver (
				contacts VARCHAR(100),
				status VARCHAR(100),
				PRIMARY KEY (contacts)
				)";
			mysqli_query($con, $sql);
			$sql = mysqli_query($con,"INSERT INTO $receiver (contacts,status) VALUES ('$sender','accepted')");
			$con = mysqli_connect($sql_host, $sql_username, $sql_password, $sql_database);
			$sql = "DELETE FROM notifications WHERE id = '$id'";
			$con->query($sql);
			
		}elseif ($type == 'group'){
			mysqli_query($con, "CREATE DATABASE IF NOT EXISTS $contact_database");
			$con = mysqli_connect($sql_host, $sql_username, $sql_password, $contact_database);
			$sql = mysqli_query($con,"INSERT INTO '$sender'(contacts,status) VALUES ('$receiver','accepted')");
			$sql = mysqli_query($con,"INSERT INTO '$receiver'(contacts,status) VALUES ('$sender','accepted')");
			$con = mysqli_connect($sql_host, $sql_username, $sql_password, $sql_database);
			$sql = "DELETE FROM notifications WHERE id = '$id'";
			$con->query($sql);
		}
	
	}}
	
	} elseif (isset($_POST['reject'])){
	if (is_array($ids)){
		foreach($ids as $id){
		$sql = "DELETE FROM notifications WHERE id = '$id'";
		$con->query($sql);
		}
	
	}}
header("refresh:3;url=notifications.php");
?>