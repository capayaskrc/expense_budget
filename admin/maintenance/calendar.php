<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Synchronized Local Planning and Budgeting Calendar</h3>
		<div class="card-tools">
			<!--<a href="?page=maintenance/manage_category" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Create New</a>-->
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        	<div class="container-fluid">
				<iframe src="http://localhost/expense_budget/admin/calendar/index.php" height="800" width="100%" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" title="Calendar"></iframe>	
			
			
			</div>
		</div>
	</div>
</div>

<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Details</h3>
		<div class="card-tools">
			<!--<a href="?page=maintenance/manage_category" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Create New</a>-->
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        	<div class="container-fluid">
			
				<table class="table table-bordered table-stripped">
					<colgroup>
						<col width="5%">
						<!--<col width="15%">
						<col width="20%">-->
						<col width="35%">
						<col width="15%">
						<col width="15%">
						
					</colgroup>
					<thead>
						<tr>
							<th>Planning No.</th>
							<!--<th>Date Created</th>
							<th>Category</th>-->
							<th>Activities</th>
							<th>Date Start</th>
							<th>Date End</th>
							
						</tr>
					</thead>
					<tbody>
						<?php 
						$i = 1;
							$qry = $conn->query("SELECT * from `schedule_list` order by 'id' ");
							while($row = $qry->fetch_assoc()):
								$row['activities'] = strip_tags(stripslashes(html_entity_decode($row['activities'])));
						?>
							<tr>
								<td class="text-center"><?php echo $i++; ?></td>
								<!--<td><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
								<td><?php echo $row['category'] ?></td>-->
								<td><p class="truncate-1 m-0"><?php echo $row['activities'] ?></p></td>
								<td><?php echo date("F d, Y h:i A",strtotime($row['start_datetime'])) ?></td>
								<td><?php echo date("F d, Y h:i A",strtotime($row['end_datetime'])) ?></td>
								
							</tr>
						<?php endwhile; ?>
					</tbody>
				</table>
			</div>	
		</div>	
	</div>	
</div>
