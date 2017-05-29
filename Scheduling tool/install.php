<?php
require_once('db.php');

// setup a connection to MySQL
$conn=mysqli_connect($sql_host, $sql_username, $sql_password);
if ( mysqli_connect_errno()){
    echo "Failed to connect ". mysqli_connect_error();
    exit;
}

$sql = "CREATE DATABASE IF NOT EXISTS $sql_database" ;
$conn->query($sql);

// Select the database
mysqli_select_db($conn, $sql_database) or die('Error selecting MySQL database: ' . mysqli_error($conn));



$x = ''; // Temp used to store  query

$lines = file($sql_filename);// Read the whole file

foreach ($lines as $line)// Loop through
{
    if (substr($line, 0, 2) == '--' || $line == '')// Skip comments
        continue;

    $x .= $line;

    if (substr(trim($line), -1, 1) == ';')// A semicolon means end of  query
    {
        mysqli_query($conn, $x) or print('Error performing query ');
        $x = '';
    }
}
echo "Tables imported successfully";
header("Location: index.html");
?>