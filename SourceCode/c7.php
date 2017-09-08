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
	<h2>C.7</h2>
<table class="display" id="tblData" cellspacing="0">
<thead>
<tr>
	<td>Diagnoses</td>
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


$sql = "SELECT DiagnosisType.Name
 FROM (SELECT ID as paID, PatientID as pID from PatientAdmission) as pAdmission JOIN (SELECT pID FROM (SELECT patientid AS pID, COUNT(ID) AS Admissions FROM PatientAdmission GROUP BY PatientId) AS t1 
WHERE Admissions = (SELECT MAX(AdCount) AS AdMax FROM (SELECT COUNT(ID) AS AdCount FROM PatientAdmission GROUP BY PatientId) AS t3)) AS TopPatients ON pAdmission.pID = TopPatients.pID
JOIN (SELECT DiagnosisTypeID as dtID, PatientAdmissionID as paID FROM PatientDiagnosis) AS diagtype ON diagtype.paID = pAdmission.paID
JOIN DiagnosisType ON DiagnosisType.Id = diagtype.dtID
GROUP BY DiagnosisType.name
ORDER BY DiagnosisType.name;";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td> " . $row["Name"] . " </td></tr> ";
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
