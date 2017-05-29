<?php
	if ( ! isset($_COOKIE['login']) ) {
		echo "Need to log in first";
		header("refresh:2;url=login.html");
		exit;
	}
	$login=$_COOKIE['login'];
	if(isset($_GET['admin'])) {
    $admin = $_GET['admin'];
	}
	if(isset($_GET['gname'])) {
    $gname = $_GET['gname'];
	}
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
<script src='codemirror/mode/php/php.js'></script>
<script src='codemirror/mode/javascript/javascript.js'></script>
<script src='codemirror/mode/css/css.js'></script>
<script src='codemirror/mode/htmlmixed/htmlmixed.js'></script>
<script src='codemirror/addon/edit/matchbrackets.js'></script>
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
<script>
docname = prompt("Please enter the file name (including extension):");
</script>
</head>
<body>
<div id="dolphincontainer">
	<div id="out">
		<ul>
			<li><a href="myfiles.php"><span>My Files</span></a></li>
			<li><a href="logout.php"><span>Log out</span></a></li>
		</ul>
	</div>
</div>
<textarea id="code" name="code" autofocus></textarea>
<button class="button" id="save">Save</button>
<!-- <button id="load">load</button>
<button id="delete">delete</button>
<input type="text" id="filename" value="test.txt"><br>-->
<script>
var delay;

// Initialize CodeMirror editor
var editor = CodeMirror.fromTextArea(document.getElementById('code'), {
        lineNumbers: true,
        matchBrackets: true,
        mode: "application/x-httpd-php",
        indentUnit: 4,
        indentWithTabs: true
      });
    editor.setOption("theme", "blackboard");
</script>
<?php 	if(isset($_GET['admin'])) {
		$dirl    = "groupfiles/".$admin."/".$gname; 
		?>
<script>
var url = 'group_save.php';
var dirl='<?php echo $dirl; ?>';
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
var dir2=dirl.concat("/");
var dir=dir2.concat(docname);
$(window).unload(function () {

    $.ajax({
        type: 'POST',
        async: false,
        url: 'unlock.php',
		data : {
			pathn : dir
		}
    });
});
</script>
</body>
</html>