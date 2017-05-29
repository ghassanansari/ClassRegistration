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

	if (isset($_POST['grouprequest'])) {
    $ids=$_POST['grouprequest']; 
	}
	if (isset($_POST['accept'])){
		if (is_array($ids)){
			foreach($ids as $id){
				$sql = mysqli_query($con,"SELECT * FROM notifications WHERE id = '$id'");
				$row = $sql->fetch_assoc();
				$sender = $row['sender'];
				$receiver = $row['receiver'];
				$type = $row['type'];
				$groupname = $row['groupname'];

				$result = mysqli_query($con,"SELECT * FROM groups WHERE admin = '$sender' AND name = '$groupname'");
				$row1= mysqli_fetch_array($result);
				$m1 = $row1['m1'];
				$m2 = $row1['m2'];
				$m3 = $row1['m3'];
				$m4 = $row1['m4'];
				$m5 = $row1['m5'];


				if ($m1 == NULL){
					$sql = mysqli_query($con,"UPDATE groups SET m1='$login' WHERE admin = '$sender' AND name = '$groupname'");
				}
				elseif ($m2 == NULL){
					$sql = mysqli_query($con,"UPDATE groups SET m2='$login' WHERE admin = '$sender' AND name = '$groupname'");
				}
				elseif ($m3 == NULL){						
					$sql = mysqli_query($con,"UPDATE groups SET m3='$login' WHERE admin = '$sender' AND name = '$groupname'");
				}
				elseif ($m4 == NULL){						
					$sql = mysqli_query($con,"UPDATE groups SET m4='$login' WHERE admin = '$sender' AND name = '$groupname'");
				}
				elseif ($m5 == NULL){						
					$sql = mysqli_query($con,"UPDATE groups SET m5='$login' WHERE admin = '$sender' AND name = '$groupname'");
				}				

				$sql = mysqli_query($con,"DELETE FROM notifications WHERE id = '$id'");

			}
		}
	}
	elseif (isset($_POST['reject'])){
		if (is_array($ids)){
			foreach($ids as $id){
			$sql = "DELETE FROM notifications WHERE id = '$id'";
			$con->query($sql);
			}
		}
	}

header("refresh:1;url=notifications.php");
?>
