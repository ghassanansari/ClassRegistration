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

	$action = isset($_POST['action']) ? $_POST['action'] : false;
	$this->id = isset($_POST['id']) ? $_POST['id'] : false;
	switch ($action) {
				case 'accept' : 
					accept(); break;
				case 'reject' : 
					reject(); break;
				default :
					return;
					break;
			}
     function accept() {
	$sql = mysqli_query($con,"SELECT * FROM notifications WHERE id = '$id'");
		$sender = row['sender'];
		$receiver = row['receiver'];
		$type = row['type'];
		$sql = mysqli_query($con,"UPDATE notifications SET status='1' WHERE id='$id'");
		$con->query($sql);
		if (type = 'contact'){
			//add contact to sender and receiver
			mysqli_query($con, "CREATE DATABASE IF NOT EXISTS $contact_database");
			$con = mysqli_connect($sql_host, $sql_username, $sql_password, $contact_database);
			$sql = mysqli_query($con,"INSERT INTO '$sender'(contacts,status) VALUES ('$receiver','accepted')");
			$sql = mysqli_query($con,"INSERT INTO '$receiver'(contacts,status) VALUES ('$sender','accepted')");
			$con = mysqli_connect($sql_host, $sql_username, $sql_password, $sql_database);
			$sql = "DELETE FROM notifications WHERE ID = '$id'";
			$con->query($sql);
			
		}else{
			//type is group
		}
		exit;
	}	

     function reject() {
			$sql = "DELETE FROM notifications WHERE id = '$id'";
			$con->query($sql);
			exit;
	}
?>
		