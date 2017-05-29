<?php
	if ( ! isset($_COOKIE['login']) ) {
		echo "Need to log in first";
		header("refresh:2;url=login.html");
		exit;
	}
	$login=$_COOKIE['login'];
	session_start();
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
	if (isset($_GET['id'])){
		$id=$_GET['id'];
		$_SESSION["id"] = $id;
		$sql = mysqli_query($con,"SELECT * FROM groups WHERE id = '$id'");
		$row = $sql->fetch_assoc();
		$admin = $row['admin'];
		$gname = $row['name'];
	}
	if (isset($_POST['groupid'])){
		$id=$_POST['groupid'];
		$_SESSION["id"] = $id;
		$sql = mysqli_query($con,"SELECT * FROM groups WHERE id = '$id'");
		$row = $sql->fetch_assoc();
		$admin = $row['admin'];
		$gname = $row['name'];
	}	




if (isset($_POST['delete'])){
	if($admin==$login){
		$dir    = "./groupfiles/".$admin."/".$gname;
		$it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
		$files = new RecursiveIteratorIterator($it,
					 RecursiveIteratorIterator::CHILD_FIRST);
		foreach($files as $file) {
			if ($file->isDir()){
				rmdir($file->getRealPath());
			} else {
				unlink($file->getRealPath());
			}
		}
		rmdir($dir);
		$sql = "DELETE FROM groups WHERE id = '$id'";
		$con->query($sql);
		header("refresh:1;url=groups.php");
	}else{
		echo "ERROR: Only the creator of the group can delete it!";
		header("refresh:3;url=groups.php");
		die();
	}
}
	
	$con=mysqli_connect($sql_host, $sql_username, $sql_password, $chat_database);
	mysqli_query($con,"create table $gname(
	   time int(11) NOT NULL, 
	   name varchar(30) NOT NULL, 
	   ip varchar(15) NOT NULL, 
	   message nvarchar(255) NOT NULL, 
	   PRIMARY KEY (time)
	)");
	
?><!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1" /> 
<link rel="stylesheet" href="style/css3menu1/style.css" type="text/css" /><style type="text/css">._css3m{display:none}</style>
<title>Project Files</title>
<script src="JavaScript/jquery.js"></script> 
<link rel="stylesheet" href="style/styles.css" type="text/css" />
<link href="style/style.css" rel="stylesheet" type="text/css" />
<style>
h2{
	text-align: left;
}
</style>
<script>
$(document).ready(function(){
$('#success').hide();
$('#fail').hide();
$('#contact').keyup(contact_check);
});
	
