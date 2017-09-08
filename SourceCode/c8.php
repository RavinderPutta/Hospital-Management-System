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
	<h2>C.8</h2>
<form action="c8.php" method="post">
<div id="ddl" style="max-width:none;"></div>
<table class="display" id="tblData" cellspacing="0">
<thead>
<tr>
	<td>Employee Name</td>
	<td>Patient Name</td>
	<td>Primary Doctor</td>
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


$sql = "SELECT EmployeeName a, PatientName b, PrimaryDoctor c FROM (SELECT EmployeeName AS PrimaryDoctor, PatientName FROM (SELECT PatientAdmissionId AS paID FROM PatientTreatment WHERE Id = " . $_POST["ddlIns"] . ") AS t1 JOIN (SELECT EmployeeId as eID, IsPrimary, PatientAdmissionId as paID FROM PatientDoctor) AS t2 ON t1.paID = t2.paID JOIN (SELECT CONCAT(FirstName, ' ', LastName) AS PatientName, Id AS pID FROM Patient) AS t3 ON t1.paID = t3.pID JOIN (SELECT CONCAT(FirstName, ' ', LastName) AS EmployeeName, Id AS eID FROM Employee) AS t4 ON t4.eID = t2.eID WHERE IsPrimary) AS PrimaryDoctorTable, (SELECT CONCAT(Employee.FirstName, ' ', Employee.LastName) AS EmployeeName FROM (SELECT PatientAdmissionId as paID FROM PatientTreatment WHERE Id = " . $_POST["ddlIns"] . ") AS t1 JOIN PatientDoctor ON PatientDoctor.PatientAdmissionId = t1.paID JOIN Employee ON PatientDoctor.EmployeeId = Employee.Id) AS OtherEmployees;";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td> " . $row["a"] . " </td><td> " . $row["b"] . "</td><td> " . $row["c"] . "</td></tr>" ;

    }
} else {
    echo "0 results";
}

$conn->close();
?>
</tbody>
</table>
</form>

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

	$.ajax({

     type: "GET",
     url: '/~hollimi/AllTreat.php',
     success: function(data) {
          $('#ddl').html(data);
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
