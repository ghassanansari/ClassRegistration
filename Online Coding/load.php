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
	mysqli_query($con, "CREATE DATABASE IF NOT EXISTS $sql_database");
	$con=mysqli_connect($sql_host, $sql_username, $sql_password, $sql_database);
	
	$filename = isset($_POST['files']) ? $_POST['files'] : false;
	if( isset($_POST['gdir'])){
	$directory = $_POST['gdir']. "/";
	
	/*		----------------	Locking		----------------	*/
	$filepath=$directory.$filename;
	$sql = "SELECT * FROM filelock WHERE filepath='$filepath'";
	$result = $con->query($sql);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		if($row['user'] != $login){
			$locked=TRUE;
		}
	}else{
		$sql = mysqli_query($con,"INSERT INTO filelock (user,filepath) VALUES ('$login','$filepath')");
	}
	
	/*		----------------	Locking		----------------	*/
	}else{
	$directory = "userFiles/" . $login . "/";
	}

	$content = @file_get_contents($directory.$filename);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1" /> 
<title>CodeEditor</title>
<script src="JavaScript/jquery.js"></script>
<script src='codemirror/lib/codemirror.js'></script>
<script src='codemirror/mode/xml/xml.js'></script>
<script src='codemirror/mode/javascript/javascript.js'></script>
<script src='codemirror/mode/css/css.js'></script>
<script src='codemirror/mode/htmlmixed/htmlmixed.js'></script>
<link rel='stylesheet' href='codemirror/lib/codemirror.css'>
<link rel='stylesheet' href='codemirror/doc/docs.css'>
<link href="style/style.css" rel="stylesheet">
<link rel="stylesheet" href="style/styles.css" type="text/css" />
<link rel="stylesheet" href="codemirror/theme/blackboard.css">
<style type='text/css'>
.CodeMirror {
    margin-left: auto;
    margin-right: auto;
    width: 100%;
	height: 85%;
    border: 1px solid black;
}
</style>
</head>
<body onbeforeunload="return unlock()">
<script>
var docname= '<?php echo $filename;?>';
<?php if(isset($locked)){
	?>
	alert('File is locked by another member.\n Read-Only mode is enabled.');
	<?php
	}
	?>
</script>
<div id="dolphincontainer">
	<div id="out">
		<ul>
		<?php if( isset($_POST['gdir'])){
			echo "<li><a href='groups.php'><span>My Projects</span></a></li>";
		}else{
			echo "<li><a href='myfiles.php'><span>My Files</span></a></li>";
		} ?>
			<li><a href="logout.php"><span>Log out</span></a></li>
		</ul>
	</div>
	<p style="padding-left:2.5em;"><b><?php echo $filename; ?></b></p>
</div>
<textarea id="code" name="code" autofocus></textarea><?php
if(!isset($locked)){
echo "<div>
<button class=\"button round\" id=\"save\">Save</button>
</div>";
}?>
<script>
// Initialize CodeMirror editor
var editor = CodeMirror.fromTextArea(document.getElementById('code'), {
    mode: 'text/html',
    tabMode: 'indent',
    lineNumbers: true,
    lineWrapping: true,
    autoCloseTags: true <?php if(isset($locked)){echo ",
	readOnly: true";
	}?>
});
editor.setOption("theme", "blackboard");
editor.setValue(<?php echo json_encode($content); ?>);
</script>
<?php if( isset($_POST['gdir'])){ ?>
<script>
var url = 'group_save.php';
var dirl='<?php echo $directory; ?>';
$("#save").click( function() {
    $.ajax({
        url : url,
        type: 'post',
        data : {
			filename : docname,
			action : dirl,
            content : encodeURIComponent(editor.getValue())

        }
    });
});
</script>
<?php }else{ ?>
<script src="JavaScript/save.js"></script>
<?php } ?>
<script>
var dir='<?php echo $filepath; ?>'; 
$(window).unload(function () {

    $.ajax({
        type: 'POST',
        async: false,
        url: 'unlock.php',
		data : {
			path : dir
		}
    });
});
</script>
</body>
</html>