$(document).ready(function(){
	$("#uploadform").hide();
    $("#newfile").click(function(){
		var on = $('#uploadform').is(':visible');
        $("#uploadform").slideToggle();
		$('#show').html(on ? '[+]' : '[-]');
    });
    $("#show").click(function(){
		var on = $('#uploadform').is(':visible');
        $("#uploadform").slideToggle();
		$('#show').html(on ? '[+]' : '[-]');
    });
	$( "#delete" ).click(function() {
         location.reload(true);
});
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

$(document).ready(function(){
	$("#member").hide();
    $("#addm").click(function(){
        $("#member").slideToggle();
    });
});

function startUpload(){
      document.getElementById('f1_upload_process').style.visibility = 'visible';
      document.getElementById('f1_upload_form').style.visibility = 'hidden';
      return true;
}

function stopUpload(success){
      var result = '';
      if (success == 1){
         result = '<span class="msg">Successful Upload<\/span><br/><br/>';
		 location.reload();
      }
      else {
         result = '<span class="emsg">Upload Failed<\/span><br/><br/>';
      }
      document.getElementById('f1_upload_process').style.visibility = 'hidden';
      document.getElementById('f1_upload_form').innerHTML = result + '<label><input name="myfile" type="file" size="30" /><\/label><label><br><br><input type="submit" name="submitBtn" class="btn2" value="Upload" /><\/label>';
      document.getElementById('f1_upload_form').style.visibility = 'visible';      
      return true;   
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
<?php	
	$id=$_SESSION["id"];
	$con=mysqli_connect($sql_host, $sql_username, $sql_password, $sql_database);
	$sql = mysqli_query($con,"SELECT * FROM groups WHERE id = '$id'");
	$row = $sql->fetch_assoc();
	?>
<table class="center">
<tr><td>
<table>
<tr><td>
<h2>Group Members</h2>
<form style = "width:295px;" action="groupmemberdelete.php">
	<table>
	<?php if ($login == $admin){ ?>
	<tr><td><a href="#"><img src="style/addmember.png" id="addm" style="width:25px; height:25px;" title="Add member"></a></td></tr>
	<?php } ?>
<?php
	$id=$_SESSION["id"];

	$sql = mysqli_query($con,"SELECT * FROM groups WHERE id = '$id'");
	$row = $sql->fetch_assoc();
		?> 
	</hr>
		<?php
			echo "<tr><td>".$admin."</td>";
			?>
		<td><img src="style/admin.png" id="admin" style="padding:0 0 0 99px;width:25px; height:25px;" title="Admin"></td>
		<td>
			<input type="image" src="style/messages.png" height="20" width="20" class="messagemember" name="mmember" id="mmember" value="<?php echo $row["m1"]; ?>")>
			</td>
		</tr>
		<?php 
	if($row['m1'] != NULL){
				echo "<tr><td>".$row['m1']."</td>";
		if ($login == $admin){
			?><td>
			<input height="20" width="20" type="image" src="style/fail.png" class="delmember" style="padding:0 0 0 99px;" name="dmember" id="dmember" value="<?php echo $row["m1"]; ?>")>
		</td>
		<?php
		}
			?>
		<td>
			<input type="image" src="style/messages.png" height="20" width="20" class="messagemember" name="mmember" id="mmember" value="<?php echo $row["m1"]; ?>")>
			</td>
		</tr>
		<?php
		
	}
	if($row['m2'] != NULL){
				echo "<tr><td>".$row['m2']."</td>";
		if ($login == $admin){
			?><td>
			<input height="20" width="20" type="image" src="style/fail.png" class="delmember" style="padding:0 0 0 99px;" name="dmember" id="dmember" value="<?php echo $row["m2"]; ?>")>
		</td>
		<?php
		}
			?>
		<td>
			<input type="image" src="style/messages.png" height="20" width="20" class="messagemember" name="mmember" id="mmember" value="<?php echo $row["m2"]; ?>")>
			</td>
		</tr>
		<?php
		
	}
	if($row['m3'] != NULL){
				echo "<tr><td>".$row['m3']."</td>";
		if ($login == $admin){
			?><td>
			<input height="20" width="20" type="image" src="style/fail.png" class="delmember" style="padding:0 0 0 99px;" name="dmember" id="dmember" value="<?php echo $row["m3"]; ?>")>
		</td>
		<?php
		}
			?>
		<td>
			<input type="image" src="style/messages.png" height="20" width="20" class="messagemember" name="mmember" id="mmember" value="<?php echo $row["m3"]; ?>")>
			</td>
		</tr>
		<?php
		
	}	
	if($row['m4'] != NULL){
				echo "<tr><td>".$row['m4']."</td>";
		if ($login == $admin){
			?><td>
			<input height="20" width="20" type="image" src="style/fail.png" class="delmember" style="padding:0 0 0 99px;" name="dmember" id="dmember" value="<?php echo $row["m4"]; ?>")>
		</td>
		<?php
		}
			?>
		<td>
			<input type="image" src="style/messages.png" height="20" width="20" class="messagemember" name="mmember" id="mmember" value="<?php echo $row["m4"]; ?>")>
			</td>
		</tr>
		<?php
		
	}
	if($row['m5'] != NULL){
				echo "<tr><td>".$row['m5']."</td>";
		if ($login == $admin){
			?><td>
			<input height="20" width="20" type="image" src="style/fail.png" class="delmember" style="padding:0 0 0 99px;" name="dmember" id="dmember" value="<?php echo $row["m5"]; ?>")>
		</td>
		<?php
		}
			?>
		<td>
			<input type="image" src="style/messages.png" height="20" width="20" class="messagemember" name="mmember" id="mmember" value="<?php echo $row["m5"]; ?>")>
			</td>
		</tr>
		<?php
		
	}
	if($row['m1'] == NULL && $row['m2'] == NULL && $row['m3'] == NULL && $row['m4'] == NULL && $row['m5'] == NULL){
		echo "There are no members in the group";
	}
	?>
