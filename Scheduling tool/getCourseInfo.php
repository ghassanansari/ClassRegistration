<?php
require_once('db.php');
$con = mysqli_connect($sql_host, $sql_username, $sql_password, $sql_database);

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$course1 = $_POST['course1'];
$course2 = $_POST['course2'];
if ($course1 . $course2 == "ElectiveC") {
    echo " 0.5 credits in Communications Electives. ";
    echo "ELEC 4503 [0.5]
			Radio Frequency Lines and Antennas	<br />
			ELEC 4505 [0.5] Telecommunication Circuits	<br />
			ELEC 4506 [0.5] CAD for Communication Circuits	<br />
			ELEC 4509 [0.5]
			Communication Links	<br />
			ELEC 4702 [0.5] Fiber Optic Communications	<br /> 
			SYSC 4607 [0.5] Wireless Communications	";
} elseif ($course1 . $course2 == "ElectiveD") {
    echo "0.5 credits in Systems and Computer (SYSC) or Electronics (ELEC) at the 3000- or 4000-level.";
} elseif ($course1 . $course2 == "Elective") {
    echo "Complementary Study Elective";
} elseif ($course1 . $course2 == "Science") {
    echo "Basic Science Elective";
} else {
    
    echo "Fall :";
    echo "<br />";
    $result        = mysqli_query($con, "SELECT * FROM Fall WHERE SUBJ='$course1' and CRSE='$course2' ");
    $row           = mysqli_fetch_array($result);
    $CRSE          = $row['CRSE'];
    $SUBJ          = $row['SUBJ'];
    $CATALOG_TITLE = $row['CATALOG_TITLE'];
    if ($CRSE == null) {
        echo $course1 . $course2 . " is not offered in the Fall Semester";
    } else {
        echo $SUBJ . $CRSE . ": " . $CATALOG_TITLE . " is offered in the Fall Semester";
        echo "<br />";
    }
    echo "Winter :";
    echo "<br />";
    
    $result        = mysqli_query($con, "SELECT * FROM Winter WHERE SUBJ='$course1 ' and CRSE='$course2' ");
    $row           = mysqli_fetch_array($result);
    $CRSE          = $row['CRSE'];
    $SUBJ          = $row['SUBJ'];
    $CATALOG_TITLE = $row['CATALOG_TITLE'];
    if ($SUBJ == null) {
        echo $course1 . $course2 . " is not offered in the Winter Semester";
    } else {
        echo $SUBJ . $CRSE . ": " . $CATALOG_TITLE . " is offered in the Winter Semester";
        echo "<br />";
    }
}
?>