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
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="/~hollimi/scripts/jQDateRangeSlider-min.js"></script>
    <link rel="stylesheet" type="text/css" href="/~hollimi/css/iThing-min.css">
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
	<h2>B.3</h2>

    	<label for="amount">Date Range:</label>
        <input type="text" id="amount" readonly style="border:0; color:#000000; font-weight:bold;">



		<div id="slider-range"></div>

<table class="display" id="tblData" cellspacing="0">
<thead>
<tr>
	<td>Id</td>
	<td>First Name</td>
	<td>Last Name</td>
	<td>ATime</td>
	<td>DTime</td>
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


$sql = "SELECT * FROM Patient JOIN PatientAdmission ON Patient.Id = PatientAdmission.PatientId WHERE AdmissionTime IS NOT NULL AND DischargeTime IS NOT NULL;";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td> " . $row["Id"] . " </td><td> " . $row["FirstName"] . " </td><td> " . $row["LastName"] .
        "</td><td> " . $row["AdmissionTime"] . " </td><td> " . $row["DischargeTime"];

        echo "</td></tr>";

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

            fnInitComplete: function () {
                if ($(this).text().indexOf("No data available in table") >= 0)
                    $(this).parent().hide();
            }
        });

table.column(3).visible(false);
table.column(4).visible(false);

var slider = $("#slider-range").dateRangeSlider();

$("#slider-range").dateRangeSlider();

	$.ajax({

     type: "GET",
     url: '/~hollimi/GetMinAdTime.php',
     success: function(data) {
     	var min = data.split('|')[0];
     	var max = data.split('|')[1];

     	var minyear = min.split('-')[0];
     	var minmonth = min.split('-')[1] - 1;
     	var minday = min.split('-')[2].split(' ')[0] - 1;

     	var MinDate = new Date(minyear, minmonth, minday);
     	MinDate = MinDate.setDate(MinDate.getDate() - 1);


     	var maxyear = max.split('-')[0];
		var maxmonth = max.split('-')[1] - 1;
     	var maxday = max.split('-')[2].split(' ')[0] - 1;

     	var MaxDate = new Date(maxyear, maxmonth, maxday);
     	MaxDate = MaxDate.setDate(MaxDate.getDate() + 2);


     	$("#slider-range").dateRangeSlider("bounds", MinDate , MaxDate);
     	$("#slider-range").dateRangeSlider("values", MinDate, MaxDate);

     }

   });

    $("#slider-range").bind("valuesChanged", function(e, data){
      table.draw();
    });


$.fn.dataTable.ext.search.push(

        function( settings, data, dataIndex ) {


		var dateValues = $("#slider-range").dateRangeSlider("values");



           // var min = dateValues.min;
           // var max = dateValues.max;

			var A = data[3];
			var D = data[4];

			var min = new Date(dateValues.min);
			var max = new Date(dateValues.max);
			//2013-01-01
			min = min.getFullYear() + "-" + (parseInt(min.getMonth()) + 1) + "-" + (parseInt(min.getDay()) + 1);
			max = max.getFullYear() + "-" + (parseInt(max.getMonth()) + 1) + "-" + (parseInt(max.getDay()) + 1);


            if ( (min <= A   && A <= max) ||
            	( min <= D   && D <= max ) )
            {
                return true;
            }

            return false;
        }
    );

	});
</script>

</body>
</html>