</table>

<div id="member" style =  "text-align:center;">
<input type="text" class="field2 round" name="contact" id="contact" >
<img id="success" src="style/success.png" width="16" height="16"/>
<img id="fail" src="style/fail.png" width="16" height="16"/>
<input type="submit" id="button" class="btn2 addmember" value="Invite Contact">
</div>

</form>
</td>
<td style="vertical-align: middle;"><input type="image" src="style/chatg.png" width="120" height="120" alt='chat' title='Group Chat' id='chat' name='chat' value='<?php echo $gname;?>'class="GroupChat"></td></tr>
</table></td></tr>
<tr><td>
<h2>Project Files</h2>
<div  id="myfiles" class="center round">
&nbsp<input type="checkbox" id="css3menu-switcher" class="c3m-switch-input center">
<ul id="css3menu1" class="topmenu">
	<li class="switch"><label onclick="" for="css3menu-switcher"></label></li>
	<li class="toplast"><a href="#" style="width:56px;"><span>New File</span></a>
	<ul>
	<?php 
		if (isset($admin)){
			$_SESSION["admin"] = $admin;
			$_SESSION["gname"] = $gname;
		}else{
			$admin = $_SESSION["admin"];
			$gname = $_SESSION["gname"];
		}
	?>
		<li><a href="html.php?admin=<?php echo $admin;?>&gname=<?php echo $gname;?>" target="_blank">HTML mixed-mode</a></li>
		<li><a href="php.php?admin=<?php echo $admin;?>&gname=<?php echo $gname;?>" target="_blank">PHP/HTML</a></li>
		<li><a href="xml.php?admin=<?php echo $admin;?>&gname=<?php echo $gname;?>" target="_blank">XML</a></li>
		<li><a href="c.php?admin=<?php echo $admin;?>&gname=<?php echo $gname;?>" target="_blank">C/C++</a></li>
		<li><a href="java.php?admin=<?php echo $admin;?>&gname=<?php echo $gname;?>" target="_blank">Java</a></li>
		<li><a href="python.php?admin=<?php echo $admin;?>&gname=<?php echo $gname;?>" target="_blank">Python</a></li>
	</ul></li>
</ul>
<br><br><br>
<table>

<form action="load.php" method="POST">
<?php 
if (isset($admin)){
	$dir    = "./groupfiles/".$admin."/".$gname;
	$_SESSION["dir"] = $dir;
}else{
	$dir = $_SESSION["dir"];
}

if (!is_dir($dir)){
			mkdir($dir,0777,true);
			$file = fopen($dir."/index.html", 'w') or die("can't open file");
			fclose($file);
        }
