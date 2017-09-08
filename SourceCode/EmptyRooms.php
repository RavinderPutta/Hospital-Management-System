<?php

echo"<label for=\"usr\">Room:</label>";
echo"<select class=\"form-control\" id=\"ddlRoom\">";

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


$sql = "SELECT * FROM Room WHERE PatientId IS NULL ORDER BY Number;";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<option value=\"" . $row["Id"] . "\">" . $row["Number"] . "</option>";
    }
} else {
    echo "0 results";
}

$conn->close();

echo"</select>";

?>