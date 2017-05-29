<?php
    require_once('db.php');
	$con=mysqli_connect($sql_host, $sql_username, $sql_password, $sql_database);
    if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    $fall=false;
    $winter=false;
    // Creating the tables for lectures, labs, tutorials and pass sessions for fall and winter
    $sqlF1 = "CREATE TABLE IF NOT EXISTS LecturesF(id int(11),CRSE varchar(255),SUBJ varchar(255),SEQ varchar(255),CATALOG_TITLE varchar(255),INSTR_TYPE varchar(255),DAYS varchar(255), START_TIME varchar(255),END_TIME varchar(255), ROOM_CAP varchar (255), YEAR int(11) NOT NULL,APPEAR tinyint(1) NOT NULL)";
    $con->query($sqlF1);
    $sqlW1 = "CREATE TABLE IF NOT EXISTS LecturesW(id int(11),CRSE varchar(255),SUBJ varchar(255),SEQ varchar(255),CATALOG_TITLE varchar(255),INSTR_TYPE varchar(255),DAYS varchar(255), START_TIME varchar(255),END_TIME varchar(255), ROOM_CAP varchar (255), YEAR int(11) NOT NULL,APPEAR tinyint(1) NOT NULL)";
    $con->query($sqlW1);
    $sqlF2 = "CREATE TABLE IF NOT EXISTS LabF(id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,LID int(11),CRSE varchar(255),SUBJ varchar(255),SEQ varchar(255),CATALOG_TITLE varchar(255),INSTR_TYPE varchar(255),DAYS varchar(255), START_TIME varchar(255),END_TIME varchar(255), ROOM_CAP varchar (255))";
    $con->query($sqlF2);
    $sqlW2 = "CREATE TABLE IF NOT EXISTS LabW(id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,LID int(11),CRSE varchar(255),SUBJ varchar(255),SEQ varchar(255),CATALOG_TITLE varchar(255),INSTR_TYPE varchar(255),DAYS varchar(255), START_TIME varchar(255),END_TIME varchar(255), ROOM_CAP varchar (255))";
    $con->query($sqlW2);
    $sqlF3 = "CREATE TABLE IF NOT EXISTS TutorialF(id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,LID int(11),CRSE varchar(255),SUBJ varchar(255),SEQ varchar(255),CATALOG_TITLE varchar(255),INSTR_TYPE varchar(255),DAYS varchar(255), START_TIME varchar(255),END_TIME varchar(255), ROOM_CAP varchar (255))";
    $con->query($sqlF3);
    $sqlW3 = "CREATE TABLE IF NOT EXISTS TutorialW(id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,LID int(11),CRSE varchar(255),SUBJ varchar(255),SEQ varchar(255),CATALOG_TITLE varchar(255),INSTR_TYPE varchar(255),DAYS varchar(255), START_TIME varchar(255),END_TIME varchar(255), ROOM_CAP varchar (255))";
    $con->query($sqlW3);    
    $sqlF4 = "CREATE TABLE IF NOT EXISTS PassF(id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,LID int(11),CRSE varchar(255),SUBJ varchar(255),SEQ varchar(255),CATALOG_TITLE varchar(255),INSTR_TYPE varchar(255),DAYS varchar(255), START_TIME varchar(255),END_TIME varchar(255), ROOM_CAP varchar (255))";
    $con->query($sqlF4);
    $sqlW4 = "CREATE TABLE IF NOT EXISTS PassW(id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,LID int(11),CRSE varchar(255),SUBJ varchar(255),SEQ varchar(255),CATALOG_TITLE varchar(255),INSTR_TYPE varchar(255),DAYS varchar(255), START_TIME varchar(255),END_TIME varchar(255), ROOM_CAP varchar (255))";
    $con->query($sqlW4);

    // inserts courses into lectures, labs, tutorials, and pass sessions for fall
    $result = mysqli_query($con,"SELECT * FROM Fall");   
    while ($row = mysqli_fetch_array($result)){
        $CRSE = $row['CRSE'];
        $SUBJ = $row['SUBJ'];  
        $SEQ = $row['SEQ']; 
        $CATALOG_TITLE= $row['CATALOG_TITLE'];
        $INSTR_TYPE = $row['INSTR_TYPE'];
        $DAYS = $row['DAYS'];
        $START_TIME = $row['START_TIME'];
        $END_TIME = $row['END_TIME'];
        $ROOM_CAP = $row['ROOM_CAP'];
        $ID=$row['id'];

        if($INSTR_TYPE == "LEC"){
            $sql = "INSERT INTO LecturesF(id,CRSE,SUBJ,SEQ,CATALOG_TITLE,INSTR_TYPE,DAYS,START_TIME,END_TIME,ROOM_CAP) VALUES ('$ID','$CRSE','$SUBJ','$SEQ','$CATALOG_TITLE','$INSTR_TYPE','$DAYS','$START_TIME','$END_TIME','$ROOM_CAP')";            	
            $con->query($sql);
            $LID=$row['id'];
        }
        if($INSTR_TYPE == "LAB"){
            $sql = "INSERT INTO LabF(LID,CRSE,SUBJ,SEQ,CATALOG_TITLE,INSTR_TYPE,DAYS,START_TIME,END_TIME,ROOM_CAP) VALUES ('$LID','$CRSE','$SUBJ','$SEQ','$CATALOG_TITLE','$INSTR_TYPE','$DAYS','$START_TIME','$END_TIME','$ROOM_CAP')";             
            $con->query($sql);
        }
        if($INSTR_TYPE == "TUT" ){
            $sql = "INSERT INTO TutorialF(LID,CRSE,SUBJ,SEQ,CATALOG_TITLE,INSTR_TYPE,DAYS,START_TIME,END_TIME,ROOM_CAP) VALUES ('$LID','$CRSE','$SUBJ','$SEQ','$CATALOG_TITLE','$INSTR_TYPE','$DAYS','$START_TIME','$END_TIME','$ROOM_CAP')";             
            $con->query($sql);
        }
        if($INSTR_TYPE == "PAS" ){
            $sql = "INSERT INTO PassF(LID,CRSE,SUBJ,SEQ,CATALOG_TITLE,INSTR_TYPE,DAYS,START_TIME,END_TIME,ROOM_CAP) VALUES ('$LID','$CRSE','$SUBJ','$SEQ','$CATALOG_TITLE','$INSTR_TYPE','$DAYS','$START_TIME','$END_TIME','$ROOM_CAP')";             
            $con->query($sql);
        }
        
    }
    // inserts courses into lectures, labs, tutorials, and pass sessions for winter
    $result = mysqli_query($con,"SELECT * FROM Winter");   
    while ($row = mysqli_fetch_array($result)){
        $CRSE = $row['CRSE'];
        $SUBJ = $row['SUBJ'];  
        $SEQ = $row['SEQ']; 
        $CATALOG_TITLE= $row['CATALOG_TITLE'];
        $INSTR_TYPE = $row['INSTR_TYPE'];
        $DAYS = $row['DAYS'];
        $START_TIME = $row['START_TIME'];
        $END_TIME = $row['END_TIME'];
        $ROOM_CAP = $row['ROOM_CAP'];
        $ID=$row['id'];
        
        if($INSTR_TYPE == "LEC"){
            $sql = "INSERT INTO LecturesW(id,CRSE,SUBJ,SEQ,CATALOG_TITLE,INSTR_TYPE,DAYS,START_TIME,END_TIME,ROOM_CAP) VALUES ('$ID','$CRSE','$SUBJ','$SEQ','$CATALOG_TITLE','$INSTR_TYPE','$DAYS','$START_TIME','$END_TIME','$ROOM_CAP')";              
            $con->query($sql);
            $LID = $ID;
        }
        if($INSTR_TYPE == "LAB"){
            $sql = "INSERT INTO LabW(LID,CRSE,SUBJ,SEQ,CATALOG_TITLE,INSTR_TYPE,DAYS,START_TIME,END_TIME,ROOM_CAP) VALUES ('$LID','$CRSE','$SUBJ','$SEQ','$CATALOG_TITLE','$INSTR_TYPE','$DAYS','$START_TIME','$END_TIME','$ROOM_CAP')";             
            $con->query($sql);
        }
        if($INSTR_TYPE == "TUT" ){
            $sql = "INSERT INTO TutorialW(LID,CRSE,SUBJ,SEQ,CATALOG_TITLE,INSTR_TYPE,DAYS,START_TIME,END_TIME,ROOM_CAP) VALUES ('$LID','$CRSE','$SUBJ','$SEQ','$CATALOG_TITLE','$INSTR_TYPE','$DAYS','$START_TIME','$END_TIME','$ROOM_CAP')";             
            $con->query($sql);
        }
        if($INSTR_TYPE == "PAS" ){
            $sql = "INSERT INTO PassW(LID,CRSE,SUBJ,SEQ,CATALOG_TITLE,INSTR_TYPE,DAYS,START_TIME,END_TIME,ROOM_CAP) VALUES ('$LID','$CRSE','$SUBJ','$SEQ','$CATALOG_TITLE','$INSTR_TYPE','$DAYS','$START_TIME','$END_TIME','$ROOM_CAP')";             
            $con->query($sql);
        }
    }
    // determines if the lab is shared between all lectures, and gives each lecture its own labs.
    $result = mysqli_query($con,"SELECT * FROM LabW");  
    while ($row = mysqli_fetch_array($result)){
        $CRSE = $row['CRSE'];
        $SUBJ = $row['SUBJ'];  
        $SEQ = $row['SEQ']; 
        $CATALOG_TITLE= $row['CATALOG_TITLE'];
        $INSTR_TYPE = $row['INSTR_TYPE'];
        $DAYS = $row['DAYS'];
        $START_TIME = $row['START_TIME'];
        $END_TIME = $row['END_TIME'];
        $ROOM_CAP = $row['ROOM_CAP'];
        $LID=$row['LID'];
        $S = substr($SEQ,0,1);
        if($S == 'L' || $S == 'l'){
            $KHARA = mysqli_query($con,"SELECT * FROM LecturesW WHERE SUBJ = '$SUBJ' AND CRSE = '$CRSE'"); 

            while ($rowL = mysqli_fetch_array($KHARA)){
                $ID=$rowL['id'];
                $sql = "INSERT INTO LabW(LID,CRSE,SUBJ,SEQ,CATALOG_TITLE,INSTR_TYPE,DAYS,START_TIME,END_TIME,ROOM_CAP) VALUES ('$ID','$CRSE','$SUBJ','$SEQ','$CATALOG_TITLE','$INSTR_TYPE','$DAYS','$START_TIME','$END_TIME','$ROOM_CAP')";              
                $con->query($sql);
            }
        }
    }
    $result = mysqli_query($con,"SELECT * FROM LabF");  
    while ($row = mysqli_fetch_array($result)){
        $CRSE = $row['CRSE'];
        $SUBJ = $row['SUBJ'];  
        $SEQ = $row['SEQ']; 
        $CATALOG_TITLE= $row['CATALOG_TITLE'];
        $INSTR_TYPE = $row['INSTR_TYPE'];
        $DAYS = $row['DAYS'];
        $START_TIME = $row['START_TIME'];
        $END_TIME = $row['END_TIME'];
        $ROOM_CAP = $row['ROOM_CAP'];
        $LID=$row['LID'];
        $S = substr($SEQ,0,1);
        if($S == 'L' || $S == 'l'){
            $KHARA = mysqli_query($con,"SELECT * FROM LecturesF WHERE SUBJ = '$SUBJ' AND CRSE = '$CRSE'"); 

            while ($rowL = mysqli_fetch_array($KHARA)){
                $ID=$rowL['id'];
                $sql = "INSERT INTO LabF(LID,CRSE,SUBJ,SEQ,CATALOG_TITLE,INSTR_TYPE,DAYS,START_TIME,END_TIME,ROOM_CAP) VALUES ('$ID','$CRSE','$SUBJ','$SEQ','$CATALOG_TITLE','$INSTR_TYPE','$DAYS','$START_TIME','$END_TIME','$ROOM_CAP')";              
                $con->query($sql);
            }
        }
    }
    // takes the courses for communcation engineering
    $result = mysqli_query($con,"SELECT * FROM Communications");
    while($row = mysqli_fetch_array($result)) {
        $course = $row['Courses'];
        $Courses[] = $course; 
    }
    $CoursesF1 = explode(";",$Courses[0]);
    $CoursesW1 = explode(";",$Courses[1]);
    $CoursesF2 = explode(";",$Courses[2]);
    $CoursesW2 = explode(";",$Courses[3]);
    $CoursesF3 = explode(";",$Courses[4]);
    $CoursesW3 = explode(";",$Courses[5]);
    $CoursesF4 = explode(";",$Courses[6]);
    $CoursesW4 = explode(";",$Courses[7]);

    // determines which courses are selected
    $k=0;
    $NUM[$k] = array();
    for($i=0;$i<5;$i++){
        if(isset($_GET['F1'.$i])){
            $fall = true;
            $RegisterCourse[$k] = $CoursesF1[$i];
            $CRS = substr($RegisterCourse[$k],0,4);
            $NUM[$k] = substr($RegisterCourse[$k],4,4);
            $sql = "UPDATE LecturesF SET YEAR = 1 , APPEAR = 1 WHERE SUBJ = '$CRS' AND CRSE = '$NUM[$k]'";             
            mysqli_query($con, $sql);
            $k++;
        }
    }
    for($i=0;$i<6;$i++){
        if(isset($_GET['F2'.$i])){
            $fall = true;
            $RegisterCourse[$k] = $CoursesF2[$i];
            $CRS = substr($RegisterCourse[$k],0,4);
            $NUM[$k] = substr($RegisterCourse[$k],4,4);
            $sql = "UPDATE LecturesF SET YEAR = 2 , APPEAR = 1 WHERE (SUBJ = '$CRS' and CRSE = '$NUM[$k]')";     
            mysqli_query($con, $sql);
            $k++;
        }
    }
    for($i=0;$i<5;$i++){
        if(isset($_GET['F3'.$i])){
            
            $fall = true;
            $RegisterCourse[$k] = $CoursesF3[$i];
            $CRS = substr($RegisterCourse[$k],0,4);
            $NUM[$k] = substr($RegisterCourse[$k],4,4);
            $sql = "UPDATE LecturesF SET YEAR = 3 , APPEAR = 1 WHERE (SUBJ = '$CRS' and CRSE = '$NUM[$k]')";             
            mysqli_query($con, $sql);
            $k++;
        }
    }
    for($i=0;$i<6;$i++){
        if(isset($_GET['F4'.$i])){
            $fall = true;

            $RegisterCourse[$k] = $CoursesF4[$i];
            $CRS = substr($RegisterCourse[$k],0,4);
            $NUM[$k] = substr($RegisterCourse[$k],4,4);
            $sql = "UPDATE LecturesF SET YEAR = 4 , APPEAR = 1 WHERE (SUBJ = '$CRS' and CRSE = '$NUM[$k]')";             
            mysqli_query($con, $sql);
            $k++;
        }
    }
    for($i=0;$i<5;$i++){
        if(isset($_GET['W1'.$i])){
            $winter = true;
            $RegisterCourse[$k] = $CoursesW1[$i];
            $CRS = substr($RegisterCourse[$k],0,4);
            $NUM[$k] = substr($RegisterCourse[$k],4,4);
            $sql = "UPDATE LecturesW SET YEAR = 1 , APPEAR = 1 WHERE (SUBJ = '$CRS' and CRSE = '$NUM[$k]')";             
            mysqli_query($con, $sql);
            $k++;
        }
    }
    for($i=0;$i<5;$i++){
        if(isset($_GET['W2'.$i])){
            $winter = true;
            $RegisterCourse[$k] = $CoursesW2[$i];
            $CRS = substr($RegisterCourse[$k],0,4);
            $NUM[$k] = substr($RegisterCourse[$k],4,4);
            $sql = "UPDATE LecturesW SET YEAR = 2 , APPEAR = 1 WHERE (SUBJ = '$CRS' and CRSE = '$NUM[$k]')";             
            mysqli_query($con, $sql);
            $k++;
        }
    }
    for($i=0;$i<5;$i++){
        if(isset($_GET['W3'.$i])){
            $winter = true;
            $RegisterCourse[$k] = $CoursesW3[$i];
            $CRS = substr($RegisterCourse[$k],0,4);
            $NUM[$k] = substr($RegisterCourse[$k],4,4);
            $sql = "UPDATE LecturesW SET YEAR = 3 , APPEAR = 1 WHERE (SUBJ = '$CRS' and CRSE = '$NUM[$k]')";             
            mysqli_query($con, $sql);
            $k++;
        }
    }

    for($i=0;$i<6;$i++){
        if(isset($_GET['W4'.$i])){
            $winter = true;
            $RegisterCourse[$k] = $CoursesW4[$i];
            $CRS = substr($RegisterCourse[$k],0,4);
            $NUM[$k] = substr($RegisterCourse[$k],4,4);
            $sql = "UPDATE LecturesW SET YEAR = 4 , APPEAR = 1 WHERE (SUBJ = '$CRS' and CRSE = '$NUM[$k]')";             
            mysqli_query($con, $sql);
            $k++;
        }
    }
    // creates tables for selected courses
    

		$x = count($NUM);
		
		if($fall==true){
		include ('fallschedule.php');
        
		include ('fallschedule.php');
		}
		
		if($winter==true){
        include ('winterschedule.php');
		
        include ('winterschedule.php');
        }
		$sql = "DROP TABLE LecturesF";
		$con->query($sql); 
		$sql = "DROP TABLE Lecturesw";
		$con->query($sql); 			
		$sql = "DROP TABLE LabW";
		$con->query($sql); 		
		$sql = "DROP TABLE LabF";
		$con->query($sql); 		
		$sql = "DROP TABLE TutorialW";
		$con->query($sql); 		
		$sql = "DROP TABLE TutorialF";
		$con->query($sql);  
        echo "</table>";
		

    
		
?>