<?php
	if ( ! isset($_COOKIE['login']) ) {
		echo "Need to log in first";
		header("refresh:2;url=login.html");
		exit;
	}
	$login=$_COOKIE['login'];
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>CodeEditor</title>
<script src="JavaScript/jquery.js"></script>
<script src="JavaScript/file_management.js"></script>
<script src='codemirror/lib/codemirror.js'></script>
<script src='codemirror/mode/xml/xml.js'></script>
<script src='codemirror/mode/javascript/javascript.js'></script>
<script src='codemirror/mode/css/css.js'></script>
<script src='codemirror/mode/htmlmixed/htmlmixed.js'></script>
<link rel='stylesheet' href='codemirror/lib/codemirror.css'>
<link rel='stylesheet' href='codemirror/doc/docs.css'>
<link href="style/style.css" rel="stylesheet">
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
var docname="";
function fn() {
while(docname==""){
docname = prompt("Please enter the file name (including file extension):"); }

} fn();
</script>
</head>
<body>
<div class="header-box">
	<div class="header-main">
		<ul id="nav1">
            <li>
                <a href="login.html" title="Log In">Log In</a>
            </li>
                <li>
                    <a href="register.html" title="Sign Up">Sign Up</a> 
                </li>
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
    mode: 'text/html',
    tabMode: 'indent',
    lineNumbers: true,
    lineWrapping: true,
    autoCloseTags: true
});
    editor.setOption("theme", "blackboard");
</script>
</body>
</html>