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
	$con=mysqli_connect($sql_host, $sql_username, $sql_password,$sql_database);

?><!DOCTYPE html>
<html>
<head>
<title>Notifications</title>
<meta name="viewport" content="width=device-width, initial-scale=1" /> 
<link rel="stylesheet" href="style/styles.css" type="text/css" />
<link href="style/style.css" rel="stylesheet" type="text/css" />

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
<h2>Notifications</h2>
<form action="contact_request.php" method="POST" class="round">
<h3 style = "color:#C64934;">Contact</h3>

<?php
// Check if there are any contact requests
$sql = "SELECT * FROM notifications WHERE receiver = '$login' and type='contact'";
$result = $con->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		
		?>
		<input type="checkbox" name="contactrequest[]" value="<?php echo $row["id"]; ?>">
		<?php
		echo $row["sender"]." would like to add you to his contact list.<br>";
    }
	?>
	<br><input type="submit" name="accept" class="btn2" value="ACCEPT">
<input type="submit" name="reject" class="btn2" value="REJECT">
	<?php
} else {
	echo "You have no contact notifications.<br>";
}
?>
</form>

<form action="group_request.php" method="POST" class="round">
	<h3 style = "color:#C64934;">Group </h3>

<?php
// Check if there are any group requests
$sql = "SELECT * FROM notifications WHERE receiver = '$login' and type='group'";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
		?>
		<input type="checkbox" name="grouprequest[]" value="<?php echo $row["id"]; ?>">
		<?php
		echo $row["sender"]." would like to add you to his group : '".$row["groupname"]."' </br>";
    }
	?>
	<br><input type="submit" name="accept" class="btn2" value="ACCEPT">
	<input type="submit" name="reject" class="btn2" value="REJECT">
	<?php
} else {
	echo "You have no group notifications<br>";
}
?>
</form>
</body>
</html>