<?php 
// echo "<pre>";
 // print_r($_SESSION);
// echo "</pre>";
?>		
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Task</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.css" />
	<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid-theme.min.css" />
	<link type="text/css" rel="stylesheet" href="css/inner.css" />
</head>
<script>
var sid=<?php echo json_encode(session_id());?>;
</script>
<body class="sidebar-icon-only">
  <div class="container-fluid">
          <div class="row grid-margin">
            <div class="col-12">
                <div class="card-body">
                  <h4 class="card-title">Task List</h4>
				  <login><?php echo $_SESSION['user'] ? "You are logged on as " . $_SESSION['user'] . " <a class='btn btn-outline-primary' href='/logout'>Logout</a>": "<a class='btn btn-outline-primary' href='/admin'>Login</a>" ;?></login>
                  <div id="tasks-table" ></div>
                </div>
            </div>
          </div>
   </div>
   
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.js"></script>
<script src="js/inner.js"></script>
</body>

</html>
