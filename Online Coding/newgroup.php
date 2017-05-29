<?php
	if ( ! isset($_COOKIE['login']) ) {
		echo "Need to log in first";
		header("refresh:2;url=login.html");
		exit;
	}
	$login=$_COOKIE['login'];
		require_once('dbs.php');	

	$con=mysqli_connect($sql_host, $sql_username, $sql_password, $contact_database);
	
	if ( mysqli_connect_errno()){
		echo "Failed to connect ". mysqli_connect_error();
		exit;
	}
    ?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1" /> 
<title>New Group</title>
<link href="style/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="style/styles.css" type="text/css" />
<script src="JavaScript/jquery.js"></script>
<script> 
var c = 0;
var cmax = 5;
$(document).ready(function() {
    $(':checkbox[name=contacts\\[\\]]').change(function() {
        c = $(':checked').length;
        if (c >= cmax) {
            alert('You have reached maximum group capacity which is ' + cmax + ' members');
            $(':checkbox[name=contacts\\[\\]]').not(':checked').attr('disabled', true);
        } else {
            $(':checkbox[name=contacts\\[\\]]:disabled').attr('disabled', false);
        }
	});
});
</script> 
</head>
<body >
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
</br>
</br>
</br>
<form  method="POST" action="cgroups.php">
	<?php
		$sql = "SELECT * FROM $login";
		$result = $con->query($sql);
		if ($result->num_rows > 0) {
	?>
	<h3>Group Name:</h3>
	<br/>
	<input type="text" class="field1 round" id = "groupname" name="groupname" >
	<div>
		<br/><br/>

			<h3>Group Members:</h3>
			<?php
			    while($row = $result->fetch_assoc()) {
			?>
			<br/>
			<input type="checkbox" name="contacts[]" value="<?php echo $row["contacts"]; ?>"> 
			<?php
			echo $row["contacts"];
				}
				?>
			<br/><br/>
			<input type="submit" name="login" value="Create Group" class="btn2"/>
				
				<?php
			}else{
					echo "<br>You have no contacts.";
				}
			?>
    </div>

			
</form>
</body>
</html>