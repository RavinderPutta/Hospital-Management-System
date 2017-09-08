<?php

$servername = "acadmysql.duc.auburn.edu";
$username = "hollimi";
$password = "test21";
$dbname = "hollimidb";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$sql = "SELECT MIN(AdmissionTime) as m FROM PatientAdmission;";

$result = $conn->query($sql);

while($row = $result->fetch_assoc()) {
	echo $row["m"] . "|";
}

$sql = "SELECT MAX(AdmissionTime) as m FROM PatientAdmission;";

$result = $conn->query($sql);

while($row = $result->fetch_assoc()) {
	echo $row["m"];
}

$conn->close();
?>