<?php
		$direc = $_POST['action'];
		if (!is_dir($direc)){
			mkdir($direc,0777,true);
        }
		$dir=$direc."/";
		//$dir = "groupfiles/ziyadrabeh/test/";
        $filename = isset($_POST['filename']) ? $_POST['filename'] : false;
        $content = isset($_POST['content']) ? $_POST['content'] : '';
        file_put_contents($dir.$filename, urldecode($content));
		
		$filepath="./".$dir.$filename;
		$login=$_COOKIE['login'];
		require_once('dbs.php');
		$con=mysqli_connect($sql_host, $sql_username, $sql_password);
		
		if ( mysqli_connect_errno()){
			echo "Failed to connect ". mysqli_connect_error();
			exit;
		}
		mysqli_query($con, "CREATE DATABASE IF NOT EXISTS $sql_database");
		$con=mysqli_connect($sql_host, $sql_username, $sql_password, $sql_database);
		$sql = "SELECT * FROM filelock WHERE filepath='$filepath'";
		$result = $con->query($sql);
		if ($result->num_rows == 0) {
			$sql = mysqli_query($con,"INSERT INTO filelock (user,filepath) VALUES ('$login','$filepath')");
		}
		
?>