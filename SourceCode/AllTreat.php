<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");



echo"<label for=\"usr\">Treatment:</label>";
echo"<select class=\"form-control\" id=\"ddlIns\" name=\"ddlIns\" style=\"max-width:none;\"  onchange=\"this.form.submit()\">";
echo "<option value=\"" . "0" . "\">" . "--Select Treatment--" ."</option>";

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


$sql = "select PatientTreatment.Id v, Patient.FirstName a, Patient.LastName b, TreatmentType.Name c, PatientTreatment.TimeStamp d from PatientTreatment join PatientAdmission on PatientTreatment.PatientAdmissionId = PatientAdmission.Id
 join Patient on Patient.Id = PatientAdmission.PatientId
 join TreatmentType on TreatmentType.Id = PatientTreatment.TreatmentTypeId;";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<option value=\"" . $row["v"] . "\">" . $row["a"] . " " . $row["b"] . " " .$row["c"] . " " .$row["d"] . " " ."</option>";
    }
} else {
    echo "0 results";
}

$conn->close();

echo"</select>";

?>