$files = array_diff(scandir($dir), array('..', '.')); 
if(filesize($dir."/index.html") == 0){
$files = array_diff($files, array('index.html')); 
}
if (!empty($files)) {
foreach($files as $ind_file){ 
?> 
<tr><td><input type="radio" name="files" value="<?php echo $ind_file;?>"></td>
<td><a href="<?php echo $dir."/".$ind_file;?>"><?php echo $ind_file;?></td></tr>
<?php 
} 
?>
</table>
</div>
<div style="text-align:center;">
<input type="hidden" name="gdir" value="<?php echo $dir; ?>">
<br><input class="button" type="submit" value="load">
</form>
<button class="button" id="delete">delete</button>
<?php
}else{
	echo "<br><b>You have no files.</b></table></div></form>";
}
		mysqli_query($con, "CREATE DATABASE IF NOT EXISTS $update_database");
	$con=mysqli_connect($sql_host, $sql_username, $sql_password, $update_database);
	$sql = "CREATE TABLE IF NOT EXISTS $gname (
		id int NOT NULL AUTO_INCREMENT,
		datesent datetime NOT NULL,
		sender VARCHAR(100),
		updates VARCHAR(100),
		PRIMARY KEY (id)
	)";
	mysqli_query($con, $sql);

?>

</div>
</form>
</td></tr>
<tr><td>
	<br><a href="#"><table><tr><td><h3 style="font-weight: bold; font-size:16px;" id="newfile">Upload File</h3></td>
	<td><h3 style="color: white; font-weight: bold; font-size:16px;" id="show">[+]</h3></td></tr></table></a>
<form action="upload.php" method="post" enctype="multipart/form-data" target="upload_target" onsubmit="startUpload();" id="uploadform">
	<p id="f1_upload_process" style="visibility:hidden">Loading...<br/><img src="style/loader.gif" /><br/></p>
	<p id="f1_upload_form"><br/>
	<label> 
				<input name="myfile" type="file" size="30" />
	</label>
	<label>
	<input type="hidden" name="dir" value="<?php echo $dir; ?>">
	<br><br><input type="submit" name="submitBtn" class="btn2" value="Upload" />
	</label>
	</p>
                     
	<iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
</form>
</td></tr>
<tr><td>
<h2>Updates</h2>

<form>
<?php

$con=mysqli_connect($sql_host, $sql_username, $sql_password, $update_database);

$sql = "SELECT * FROM $gname";
$result = $con->query($sql);
if ($result->num_rows > 0) {
echo "<table>";
while($row = $result->fetch_assoc()) {
echo "<div class ='box effect1'>";
echo "<font style='color: navy;'> ".$row['sender']."</font>";
echo "  ".$row['updates'];
echo "</br> <font size = '1'> ".$row['datesent']."</font>";

if($login == $admin || $login == $row['sender']){
?>
<input type="image" src="style/fail.png" alt='delete' title='Delete update' class="deleteupdate" style='position:relative;left:300px;top: 0px;' id='dupdate' name='dupdate' value='<?php echo $row["id"];?>'>
</br>
<?php
}
echo "</div>";
	}
}
	?>

<textarea id="update" name="update" rows="4" cols="67" class="round" placeholder="Enter your update here"></textarea></br>
<button class="update button" type="submit">Send</button>
</table>
</form>
</td></tr>
</table>

<script>
var url = 'group_delete.php';
var dirl='<?php echo $dir; ?>';
$("#delete").click( function() {
    $.ajax({
        url : url,
        type: 'post',
        data : {
			filename : $("input[name=files]:checked").val(),
			action : dirl
        }
    });
});
	$(function() {   
           $(".deleteupdate").click(function() {  
           	var id = document.getElementById('dupdate').value;;
			var groupname='<?php echo $gname; ?>';
			var groupid ='<?php echo $id; ?>';

           $.ajax({
	            success: function() { 
	            window.location = 'deleteupdate.php?id=' + id + "&groupname="+ groupname+ "&groupid="+ groupid  ;
				}
            });
            return false;
         });
	});		

