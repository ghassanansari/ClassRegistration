<?php
	if ( ! isset($_COOKIE['login']) ) {
		echo "Need to log in first";
		header("refresh:2;url=login.html");
		exit;
	}
	$login=$_COOKIE['login'];
	require_once('dbs.php');
	$con=mysqli_connect($sql_host, $sql_username, $sql_password);
	
	if ( mysqli_connect_errno()){
		echo "Failed to connect ". mysqli_connect_error();
		exit;
	}
	mysqli_query($con, "CREATE DATABASE IF NOT EXISTS $sql_database");
	$con=mysqli_connect($sql_host, $sql_username, $sql_password, $sql_database);
	
	/*  CLEAN LOCKS TABLE */
	$unlock = mysqli_query($con,"DELETE FROM filelock WHERE dateopened < (NOW() - INTERVAL 30 MINUTE");
	/*	-------------------	*/
?><!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1" /> 
<title>My Projects</title>
<script src="JavaScript/jquery.js"></script> 
<link rel="stylesheet" href="style/styles.css" type="text/css" />
<link href="style/style.css" rel="stylesheet" type="text/css" />
<script>
function validateForm() {
    var radios = document.getElementsByName("groupid");
    var formValid = false;

    var i = 0;
    while (!formValid && i < radios.length) {
        if (radios[i].checked) formValid = true;
        i++;        
    }

    if (!formValid) alert("No project selected!");
    return formValid;
}
</script>
</head>
<body class ="center">
<div id="dolphincontainer">
	<div id="dolphinnav">
		<ul>
			<li><a href="myaccount.php"><span>My Account</span></a></li>
			<li><a href="myfiles.php"><span>My Files</span></a></li>
			<li><a href="contacts.php"><span>My Contacts</span></a></li>
			<li><a href="groups.php"><span>My Projects</span></a></li>
			<li><a href="notifications.php"><span>Notifications</span></a></li>
			<li><a href="messages.php"><span>Messages</span></a></li>
			<li><a href="todolist.php"><span>Todo List</span></a></li>
			<li><a href="logout.php"><span>Log out</span></a></li>
		</ul>
	</div>
</div>
<table class="center">
<tr><td><button class="btn1"  onclick="window.open('createGroup.php','_blank');">New Project</button></td></tr>
<tr><td><h2>My Projects:</h2>
<div  id="myfiles" class="round">
<form name="groups" id="uploadform" action="groupfiles.php" method="POST" onsubmit="return validateForm()">
<?php

$sql = "SELECT * FROM groups WHERE admin='$login' or m1='$login' or m2='$login' or m3='$login' or m4='$login' or m5='$login'";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		
		?>
		<input type="radio" name="groupid" value="<?php echo $row["id"]; ?>">
		<?php
		echo $row["name"]."<br>";
    }
	?>
	</div>
	<div style="text-align:center;">
	<input type="submit" name="load" value="Load" class="btn2">
	<input type="submit" name="delete" value="Delete" class="btn2">
	<?php
} else {
	echo "You have no projects.<br></div>";
}
?>
</div>
</form></td></tr>
</table>
</body>
</html>