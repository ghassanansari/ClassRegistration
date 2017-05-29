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
	
?><!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1" /> 
<title>Todo List</title>
<script src="JavaScript/jquery.js"></script> 
<script type="text/javascript" src="http://www.skypeassets.com/i/scom/js/skype-uri.js">

function myfunction(){
	$("#imageID").attr('src', 'style/success.png');
document.getElementById("image").src= "style/success.png";
}
</script>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="style/styles.css" type="text/css" />
<link href="style/style.css" rel="stylesheet" type="text/css" />

</head>
<body >
<div id="dolphincontainer" 	style="position:absolute;
	top:0px;
	left: 0px;" >
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

<table class="center ctable" style="position:relative; top:100px;">
	<tr><td><button class="btn1"  onclick="window.open('newtodo.php','_self');">New Task</button></td></tr>

	<tr><td><h2>To-do List</h2>
		<form method="POST" Action = "changetodo.php" >

	<?php
	$sql = "SELECT * FROM $login";
	$result = $con->query($sql);
	if ($result->num_rows > 0) {

	    while($row = $result->fetch_assoc()) {
			$todo = $row['todo'];
			$due = $row['due'];
			$id = $row['id'];
						?>
<?php
echo "<div class ='box effect1'>"; 
if($row['done'] == 0){
?>

<input type="radio" onclick="function()" id="prep" name="prep" value="<?php echo $id;?>"> 
<input type="image" src="style/fail.png" alt="change" name="task" value="<?php echo $id; ?>">

<?php
}else{
	?>

<input type="radio" onclick="function()" id="prep" name="prep" value="<?php echo $id;?>"> 
<input type="image" src="style/success.png" alt="change" name="task2" value="<?php echo $id; ?>">
<?php

}
echo $todo." Due on ".$due;
echo "</div>";
}
?>
&nbsp;&nbsp;&nbsp;&nbsp;<button class="del btn2" type="submit">Delete</button>				
<?php
	} else {
	    echo "No Tasks.";
	}
	?>
    	</form>
<?php
	
?>
<script>

	$(function() {   
           $(".del").click(function() {  
           // validate and process form here
           var id;

           if ($("input[name='prep']:checked").length > 0){
               id = $('input:radio[name=prep]:checked').val();
           }
           else{
               alert("No button selected, try again!");
               return false;
           }
           $.ajax({
	            success: function() { 
	            window.location = 'deletetodo.php?id=' + id;
				}
            });
            return false;
         });
	});		

</script>
</body>
</html>

