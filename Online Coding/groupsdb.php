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

	$groupname = $_POST['groupname'];
	if(isset($_POST['contacts']) ){
	$contacts = $_POST['contacts'];
}
	if(isset($_POST['cgroup']) ){
		$gname=$_POST['cgroup'];
		$sql = "SELECT * FROM cgroups WHERE user = '$login' AND gname = '$gname'";
		$result = $con->query($sql);
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			$contacts=array();
			if($row["m1"]!= Null){$contacts[]=$row["m1"];}
			if($row["m2"]!= Null){$contacts[]=$row["m2"];}
			if($row["m3"]!= Null){$contacts[]=$row["m3"];}
			if($row["m4"]!= Null){$contacts[]=$row["m4"];}
			if($row["m5"]!= Null){$contacts[]=$row["m5"];}
		}
	}
	if(!empty($contacts)){
		foreach($contacts as $contact){
			echo $contact;
	        //$sql = mysqli_query($con, "SELECT * FROM $login");
			$sql = "INSERT INTO notifications(sender,receiver,type,groupname) VALUES ('$login','$contact','group','$groupname')";
			$con->query($sql);
		}
	}
	$sql = "INSERT INTO groups(name,admin) VALUES ('$groupname','$login')";
	$con->query($sql);

		mysqli_query($con, "CREATE DATABASE IF NOT EXISTS $update_database");
	$con=mysqli_connect($sql_host, $sql_username, $sql_password, $update_database);
	$sql = "CREATE TABLE IF NOT EXISTS $groupname (
		id int NOT NULL AUTO_INCREMENT,
		datesent datetime NOT NULL,
		sender VARCHAR(100),
		updates VARCHAR(100),
		PRIMARY KEY (id)
	)";
	mysqli_query($con, $sql);


$dir    = "./groupfiles/".$login."/".$groupname;
if (!is_dir($dir)){
			mkdir($dir,0777,true);
			$file = fopen($dir."/index.html", 'w') or die("can't open file");
			fclose($file);
        }
	header("Location: groups.php");

	?>