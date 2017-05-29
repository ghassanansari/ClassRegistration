<?php
	if ( ! isset($_COOKIE['login']) ) {
		echo "Need to log in first";
		header("refresh:2;url=login.html");
		exit;
	}
	$login=$_COOKIE['login'];
		require_once('dbs.php');	

	$con=mysqli_connect($sql_host, $sql_username, $sql_password, $todolist_database);
	
	if ( mysqli_connect_errno()){
		echo "Failed to connect ". mysqli_connect_error();
		exit;
	}
    ?>
<!DOCTYPE html>
<html>
<head>
<title>New Task</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="style/styles.css" type="text/css" />
<link href="style/style.css" rel="stylesheet" type="text/css" />
<script src="JavaScript/jquery.js"></script>
</head>
<body>

<div id="dolphincontainer">
	<div id="dolphinnav">
		<ul>
			<li><a href="myaccount.php"><span>My Account</span></a></li>
			<li><a href="myfiles.php"><span>My Files</span></a></li>
			<li><a href="contacts.php"><span>My Contacts</span></a></li>
			<li><a href="groups.php"><span>My Groups</span></a></li>
			<li><a href="notifications.php"><span>Notifications</span></a></li>
			<li><a href="messages.php"><span>Messages</span></a></li>
			<li><a href="todolist.php"><span>Todo List</span></a></li>
			<li><a href="logout.php"><span>Log out</span></a></li>
		</ul>
	</div>
</div>
</br>
</br>
</br>

<form method="POST" action="sendtodo.php" class="message" style="width:500px">
	<table>
		
		<tr>
			<td style="vertical-align: text-top;">Task </td>
			<td>
				<textarea id="todo" name="todo" rows="8" cols="50" class="round" placeholder="Enter Task Here"></textarea>
			</td>
		</tr>
		<tr>
			<td style="vertical-align: text-top;">Due on </td>
			<td>
				<input type="date" id="due" name="due" class="round" placeholder="Enter Day the Task is Due on"></input>
			</td>
		</tr>
		<tr>
			<td>
				<input type="submit" id="button" class="btn2" value="Send">
			</td>
		</tr>
	</table>

</form>
</body>
</html>