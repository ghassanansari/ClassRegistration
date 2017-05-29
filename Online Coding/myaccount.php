<?php
	if ( ! isset($_COOKIE['login']) ) {
		echo "Need to log in first";
		header("refresh:2;url=login.html");
		exit;
	}
	$login=$_COOKIE['login'];

require_once('dbs.php');
$con=mysqli_connect($sql_host, $sql_username, $sql_password, $sql_database);

if ( mysqli_connect_errno()){
	echo "Failed to connect ". mysqli_connect_error();
	exit;
}

mysqli_query($con, "CREATE DATABASE IF NOT EXISTS $sql_database");

$sql = "CREATE TABLE IF NOT EXISTS messages(
	id int NOT NULL AUTO_INCREMENT,
	datesent datetime NOT NULL,
	sender VARCHAR(20),
	contact VARCHAR(20),
	subject VARCHAR(50),
	message VARCHAR(765),
	viewed int(3),
	PRIMARY KEY (id)
)";

$con->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS filelock(
	user VARCHAR(255),
	filepath VARCHAR(255),
	dateopened TIMESTAMP,
	PRIMARY KEY (user, filepath)
)";

$con->query($sql);


$sql = "CREATE TABLE IF NOT EXISTS cgroups(
	user VARCHAR(255),
	gname VARCHAR(255),
	m1 VARCHAR(255),
	m2 VARCHAR(255),
	m3 VARCHAR(255),
	m4 VARCHAR(255),
	m5 VARCHAR(255),
	PRIMARY KEY (user, gname)
)";

$con->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS notifications(
	id int NOT NULL AUTO_INCREMENT,
	sender VARCHAR(255),
	receiver VARCHAR(255),
	type VARCHAR(255),
	groupname VARCHAR(255),
	PRIMARY KEY (id)
)";
$con->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS groups(
	id int NOT NULL AUTO_INCREMENT,
	name VARCHAR(255),
	admin VARCHAR(255),
	m1 VARCHAR(255),
	m2 VARCHAR(255),
	m3 VARCHAR(255),
	m4 VARCHAR(255),
	m5 VARCHAR(255),
	PRIMARY KEY (id)
)";
mysqli_query($con, $sql);

	$sql = "CREATE TABLE IF NOT EXISTS groups (
		id int NOT NULL AUTO_INCREMENT,
		name VARCHAR(255),
		admin VARCHAR(255),
		m1 VARCHAR(255),
		m2 VARCHAR(255),
		m3 VARCHAR(255),
		m4 VARCHAR(255),
		m5 VARCHAR(255),
		PRIMARY KEY (id)
	)";
	mysqli_query($con, $sql);

mysqli_close($con);

	$con=mysqli_connect($sql_host, $sql_username, $sql_password);
	
	if ( mysqli_connect_errno()){
		echo "Failed to connect ". mysqli_connect_error();
		exit;
	}
	mysqli_query($con, "CREATE DATABASE IF NOT EXISTS $contact_database");
	$con=mysqli_connect($sql_host, $sql_username, $sql_password, $contact_database);
	$sql = "CREATE TABLE IF NOT EXISTS $login (
		contacts VARCHAR(100),
		status VARCHAR(100),
		PRIMARY KEY (contacts)
	)";
	mysqli_query($con, $sql);

	
	mysqli_query($con, "CREATE DATABASE IF NOT EXISTS $todolist_database");
	$con=mysqli_connect($sql_host, $sql_username, $sql_password, $todolist_database);
	$sql = "CREATE TABLE IF NOT EXISTS $login (
		id int NOT NULL AUTO_INCREMENT,
		todo VARCHAR(100),
		due DATE,
		done int(2),
		PRIMARY KEY (id)
	)";
	mysqli_query($con, $sql);
	
	mysqli_query($con, "CREATE DATABASE IF NOT EXISTS $chat_database");
	$con=mysqli_connect($sql_host, $sql_username, $sql_password, $chat_database);
	

?><!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1" /> 
<link href="style/nav.css" rel="stylesheet" type="text/css" />
<title>My Account</title>
<script> 
</script> 
<link rel="stylesheet" href="style/styles.css" type="text/css" />
<link href="style/style.css" rel="stylesheet" type="text/css" />

</head>
<body class ="center">
<div id="dolphincontainer">
	<div id="out">
		<ul>
			<li><a href="logout.php"><span>Log out</span></a></li>
		</ul>
	</div>
	&nbsp;&nbsp;<b><?php echo $login; ?></b>
</div>

<nav>
  <ul class="top-menu">
    <li><a href="myfiles.php">My Files</a><div class="menu-item" id="home"></div></li>
    <li><a href="contacts.php">Contacts</a><div class="menu-item" id="cataloge"></div></li>
    <li><a href="groups.php">Projects</a><div class="menu-item" id="price"></div></li>
    <li><a href="notifications.php"  style="font-size:18px">Notifications</a><div class="menu-item" id="about"></div></li>
    <li><a href="messages.php">Messages</a><div class="menu-item" id="contact"></div></li>
	<li><a href="todolist.php">To-do List</a><div class="menu-item" id="todo"></div></li>
  </ul>
</nav>
</body>
</html>