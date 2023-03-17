<?php

$sname= "localhost";
$unmae= "root";
$password = "";

$db_name = "cics";

$conn = mysqli_connect($sname, $unmae, $password, $db_name);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

?>