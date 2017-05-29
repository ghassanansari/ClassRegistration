<html>
	<header>
		<style>
			table {
			    width:80%;
			}
			table, td {
				text-align: center;
				font-weight: bold;
			    border: 1px solid black;
			    border-collapse: collapse;
			}
			th, td {
			    padding: 5px;
			   
			}
			table#t01 tr:nth-child(even) {
			    background-color: #eee;
			}
			table#t01 tr:nth-child(odd) {
			   background-color:#fff;
			}
			table#t01 th	{
			    background-color: #A80000;
			    color: white;
			}
		</style>
	</head>
</html>
<?php
	error_reporting( 0 );
    require_once('db.php');
	$con=mysqli_connect($sql_host, $sql_username, $sql_password, $sql_database);
	
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    $z=0;
    $rowz = array();
    echo "<br/>";
	echo"<h1>Fall Schedule:</h1>";

    while(conflict == true){
        $conflict = 0;
        $sql = "DROP TABLE Timetable";
        $con->query($sql); 
        $sqlT = "CREATE TABLE IF NOT EXISTS Timetable(id int(11),SUBJ varchar(255),CRSE varchar(255),SEQ varchar(255),INSTR_TYPE varchar(255),DAYS varchar(255), START_TIME varchar(255),END_TIME varchar(255))";
        $con->query($sqlT);
        $Lectures = array();
        $Tutorials = array();
        $Labs = array();
        $Course = array();
        $var1=array();
        $var2=array();
        $var3=array();
        $var4=array();

        for($k=0;$k<$x;$k++){
        $i=0;
        $tut =false;
        $lab = false;
        $result = mysqli_query($con,"SELECT * FROM LecturesF WHERE APPEAR = 1 AND CRSE='$NUM[$k]'");
        while($row = mysqli_fetch_array($result)){
            $LID=$row['id']."<br/>";
            $SEQ = $row['SEQ'];
            $DAYS = $row['DAYS'];
            $START_TIME = $row['START_TIME'];
            $END_TIME = $row['END_TIME'];
            $CRSE = $row['CRSE'];
            $SUBJ = $row['SUBJ']; 
            $Lectures[$i] = $LID;
            $i++;
        }

        $LID = $Lectures[array_rand($Lectures)];
        $result = mysqli_query($con,"SELECT * FROM LecturesF WHERE id = '$LID'");
        $row = mysqli_fetch_array($result);
        $LID=$row['id']."<br/>";
        $SEQ = $row['SEQ'];
        $DAYS = $row['DAYS'];
        $START_TIME = $row['START_TIME'];
        $INSTR_TYPE = $row['INSTR_TYPE'];
        $END_TIME = $row['END_TIME'];
        $CRSE = $row['CRSE'];
        $SUBJ = $row['SUBJ'];
        $DAYS1 = substr($DAYS,0,1);
        $DAYS2 = substr($DAYS,1,1);

        $var1[$k][0]=$LID;
        $var1[$k][1]=$SUBJ;
        $var1[$k][2]=$CRSE;
        $var1[$k][3]=$SEQ;
        $var1[$k][4]=$INSTR_TYPE;
        $var1[$k][5]=$DAYS1;

        if (strlen($START_TIME) == 4){
            $h=substr($START_TIME,0,2);
            $m=substr($START_TIME,2,2);
        }    
        if (strlen($START_TIME) == 3){
            $h=substr($START_TIME,0,1);
            $m=substr($START_TIME,1,2);
        }

        $START_TIME = $h.":".$m;
        $var1[$k][6]=$START_TIME;   

        if (strlen($END_TIME) == 4){
            $h=substr($END_TIME,0,2);
            $m=substr($END_TIME,2,2);
        }     
        if (strlen($END_TIME) == 3){
            $h=substr($END_TIME,0,1);
            $m=substr($END_TIME,1,2);
        }

        $END_TIME = $h.":".$m;

        $var1[$k][7]=$END_TIME;
        $sql = "INSERT INTO Timetable(id,SUBJ,CRSE,SEQ,INSTR_TYPE,DAYS,START_TIME,END_TIME) VALUES ('$LID','$SUBJ','$CRSE','$SEQ','$INSTR_TYPE','$DAYS1','$START_TIME','$END_TIME')";              
        $con->query($sql);
        $sql = "INSERT INTO Timetable(id,SUBJ,CRSE,SEQ,INSTR_TYPE,DAYS,START_TIME,END_TIME) VALUES ('$LID','$SUBJ','$CRSE','$SEQ','$INSTR_TYPE','$DAYS2','$START_TIME','$END_TIME')";              
        $con->query($sql);

        $var2[$k][0]=$LID;    
        $var2[$k][1]=$SUBJ;
        $var2[$k][2]=$CRSE;
        $var2[$k][3]=$SEQ;
        $var2[$k][4]=$INSTR_TYPE;
        $var2[$k][5]=$DAYS1;
        $var2[$k][6]=$START_TIME;
        $var2[$k][7]=$END_TIME;

        $result_1 = mysqli_query($con,"SELECT * FROM LabF WHERE LID = '$LID'");    
        while($row_1 = mysqli_fetch_array($result_1)){
            $ID=$row_1['id']."<br/>";
            $SEQ = $row_1['SEQ'];
            $DAYS = $row_1['DAYS'];
            $START_TIME = $row_1['START_TIME'];
            $END_TIME = $row_1['END_TIME'];
            $CRSE = $row_1['CRSE'];
            $SUBJ = $row_1['SUBJ']; 
            $Labs[$i] = $ID;
            $i++;
            $lab = true;
        }
        $i=0;
        if($lab == true){
            $ID = $Labs[array_rand($Labs)];
            $result_1 = mysqli_query($con,"SELECT * FROM LabF WHERE ID = '$ID'");
            $row_1 = mysqli_fetch_array($result_1);
            $SUBJ = $row_1['SUBJ'];
            $CRSE = $row_1['CRSE'];
            $INSTR_TYPE = $row_1['INSTR_TYPE'];
            $SEQ = $row_1['SEQ'];
            $DAYS = $row_1['DAYS'];
            $START_TIME = $row_1['START_TIME'];
            $END_TIME = $row_1['END_TIME'];
            $id_1 = $row_1['id'];
            
            $var3[$k][0]=$id_1;
            $var3[$k][1]=$SUBJ;
            $var3[$k][2]=$CRSE;
            $var3[$k][3]=$SEQ;
            $var3[$k][4]=$INSTR_TYPE;
            $var3[$k][5]=$DAYS;
            if (strlen($START_TIME) == 4){
                $h=substr($START_TIME,0,2);
                $m=substr($START_TIME,2,2);
            }  
            if (strlen($START_TIME) == 3){
                $h=substr($START_TIME,0,1);
                $m=substr($START_TIME,1,2);
            }
      
            $START_TIME = $h.":".$m;
            $var3[$k][6]=$START_TIME;
            if (strlen($END_TIME) == 4){
                $h=substr($END_TIME,0,2);
                $m=substr($END_TIME,2,2);
            }    
            if (strlen($END_TIME) == 3){
                $h=substr($END_TIME,0,1);
                $m=substr($END_TIME,1,2);
            }

        $END_TIME = $h.":".$m;
            $var3[$k][7]=$END_TIME;

        $sql = "INSERT INTO Timetable(id,SUBJ,CRSE,SEQ,INSTR_TYPE,DAYS,START_TIME,END_TIME) VALUES ('$id_1','$SUBJ','$CRSE','$SEQ','$INSTR_TYPE','$DAYS','$START_TIME','$END_TIME')";              
        $con->query($sql);
        }
        $i=0;
        $result_2 = mysqli_query($con,"SELECT * FROM TutorialF WHERE LID = '$LID'");    
        while($row_2 = mysqli_fetch_array($result_2)){
            $ID=$row_2['id']."<br/>";
            $SEQ = $row_2['SEQ'];
            $DAYS = $row_2['DAYS'];
            $START_TIME = $row_2['START_TIME'];
            $END_TIME = $row_2['END_TIME'];
            $CRSE = $row_2['CRSE'];
            $SUBJ = $row_2['SUBJ']; 
            $Tutorials[$i] = $ID;
            $tut = true;
            $i++;
        }
        if($tut ==true){
            $TID = $Tutorials[array_rand($Tutorials)];
            $result_2 = mysqli_query($con,"SELECT * FROM TutorialF WHERE ID = '$TID'");
            $row_2 = mysqli_fetch_array($result_2);
            $SUBJ = $row_2['SUBJ'];
            $CRSE = $row_2['CRSE'];
            $INSTR_TYPE = $row_2['INSTR_TYPE'];
            $SEQ = $row_2['SEQ'];
            $DAYS = $row_2['DAYS']; 
            $END_TIME = $row_2['END_TIME'];

            $id_2 = $row_2['id'];
            
            $var4[$k][0]=$id_2;
            $var4[$k][1]=$SUBJ;
            $var4[$k][2]=$CRSE;
            $var4[$k][3]=$SEQ;
            $var4[$k][4]=$INSTR_TYPE;
            $var4[$k][5]=$DAYS;
			
            if (strlen($START_TIME) == 3){
                $h=substr($START_TIME,0,1);
                $m=substr($START_TIME,1,2);
            }
            if (strlen($START_TIME) == 4){
                $h=substr($START_TIME,0,2);
                $m=substr($START_TIME,2,2);
            }   
            $START_TIME = $h.":".$m;

            $var4[$k][6]=$START_TIME;
            if (strlen($END_TIME) == 3){
                $h=substr($END_TIME,0,1);
                $m=substr($END_TIME,1,2);
            }
            if (strlen($END_TIME) == 4){
                $h=substr($END_TIME,0,2);
                $m=substr($END_TIME,2,2);
            }    
            $END_TIME = $h.":".$m;

            $var4[$k][7]=$END_TIME;
            $sql = "INSERT INTO Timetable(id,SUBJ,CRSE,SEQ,INSTR_TYPE,DAYS,START_TIME,END_TIME) VALUES ('$id_2','$SUBJ','$CRSE','$SEQ','$INSTR_TYPE','$DAYS','$START_TIME','$END_TIME')";              
			$con->query($sql);

        }

        unset($Lectures);
        unset($Labs);
        unset($Tutorials);
        $Lectures = array();
        $Labs = array();
        $Tutorials = array();
        }
        $start = array();
        $end = array();
        $days=array("M","T","W","R","F");
        for($i=0;$i<5;$i++){
            $k=0;
            $result = mysqli_query($con,"SELECT * FROM Timetable WHERE DAYS = '$days[$i]' ");
            while($row = mysqli_fetch_array($result)){

                $DAYS = $row['DAYS'];
                $start[$k] = $row['START_TIME'];
                $end[$k] = $row['END_TIME'];
                $start[$k] = str_replace(":","",$start[$k]);
                $end[$k] = str_replace(":","",$end[$k]);
                for ($l=0;$l<$k;$l++){
                    if ($l!=$k){
                        if ($start[$k] > $end[$l] || $end[$k]< $start[$l]){
                        }
                        else{
                            $conflict = 1;
                            break;                            
                        }                       
                    }   
                }
                $k++;
                if ($conflict == 1) {
                    break;
                }
            }
            if ($conflict == 1) {
                break;
            }
        }

        if ($conflict == 1) {
            $sql = "DROP TABLE Timetable";
            $con->query($sql); 
            
           continue;
        } 
        echo "<table id=\"t01\">";
        echo "<tr><th>ID</th><th>SUBJ</th><th>CRSE</th><th>SEQ</th><th>TYPE</th><th>DAYS<th>START TIME</th><th>END TIME</th></tr>";

        $result = mysqli_query($con,"SELECT * FROM Timetable");
        while($row = mysqli_fetch_array($result)){
			$id= $row['id'];
            $SEQ = $row['SEQ'];
            $INSTR_TYPE = $row['INSTR_TYPE'];
            $DAYS = $row['DAYS'];
            $START_TIME = $row['START_TIME'];
            $END_TIME = $row['END_TIME'];
            $CRSE = $row['CRSE'];
            $SUBJ = $row['SUBJ']; 

            echo "<tr><td>".$id."</td><td>".$SUBJ."</td><td>".$CRSE."</td><td>".$SEQ."</td><td>".$INSTR_TYPE."</td><td>".$DAYS."</td><td>".$START_TIME."</td><td>".$END_TIME."</td></tr>";

        }

        echo "</table>";

        break;

    }  

    

?>
