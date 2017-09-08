<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

echo"<label for=\"usr\">Doctors:</label>";
echo"<select class=\"form-control\" id=\"ddlIns\" name=\"ddlIns\"   onchange=\"this.form.submit()\">";
echo "<option value=\"" . "0" . "\">" . "--Select Doctor--" ."</option>";

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


$sql = "select Id v, FirstName a, LastName b from Employee where EmployeeTypeId=2";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<option value=\"" . $row["v"] . "\">" . $row["a"] . " " . $row["b"] . " " ."</option>";
    }
} else {
    echo "0 results";
}

$conn->close();

echo"</select>";

?>