$(".update").click(function() {  
	var groupname='<?php echo $gname; ?>';
 	var update = document.getElementById('update').value;
 	           	var id ='<?php echo $id; ?>';

   	$.ajax({
        success: function() { 
        window.location = 'update.php?update=' + update + "&groupname="+ groupname + "&id="+ id ;

		}
    });
    return false;
});
	$(function() {   
           $(".addmember").click(function() {  
           	var id ='<?php echo $id; ?>';
 			var member = document.getElementById('contact').value;
           $.ajax({
	            success: function() { 
	            window.location = 'addcontact.php?member=' + member + "&id="+ id;
				}
            });
            return false;
         });
	});		

	$(function() {   
           $(".delmember").click(function() {  
           	var id ='<?php echo $id; ?>';
 			var member = document.getElementById('dmember').value;
           $.ajax({
	            success: function() { 
	            window.location = 'groupmemberdelete.php?member=' + member + "&id="+ id;
				}
            });
            return false;
         });
	});			

		$(function() {   
           $(".delmember").click(function() {  
           	var id ='<?php echo $id;?>';

 			var member = document.getElementById('dmember1').value;
           $.ajax({
	            success: function() { 
	            window.location = 'groupmemberdelete.php?member=' + member + "&id="+ id;
				}
            });
            return false;
         });
	});		
			$(function() {   
           $(".delmember").click(function() {  
           	var id ='<?php echo $id; ?>';
 			var member = document.getElementById('dmember2').value;
           $.ajax({
	            success: function() { 
	            window.location = 'groupmemberdelete.php?member=' + member + "&id="+ id;
				}
            });
            return false;
         });
	});		
				$(function() {   
           $(".delmember").click(function() {  
           	var id ='<?php echo $id; ?>';
 			var member = document.getElementById('dmember3').value;
           $.ajax({
	            success: function() { 
	            window.location = 'groupmemberdelete.php?member=' + member + "&id="+ id;
				}
            });
            return false;
         });
	});		
					$(function() {   
           $(".delmember").click(function() {  
           	var id ='<?php echo $id; ?>';
 			var member = document.getElementById('dmember4').value;
           $.ajax({
	            success: function() { 
	            window.location = 'groupmemberdelete.php?member=' + member + "&id="+ id;
				}
            });
            return false;
         });
	});							
					$(function() {   
           $(".delmember").click(function() {  
           	var id ='<?php echo $id; ?>';
 			var member = document.getElementById('dmember5').value;
           $.ajax({
	            success: function() { 
	            window.location = 'groupmemberdelete.php?member=' + member + "&id="+ id;
				}
            });
            return false;
         });
	});		
		$(function() {   
           $(".messagemember").click(function() {  
 			var member = document.getElementById('mmember').value;
           $.ajax({
	            success: function() { 
	            window.location = 'groupmembermessage.php?member=' + member;
				}
            });
            return false;
         });
	});		
		$(function() {   
           $(".messagemember").click(function() {  
 			var member = document.getElementById('mmember2').value;
           $.ajax({
	            success: function() { 
	            window.location = 'groupmembermessage.php?member=' + member;
				}
            });
            return false;
         });
	});		
		$(function() {   
           $(".messagemember").click(function() {  
 			var member = document.getElementById('mmember3').value;
           $.ajax({
	            success: function() { 
	            window.location = 'groupmembermessage.php?member=' + member;
				}
            });
            return false;
         });
	});		
		$(function() {   
           $(".messagemember").click(function() {  
 			var member = document.getElementById('mmember4').value;
           $.ajax({
	            success: function() { 
	            window.location = 'groupmembermessage.php?member=' + member;
				}
            });
            return false;
         });
	});		
		$(function() {   
           $(".messagemember").click(function() {  
 			var member = document.getElementById('mmember5').value;
           $.ajax({
	            success: function() { 
	            window.location = 'groupmembermessage.php?member=' + member;
				}
            });
            return false;
         });
	});	
	$(function() {   
           $(".GroupChat").click(function() {  
           	var groupname ='<?php echo $gname; ?>';

           $.ajax({
	            success: function() { 
	            window.location = 'chat.php?groupname=' + groupname;
				}
            });
            return false;
         });
	});		

</script>

</body>
</html>