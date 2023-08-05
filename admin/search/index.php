<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" name="viewport" content="width=device-width"/>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
	</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<a class="navbar-brand">Current Budget</a>
		</div>
	</nav>
	<div class="col-md-3"></div>
	<div class="col-md-6 well">
		<h4>Search Category</h4>
		<hr style="border-top:1px dotted #ccc;"/>
		<div class="col-md-1"></div>
		<div class="col-md-10">
			<!--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#form_modal">Add Content</button>-->
			<br />
			<br />
			<form class="form-inline" method="POST" action="index.php">
				<div class="input-group col-md-12">
					<input type="text" class="form-control" placeholder="Search category here..." name="keyword" required="required" value="<?php echo isset($_POST['keyword']) ? $_POST['keyword'] : '' ?>"/>
					<span class="input-group-btn">
						<button class="btn btn-primary" name="search"><span class="glyphicon glyphicon-search"></span></button>
					</span>
				</div>
			</form>
			<br />
			<?php include 'search.php'?>
		</div>
	</div>
	
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>