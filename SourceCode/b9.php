<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/~hollimi/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/~hollimi/css/Site.css">
    <script src="//code.jquery.com/jquery-1.12.3.js"></script>
    <script src="/~hollimi/scripts/bootstrap.min.js"></script>
    <script src="/~hollimi/scripts/respond.min.js"></script>
    <script src="/~hollimi/scripts/DataTables/jquery.dataTables.min.js"></script>
    <link href="/~hollimi/css/jquery.dataTables.min.css" rel="stylesheet" />
    <title>DB Project</title>

</head>
<body>
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav" id="menu">

                </ul>
            </div>
        </div>
    </div>
    <div class="container body-content">
	<h2>B.9</h2>
<table class="display" id="tblData" cellspacing="0">
<thead>
<tr>
	<td>Patient ID</td>
	<td>Patient First Name</td>
	<td>Patient Last Name</td>
	<td>Diagnosis</td>
	<td>Doctor First Name</td>
	<td>Doctor Last Name</td>
</tr>
</thead>
<tbody>
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


$sql = "SELECT a,b,c, DiagnosisType.Name d, Employee.FirstName e, Employee.LastName f
 FROM(SELECT Patient.Id a, Patient.FirstName b, Patient.LastName c, p2.Id d
	FROM PatientAdmission p1 JOIN PatientAdmission p2 ON p1.PatientId = p2.PatientId 
	JOIN Patient ON Patient.Id = p2.PatientId 
	WHERE p1.DischargeTime < p2.AdmissionTime AND TIMEDIFF(p1.DischargeTime, p2.AdmissionTime) <= '-720:00:00' AND p1.Id <> p2.Id) s1
    JOIN PatientDiagnosis ON s1.d = PatientAdmissionId 
    JOIN DiagnosisType ON PatientDiagnosis.DiagnosisTypeId = DiagnosisType.Id
    JOIN PatientDoctor ON PatientDoctor.PatientAdmissionId = s1.d
    JOIN Employee ON Employee.Id = PatientDoctor.EmployeeId
    Where IsPrimary = true;";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td> " . $row["a"] . " </td><td> " . $row["b"] . "</td><td> " . $row["c"] . "</td><td>" . $row["d"] . "</td><td>" . $row["e"] ."</td><td>" . $row["f"] ."</td></tr>";

    }
} else {
    echo "0 results";
}

$conn->close();
?>
</tbody>
</table>


        <hr />
        <footer>
            <p>COMP5/6120 Summer 2016 S.Chakladar, M.Hollingsworth, C. Pennington, and R. Putta  </p>
        </footer>
    </div>

<script>
	$(document).ready(function () {

	$.ajax({

     type: "GET",
     url: '/~hollimi/MenuGen.php',
     success: function(data) {
          $('#menu').html(data);
     }

   });

    var table = $('#tblData').DataTable({
            "bPaginate": false,
            "bInfo" : false,
	    "bFilter": false,
            fnInitComplete: function () {
                if ($(this).text().indexOf("No data available in table") >= 0)
                    $(this).parent().hide();
            }
        });


	});
</script>

</body>
</html>
