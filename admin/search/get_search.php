<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" name="viewport" content="width=device-width"/>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
	</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<a class="navbar-brand">Current Budget in each Categories</a>
		</div>
	</nav>
	<div class="col-md-3"></div>
	<div class="col-md-6 well">
		<h4>Search Category</h4>
		<hr style="border-top:1px dotted #ccc;"/>
		<!--<a href="index.php" class="btn btn-success">Back</a>-->
		<?php
			require 'conn.php';
			if(ISSET($_REQUEST['id'])){
				$query = mysqli_query($conn, "SELECT * FROM `categories` WHERE `id` = '$_REQUEST[id]'") or die(mysqli_error());
				$fetch = mysqli_fetch_array($query);
		?>
				<h3 class="text-center"><?php echo $fetch['category']?></h3>
				<p><b>Balance: </b><?php echo nl2br($fetch['balance'])?></p>
				<p><b>Date Created: </b><?php echo nl2br($fetch['date_created'])?></p>                                    
				<p><b>Description: </b><?php echo nl2br($fetch['description'])?></p>
				<?php if($fetch['status'] == 1): ?>
                    <p><b>Status: </b><span class="badge badge-success">Active</span></p>
                        <?php else: ?>
					<p><b>Status: </b><span class="badge badge-danger">Inactive</span></p>
                <?php endif; ?>    
        
		<?php
			}
		?>
		<br/><br/>
		<a href="index.php" class="btn btn-primary">Back</a>
		
	</div>
</body>
</html>