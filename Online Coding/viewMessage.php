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
	?>
<html>
<head>
<title>My Projects</title>
<meta name="viewport" content="width=device-width, initial-scale=1" /> 
<script src="JavaScript/jquery.js"></script> 
<link href="style/style.css" rel="stylesheet" type="text/css" />
</head>
<body class ="center">

<?php
	
	$id = $_POST['id'];
	$sql = "SELECT * FROM messages WHERE id = '$id'";
	$result = $con->query($sql);
	$row= mysqli_fetch_array($result);
	echo "<table messages>
			<tr>
				<th class=\"head\">
				</th>
				<th class=\"head\"> 
				</th>
			</tr>";
	if($row['viewed'] == 0)
	{
		$sql = "UPDATE messages SET viewed = 1 WHERE id = '$id'";
		$con->query($sql);
	}

	echo "<tr><td style=\"color: blue;\">From:</td><td> ".$row['sender']."</td></tr>";
	echo "<tr><td style=\"color: blue;\">Subject:</td><td> ".$row['subject']."</td></tr>";
	echo "<tr><td style=\"color: blue;\">Sent:</td><td> ".$row['datesent']."</td></tr>";
	echo "<tr><td style=\"color: blue;vertical-align: text-top;\">Message:</td><td> ".strtr($row["message"], array("\r\n" => '<br />', "\r" => '<br />', "\n" => '<br />'))."</td></tr>";
	echo "</table>";
			$sender = $row['sender'];
			$subject = $row['subject'];
			$message = $row['message'];
			$viewed = $row['viewed'];
		?>
		</body>
		</html>
