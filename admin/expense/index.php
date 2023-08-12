<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Expense Management</h3>
		<div class="card-tools">
			<a href="javascript:void(0)" id="manage_expense" class="btn btn-flat btn-sm btn-primary"><span class="fas fa-plus"></span>  Add New</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-bordered table-stripped">
				<colgroup>
					<col width="5%">
					<col width="15%">
					<col width="15%">
					<col width="10%">
                    <col width="10%">
                    <col width="15%">
					<col width="15%"> <!-- daterleaseadded-->
					<col width="30%">
					<col width="15%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Date Created</th>
						<th>Category</th>
						<th>Budget</th>
                        <th>Spent</th>
                        <th>Remaining Balance</th>
						<th>Date Released</th> <!-- daterelease added-->
						<th>Remarks</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
                    $i = 1;
                    $qry = $conn->query("SELECT r.*, c.category, c.balance FROM `running_balance` r INNER JOIN `categories` c ON r.category_id = c.id WHERE c.status = 1 AND r.balance_type = 2 ORDER BY unix_timestamp(r.date_created) DESC");
                    while ($row = $qry->fetch_assoc()):
                        foreach ($row as $k => $v) {
                            $row[$k] = trim(stripslashes($v));
                        }
                        $row['remarks'] = strip_tags(stripslashes(html_entity_decode($row['remarks'])));
                        $budget_result = $conn->query("SELECT SUM(amount) AS budget FROM `running_balance` WHERE balance_type = 1 AND category_id = {$row['category_id']}");
                        $budget_row = $budget_result->fetch_assoc();
                        // Calculate spent and remaining balances
                        $spent = $row['amount'];
                        $budget = $budget_row['budget'];
                        $remaining_balance = $row['balance']?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<!--<td><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>-->
							<!---Date Created start----->
							<td ><p class=""><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></p></td>
							<!---Date Created end----->
							<td><?php echo $row['category'] ?></td>
                            <td><p class="m-0 text-right"><?php echo number_format($budget) ?></p></td>
                            <td><p class="m-0 text-right"><?php echo number_format($spent) ?></p></td>
                            <td><p class="m-0 text-right"><?php echo number_format($remaining_balance) ?></p></td>

                            <!---Date Release start----->
							<td ><p class=""><?php echo date("Y-m-d H:i",strtotime($row['daterelease'])) ?></p></td>
							<!---Date Release end ----->
							<td ><p class="m-0 truncate"><?php echo ($row['remarks']) ?></p></td>
							<td align="center">
								  <a class="manage_expense" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span></a>
				                  <a class="delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>" data-category_id="<?php echo $row['category_id'] ?>"><span class="fa fa-trash text-danger"></span></a>
				                  
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('#manage_expense').click(function(){
			uni_modal("<i class='fa fa-plus'></i> Add New Expense",'expense/manage_expense.php')
		})
		$('.manage_expense').click(function(){
			uni_modal("<i class='fa fa-edit'></i> Update Expense",'expense/manage_expense.php?id='+$(this).attr('data-id'))
		})
		$('.delete_data').click(function(){
			_conf("Are you sure to delete this expense permanently?","delete_expense",[$(this).attr('data-id'),$(this).attr('data-category_id')])
		})
		$('#uni_modal').on('show.bs.modal',function(){
			$('.summernote').summernote({
		        height: 200,
		        toolbar: [
		            [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
		            [ 'fontsize', [ 'fontsize' ] ],
		            [ 'para', [ 'ol', 'ul' ] ],
		            [ 'view', [ 'undo', 'redo'] ]
		        ]
		    })
		})
		$('.table').dataTable({
			columnDefs: [
				{ orderable: false, targets: 5 }
			],
			order: [[0, 'asc']]
		});
	})
	function delete_expense($id,$category_id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_expense",
			method:"POST",
			data:{id: $id,category_id: $category_id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>