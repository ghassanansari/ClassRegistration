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
<title>New message</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="style/styles.css" type="text/css" />
<link href="style/style.css" rel="stylesheet" type="text/css" />
<script src="JavaScript/jquery.js"></script>
<script> 
$(document).ready(function(){
$('#success').hide();
$('#fail').hide();
$('#contact').keyup(contact_check);
});
	
function contact_check(){	
var contact = $('#contact').val();

if(contact == "" || contact.length < 4){
$('#contact').css('border', '3px #CCC solid');
$('#success').hide();
$('#fail').show();
}else{
jQuery.ajax({
   type: "POST",
   url: "check_contact.php",
   data: 'contact='+ contact,
   cache: false,
   success: function(response){
if(response == 0){
	$('#contact').css('border', '3px #C33 solid');	
	$('#success').hide();
	$('#fail').fadeIn();
	}else{
	$('#contact').css('border', '3px #090 solid');
	$('#fail').hide();
	$('#success').fadeIn();
	     }
}
});
}
}
</script> 
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

<form method="POST" action="sendmessage.php" class="message" style="width: 500px">
	<table>
		<tr>
			<td>To</td>
			<td>
 				<input type="text" class="field1 round" name="contact" id="contact" placeholder="Contact name">
				<img id="success" src="style/success.png" width="16" height="16"/>
				<img id="fail" src="style/fail.png" width="16" height="16"/>
			</td>
		</tr>
		<tr>
			<td>Subject</td>
			<td><input type="text" class="field1 round" name="subject" id="subject" placeholder="Subject"></td>
		</tr>
		<tr>
			<td style="vertical-align: text-top;">Message </td>
			<td>
				<textarea id="message" name="message" rows="8" cols="50" class="round" placeholder="Enter your message here"></textarea>
			</td>
		</tr>
		<tr>
			<td>
				<input type="submit" id="button" class="btn2" value="Send ">
			</td>
		</tr>
	</table>

</form>
</body>
</html>