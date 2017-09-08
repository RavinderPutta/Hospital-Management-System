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
	<h2>D.6</h2>

<form action="d6.php" method="post">
<div id="ddl" style="max-width:none;"></div>
<table class="display" id="tblData" cellspacing="0">
<thead>
<tr>
	<td>Treatment</td>
	<td>Occurences</td>
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


$sql = "SELECT Treatment a, COUNT(Treatment) AS Occurences FROM (SELECT Id AS eID FROM Employee WHERE ID = " . $_POST["ddlIns"] . ") AS t1 JOIN (SELECT EmployeeId AS eID, PatientAdmissionId AS paID FROM PatientDoctor) AS t2 ON t1.eID = t2.eID JOIN (SELECT PatientAdmissionId AS paID, TreatmentTypeId as ttID FROM PatientTreatment) AS t3 ON t2.paID = t3.paID JOIN (SELECT Id AS ttID, Name AS Treatment FROM TreatmentType) AS t4 ON t3.ttID = t4.ttID GROUP BY t4.Treatment ORDER BY t4.Treatment DESC; ";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td> " . $row["a"] . " </td><td> " . $row["Occurences"] . "</td></tr>"; 
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
     url: '/~hollimi/AllDocs.php',
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
