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
	
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1" /> 
<title>Contacts</title>
<script src="JavaScript/jquery.js"></script>
<script type="text/javascript" src="http://www.skypeassets.com/i/scom/js/skype-uri.js"></script>
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
<table class="center">
	<colgroup>
    <col width="130">
    </colgroup>
<tr><td><button class="btn1"  onclick="window.open('newgroup.php','_self');">New Group</button></td></tr>
<tr><td><h2>My Contacts:</h2>
<form method="POST" action="cdelete.php">
<?php
$con=mysqli_connect($sql_host, $sql_username, $sql_password,$contact_database);
$sql = "SELECT * FROM $login";
$result = $con->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
echo "<table class=\"center ctable\">";
    while($row = $result->fetch_assoc()) { ?>
<tr><td style="padding:0 45px 0 10px;"><?php echo $row["contacts"]; ?></td>
<td style="padding:0 10px 0 45px;"><input type="image" height="20" width="20" src="style/fail.png" alt="delete" title="Delete contact" name="dcontact" value="<?php echo $row["contacts"]; ?>" onclick="return confirm('Are you sure you want to delete this contact?')"></td>
<td><input type="image" src="style/messages.png" title="Send a message" height="20" width="20" class="messagecontact" name="mcontact" id="mcontact" value="<?php echo $row["contacts"]; ?>")></td>

<?php
$con=mysqli_connect($sql_host, $sql_username, $sql_password,$sql_database);
$sql1 = "SELECT * FROM userslist WHERE login='".$row['contacts']."'";
$result1 = mysqli_query($con, $sql1);
$row1=mysqli_fetch_assoc($result1);
if ($row1['skype'] != '') {
?>
<td><a href="skype:<?php echo $row1['skype']; ?>?call"><img src="style/call.png" alt="Call" title="Call via Skype" style="border:0"></a></td>
<td><a href="skype:<?php echo $row1['skype']; ?>?chat"><img src="style/chat.png" alt="Chat" title="Chat via Skype" style="border:0"></a></td></tr>

<?php
}else{
	echo "</tr>";
	}
$con=mysqli_connect($sql_host, $sql_username, $sql_password,$contact_database);	
    }
    echo "</table>";
} else {
    echo "You have no contacts.";
}
$con->close();
?>
</form>
<form method="POST" action="contactsdb.php" id="addcontact">
<input type="text" class="field1 round" name="contact" id="contact">
<img id="success" src="style/success.png" width="16" height="16"/>
<img id="fail" src="style/fail.png" width="16" height="16"/>
<input type="submit" id="button" class="btn2" value="Add Contact">
</form></td></tr>
<tr><td><h2>Contact Groups:</h2>
<form method="POST" action="gdelete.php"><table class="center ctable">
 <col width="130">
<?php
	$con=mysqli_connect($sql_host, $sql_username, $sql_password,$sql_database);
	$sql = "SELECT * FROM cgroups WHERE user = '$login'";
	$result = $con->query($sql);
	if ($result->num_rows > 0) {
		echo"<tr><td width='300px' style=\"padding:0 45px 0 10px;\" class=\"head\">Group</td><td width='300px' style=\"padding:0 10px 0 45px;\" class=\"head\">Members</td></tr>";
		while($row = $result->fetch_assoc()) { 
			echo "<tr><td style=\"padding:0 45px 0 10px;\">".$row["gname"]."</td><td style=\"padding:0 10px 0 45px;\">".$row["m1"]." ".$row["m2"];
if($row["m3"]!=NULL){echo "-".$row["m3"];} if($row["m4"]!=NULL){echo "-".$row["m4"];} if($row["m5"]!=NULL){echo "-".$row["m5"];}echo "</td>";?>
	<td style="padding:0 10px 0 30px;" width="300px"><input type="image" src="style/fail.png" alt="delete" title="Delete Group" name="dgroup" value="<?php echo $row["gname"]; ?>" onclick="return confirm('Are you sure you want to delete this contact group?')"></td></tr>	
		<?php
		}
	}else{
	echo "You have no contact groups.";	
	}
?>
</form>

</table></td></tr>
</table>
</body>
<script>
    $(function() {   
           $(".messagecontact").click(function() {  
      var member = document.getElementById('mcontact').value;
           $.ajax({
              success: function() { 
              window.location = 'contactmessage.php?member=' + member;
        }
            });
            return false;
         });
  });   

</script>
</html>