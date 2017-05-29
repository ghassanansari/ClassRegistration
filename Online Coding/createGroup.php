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
<title>Create Project</title>
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

$(document).ready(function() {
	$(':checkbox[name=contacts\\[\\]]').change(function(){
	  if (this.checked) {
		$('#groups').fadeOut('slow');
	  }else {
		$('#groups').fadeIn('slow');
	  }                      
	});

	$("input[name=cgroup]:radio").change(function(){
	  if (this.checked) {
		$('#members').fadeOut('slow');
	  }else {
		$('#members').fadeIn('slow');
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
<form  method="POST" action="groupsdb.php">

	<h3>Project Name:</h3>
	<br/>
	<input type="text" class="field1 round" id = "groupname" name="groupname" >
	<div id="members" class="round">
		<br/><br/>
			<h3>Project Members:</h3>
			<?php
			$sql = "SELECT * FROM $login";
			$result = $con->query($sql);
			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
			?>
			<br/>
			<input type="checkbox" name="contacts[]" value="<?php echo $row["contacts"]; ?>"> 
			<?php
			echo $row["contacts"];
				}
			}else{
					echo "<br>You have no contacts.";
				}
			?>
    </div>
<div id="groups" class="round">
	<br /><h3>Contact Groups:</h3>
<table style="margin-left:0px;">
 <col width="130">
  <col width="180">
<?php
	$con=mysqli_connect($sql_host, $sql_username, $sql_password,$sql_database);
	$sql = "SELECT * FROM cgroups WHERE user = '$login'";
	$result = $con->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) { ?>
			<tr><td><input type="radio" name="cgroup" value="<?php echo $row["gname"]; ?>">
		<?php echo $row["gname"]."</td><td>".$row["m1"]."-".$row["m2"];
if($row["m3"]!=NULL){echo "-".$row["m3"];} if($row["m4"]!=NULL){echo "-".$row["m4"];} if($row["m5"]!=NULL){echo "-".$row["m5"];}echo "</td></tr>";
			
		}
	}else{
	echo "You have no contact groups.";	
	}
?>
</table>
</div>
	<br/><input type="submit" name="login" value="Create Project" class="btn2"/>
</form>
</body>
</html>