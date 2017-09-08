<?php

echo"<label for=\"usr\">Insurance Company:</label>";
echo"<select class=\"form-control\" id=\"ddlIns\" name=\"ddlIns\">";

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


$sql = "SELECT * FROM InsuranceProvider ORDER BY Name";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<option value=\"" . $row["Id"] . "\">" . $row["Name"] . "</option>";
    }
} else {
    echo "0 results";
}

$conn->close();

echo"</select>";

?>