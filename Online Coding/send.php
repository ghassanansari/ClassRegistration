<?php
//Connect to MySQL
   if ( ! isset($_COOKIE['login']) ) {
      echo "Need to log in first";
      header("refresh:2;url=login.html");
      exit;
   }
   $login=$_COOKIE['login'];
   $groupname = $_GET['groupname'];

   
   
   require_once('dbs.php');
	$con=mysqli_connect($sql_host, $sql_username, $sql_password);
	
	if ( mysqli_connect_errno()){
		echo "Failed to connect ". mysqli_connect_error();
		exit;
	}
	mysqli_query($con, "CREATE DATABASE IF NOT EXISTS $chat_database");
	$con=mysqli_connect($sql_host, $sql_username, $sql_password, $chat_database);



//Check if message is empty and send the error code
if (isset($_GET['message'])){
$message = mysqli_real_escape_string($con, $_GET['message']);
	if(strlen($message) < 1){
	   echo 3;
	}
	//Check if message is too long
	else if(strlen($message) > 255){
	   echo 4;
	}

}

//Check if name is empty

if(strlen($login) < 1){
   echo 5;
}
//Check if name is too long
else if(strlen($login) > 29){
   echo 6;
}
//Check if the name is used by somebody else
else if(mysqli_num_rows(mysqli_query($con,"select * from $groupname where name = '" . $login . "' and ip != '" . @$REMOTE_ADDR . "'")) != 0){
   echo 7;
}
//If everything is fine
else{
   //This array contains the characters what will be removed from the message and name, because else somebody could send redirection script or links
   $search = array("<",">",">","<");
   //Insert a new row in the chat table
   if (isset($_GET['message'])){

   mysqli_query($con,"insert into $groupname values ('" . time() . "', '" . str_replace($search,"",$login) . "', '" . @$REMOTE_ADDR . "', '" . str_replace($search,"",$message) . "')") or die(8);
	}
}
?>