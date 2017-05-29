<?php
require_once('dbs.php');
	$con=mysqli_connect($sql_host, $sql_username, $sql_password);
	
	if ( mysqli_connect_errno()){
		echo "Failed to connect ". mysqli_connect_error();
		exit;
	}
	mysqli_query($con, "CREATE DATABASE IF NOT EXISTS $chat_database");
	$con=mysqli_connect($sql_host, $sql_username, $sql_password, $chat_database);

	
	$groupname = $_GET['groupname'];
//Get the first 10 messages ordered by time
$result = mysqli_query($con,"select * from $groupname order by time desc limit 0,10");
if (!$result) {
    echo "Invalid query:" . mysqli_error($con);
}
$messages = array();
//if (mysql_num_rows($result != 0)){
//Loop and get in an array all the rows until there are not more to get
while($row = $result->fetch_assoc()){
   //Put the messages in divs and then in an array
   $messages[] = "<div class='message'><div class='messagehead'>" . $row['name'] . " - " . date('g:i A M, d Y',$row['time']) . "</div><div class='messagecontent'>" . $row['message'] . "</div></div>";
   //The last posts date
   $old = $row['time'];
}
//Display the messages in an ascending order, so the newest message will be at the bottom
for($i=sizeof($messages)-1;$i>=0;$i--){
   echo $messages[$i];
}
//This is the more important line, this deletes each message older then the 10th message ordered by time, so the table will never have to store more than 10 messages.
mysqli_query($con,"delete from $groupname where time < " . $old);
//}
?>
