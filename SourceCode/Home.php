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

	    
	});
</script>

</body>
</html>
