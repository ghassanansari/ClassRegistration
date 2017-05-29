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
	
?><!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1" /> 
<title>Messages</title>
<script src="JavaScript/jquery.js"></script> 
<script type="text/javascript" src="http://www.skypeassets.com/i/scom/js/skype-uri.js"></script>

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
	<tr><td><button class="btn1"  onclick="window.open('newmessage.php','_blank');">New Message</button></td></tr>

	<tr><td><h2>My Messages:</h2>
		<form>

	<?php
	$sql = "SELECT * FROM messages WHERE contact = '$login'";
	$result = $con->query($sql);
	if ($result->num_rows > 0) {


	    while($row = $result->fetch_assoc()) {
			$sender = $row['sender'];
			$subject = $row['subject'];
			$message = $row['message'];
			$viewed = $row['viewed'];
			$id = $row['id'];
				if($viewed == 1){
						?>

			<div class ='box effect1'> 
						<input type="radio" onclick="function()" id="prep" name="prep" value="<?php echo $id;?>"> 
							<?php 

							echo "<font style='color: navy;'> ".$row['sender']."</font>";
							echo "<font style='color: black;'>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$row['subject']."</font>";
							?>

				</div>
				<?php
				}
				else 
				{
					?>
			<div class ='box effect1'> 
				<input type="radio" onclick="function()" id="prep" name="prep" value="<?php echo $id;?>"> 
					<?php 

					echo "<font style='color: navy;'> ".$row['sender']."</font>";
					echo "<font style='color: grey;'>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
					.$row['subject']."</font>";
				?>

				</div>

				<?php

	   			}
	   		}

	    	    ?>
	    <br />&nbsp;&nbsp;&nbsp;&nbsp;<button class="View btn2" type="submit">View</button>
	    <button class="del btn2" type="submit" onClick="location.reload(true)">Delete</button>				
		<button class="reply btn2" type="submit">Reply</button>
		<button class="forward btn2" type="submit">Forward</button>

<?php
	} else {
	    echo "You have no messages.";
	}
	$sql = "SELECT * FROM messages WHERE contact = '$login'";
	$result = $con->query($sql);
	if ($result->num_rows > 0) {
	?>

    	</form>
	<form>
	<p id="info1"> Message will be viewed here</p>
	</form>	
<?php
	}
?>
<script>
	$(function() {   
           $(".View").click(function() {  
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
				var request1 = new XMLHttpRequest();
		   		request1.open("POST", "viewmessage.php", false);
		   		request1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		   		request1.send("id=" + id );
		   		var response1 = request1.responseText;
				document.getElementById("info1").innerHTML = response1;               
				}
            });
            return false;
         });
});
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
	            window.location = 'deletemessage.php?id=' + id;
				}
            });
            return false;
         });
	});		
	$(function() {   
           $(".reply").click(function() {  
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
	            window.location = 'replymessage.php?id=' + id;
				}
            });
            return false;
         });
	});		
	$(function() {   
           $(".forward").click(function() {  
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
	            window.location = 'forwardmessage.php?id=' + id;
				}
            });
            return false;
         });
	});	


</script>
</body>
</html>

