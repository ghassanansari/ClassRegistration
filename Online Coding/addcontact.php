<?php
	if ( ! isset($_COOKIE['login']) ) {
		echo "Need to log in first";
		header("refresh:2;url=login.php");
		exit;
	}
	$login=$_COOKIE['login'];
	require_once('dbs.php');	
	$con=mysqli_connect($sql_host, $sql_username, $sql_password, $sql_database);
	
	if ( mysqli_connect_errno()){
		echo "Failed to connect ". mysqli_connect_error();
		exit;
	}
	$id = $_GET['id'];
	echo $id;
	$member = $_GET['member'];
	echo "<br>member added ".$member;
		$sql = "SELECT * FROM groups WHERE id = '$id'";
		$result = $con->query($sql);
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			$groupname=$row['name'];
			if($row["m1"]== Null){ 	
				//echo $groupname."1";
				//$sql = "UPDATE groups SET m1 = $member WHERE id = '$id'";
				//$con->query($sql);
				$sql = "INSERT INTO notifications(sender,receiver,type,groupname) VALUES ('$login','$member','group','$groupname')";
				$con->query($sql);
			}elseif($row["m2"]== Null){ 	

				//$sql = "UPDATE groups SET m2 = '$member' WHERE id = '$id'";
				//$con->query($sql);		
				$sql = "INSERT INTO notifications(sender,receiver,type,groupname) VALUES ('$login','$member','group','$groupname')";
				$con->query($sql);
			}elseif($row["m3"]== Null){ 

				//$sql = "UPDATE groups SET m3 = $member WHERE id = '$id'";
				//$con->query($sql);			
				$sql = "INSERT INTO notifications(sender,receiver,type,groupname) VALUES ('$login','$member','group','$groupname')";
				$con->query($sql);
			}elseif($row["m4"]== Null){ 

				//$sql = "UPDATE groups SET m4 = $member WHERE id = '$id'";
				//$con->query($sql);			
				$sql = "INSERT INTO notifications(sender,receiver,type,groupname) VALUES ('$login','$member','group','$groupname')";
				$con->query($sql);
			}elseif($row["m5"]== Null){ 

				//$sql = "UPDATE groups SET m5 = $member WHERE id = '$id'";
				//$con->query($sql);			
				$sql = "INSERT INTO notifications(sender,receiver,type,groupname) VALUES ('$login','$member','group','$groupname')";
				$con->query($sql);
			}

		}
	
	header("Location: groupfiles.php?id=".$id);
		die();


	?>