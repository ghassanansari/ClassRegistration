<?php
	if ( ! isset($_COOKIE['login']) ) {
		echo "Need to log in first";
		header("refresh:2;url=login.html");
		exit;
	}
	$login=$_COOKIE['login'];
?><!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1" /> 
<link rel="stylesheet" href="style/css3menu1/style.css" type="text/css" /><style type="text/css">._css3m{display:none}</style>
<title>My Files</title>
<script src="JavaScript/jquery.js"></script>
<link rel="stylesheet" href="style/styles.css" type="text/css" />
<link href="style/style.css" rel="stylesheet" type="text/css" />
<link href="style/upload.css" rel="stylesheet" type="text/css" />
<script>
// form validation
function chkradio()
{
var elem=document.forms['myfiles'].elements['files'];
len=elem.length;
chkvalue='';
for(i=0; i<=len; i++)
{
if(elem[i].checked)chkvalue=elem[i].value;	
}
if(chkvalue=='')
{
alert('No file selected.');
return false;
}
return true;
}
// Upload Functions

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

function startUpload(){
      document.getElementById('f1_upload_process').style.visibility = 'visible';
      document.getElementById('f1_upload_form').style.visibility = 'hidden';
      return true;
}

function stopUpload(success){
      var result = '';
      if (success == 1){
         result = '<span class="msg">Successful Upload<\/span><br/><br/>';
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

<table class="center">
<tr><td>
<h2>My Files</h2>
<div  id="myfiles" class="round">
&nbsp<input type="checkbox" id="css3menu-switcher" class="c3m-switch-input center">
<ul id="css3menu1" class="topmenu">
	<li class="switch"><label onclick="" for="css3menu-switcher"></label></li>
	<li class="toplast"><a href="#" style="width:56px;"><span>New File</span></a>
	<ul>
		<li><a href="html.php" target="_blank">HTML mixed-mode</a></li>
		<li><a href="php.php" target="_blank">PHP/HTML</a></li>
		<li><a href="xml.php" target="_blank">XML</a></li>
		<li><a href="c.php" target="_blank">C/C++</a></li>
		<li><a href="java.php" target="_blank">Java</a></li>
		<li><a href="python.php" target="_blank">Python</a></li>
	</ul></li>
</ul>
<br><br><br>
<table>
<form name="myfiles" class="hoverTable" action="load.php" method="POST" onsubmit="return chkradio()">
<?php 
$dir    = "./userFiles/".$login;
if (!is_dir($dir)){
			mkdir($dir,0777,true);
    }
$files = array_diff(scandir($dir), array('..', '.')); 
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
<br><input class="button" type="submit" value="load" id="load">
</form>
<button class="button" id="delete">delete</button>
<?php
}else{
	echo "<br><b>You have no files.</b></table></div></form>";
}
?>
</div>
</td></tr>
<tr><td>
	<br><a href="#"><table><tr><td><h3 style="font-weight: bold; font-size:16px;" id="newfile">Upload File</h3></td><td><h3 style="color: white; font-weight: bold; font-size:16px;" id="show">[+]</h3></td></tr></table></a>
<form action="upload.php" method="post" enctype="multipart/form-data" target="upload_target" onsubmit="startUpload();" id="uploadform">
	<p id="f1_upload_process">Loading...<br/><img src="style/loader.gif" /><br/></p>
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
</table>
<script src="JavaScript/file_management.js"></script>
</body>
</html>