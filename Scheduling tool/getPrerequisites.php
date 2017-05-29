<?php

require_once('db.php');
$con = mysqli_connect($sql_host, $sql_username, $sql_password, $sql_database);
$crse = $_POST['crse'];
$crse = str_replace(" ","",$crse);

if ($crse == "ElectiveC") {
	echo "prerequisite for Elective C is 3rd year standing and each course has its own prerequisite";
}
elseif ($crse == "ElectiveD") {
		echo "prerequisite for Elective D is 3rd year standing and each course has its own prerequisite";
	}else {
		$crse = $_POST['crse'];
		if (mysqli_connect_errno()) {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		$result = mysqli_query($con, "SELECT * FROM prerequisiteinfo WHERE Course='$crse'");
		if (!$result) {
			printf("Error: %s\n", mysqli_error($con));
			exit();
		}
		$row = mysqli_fetch_array($result);

		$Course = $row['Course'];
		$PRE    = $row['prerequisite'];

		if ($Course == null) {
			echo $crse . " Has no Prerequisites";
		} else {
			echo "The prerequisites for  " . $Course . "  are  " . $PRE . " \n\n";
		}
	}