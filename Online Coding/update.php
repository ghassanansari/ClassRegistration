<?php
		if ( ! isset($_COOKIE['login']) ) {
		echo "Need to log in first";
		header("refresh:2;url=login.html");
		exit;
	}
	$login=$_COOKIE['login'];
	//session_start();
	require_once('dbs.php');
	$con=mysqli_connect($sql_host, $sql_username, $sql_password, $update_database);
	$id = $_GET['id'];
	$update = $_GET['update'];
	$groupname = $_GET['groupname'];
	echo $groupname;
	echo $update;

	$sql = "INSERT INTO $groupname(sender,updates,datesent) VALUES ('$login','$update',NOW())";
	$con->query($sql);

	header("Location: groupfiles.php?id=".$id);
	die();

		?>
			</table>

		</form>
		</body>
		</html>
