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
	if (isset($_POST['groupname'])) {
    $gname=$_POST['groupname']; 
	}
	$sql = "INSERT INTO cgroups (user, gname) VALUES ('$login', '$gname')";
	mysqli_query($con, $sql);
	
	if (isset($_POST['contacts'])) {
    $contacts=$_POST['contacts']; 
	}
		if (is_array($contacts)){
			foreach($contacts as $contact){
				$result = mysqli_query($con,"SELECT * FROM cgroups WHERE user = '$login' AND gname = '$gname'");
				$row= mysqli_fetch_array($result);
				$m1 = $row['m1'];
				$m2 = $row['m2'];
				$m3 = $row['m3'];
				$m4 = $row['m4'];
				$m5 = $row['m5'];
				
				if ($m1 == NULL){
					$sql = mysqli_query($con,"UPDATE cgroups SET m1='$contact' WHERE user = '$login' AND gname = '$gname'");
				}
				elseif ($m2 == NULL){
					$sql = mysqli_query($con,"UPDATE cgroups SET m2='$contact' WHERE user = '$login' AND gname = '$gname'");
				}
				elseif ($m3 == NULL){
					$sql = mysqli_query($con,"UPDATE cgroups SET m3='$contact' WHERE user = '$login' AND gname = '$gname'");
				}
				elseif ($m4 == NULL){
					$sql = mysqli_query($con,"UPDATE cgroups SET m4='$contact' WHERE user = '$login' AND gname = '$gname'");
				}
				elseif ($m5 == NULL){
					$sql = mysqli_query($con,"UPDATE cgroups SET m5='$contact' WHERE user = '$login' AND gname = '$gname'");
				}

			}
			$sql = "DELETE FROM cgroups WHERE gname = ''";
			mysqli_query($con, $sql);
			echo "<b>Group created successfully.</b>";
		}else{
			echo "<b>Please select more than one contact.</b>";
		}
			$sql = "DELETE FROM cgroups WHERE gname = ''";
			mysqli_query($con, $sql);
		header("refresh:1; url=contacts.php");

	?>