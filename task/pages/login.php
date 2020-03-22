<?php
session_unset();
setcookie('PHPSESSID', $_COOKIE['PHPSESSID'],time() - 864000, "/");	
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Task - Admin</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="css/admin.css" >
</head>
<body>

	<form method='post'>
		<div class="box_form clearfix">
		<h5><?php echo $auth_result;?></h5>
			<div class="box_login last">
				<div class="form-group">
					<input type="text" class="form-control" name="login" placeholder="Your login" required>
				</div>
				<div class="form-group">
					<input type="password" class="form-control" placeholder="Your password" name="password" id="password" required>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary">Login</button>
					<a class="btn btn-outline-info" href="/"><< Back</a>
				</div>				
			</div>
		</div>
	</form>

</body>
</html>
