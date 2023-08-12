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
					<col width="15%">
					<col width="5%">
					<col width="15%">
					<col width="10%">
                    <col width="10%">
                    <col width="5%">
				</colgroup>
				<thead>
					<tr>
						<th>Category</th>
                        <th>Year</th>
						<th>Budget</th>
                        <th>Spent</th>
                        <th>Remaining Balance</th>
                        <th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
                    $i = 1;
                    $qry = $conn->query("SELECT 
                    c.category, 
                    c.balance, 
                    YEAR(r.date_created) AS year,
                    SUM(CASE WHEN r.balance_type = 1 THEN r.amount ELSE 0 END) AS budget,
                    SUM(CASE WHEN r.balance_type = 2 THEN r.amount ELSE 0 END) AS spent
                    FROM `running_balance` r 
                    INNER JOIN `categories` c ON r.category_id = c.id 
                    WHERE c.status = 1 
                    GROUP BY c.category, c.balance, YEAR(r.date_created) 
                    ORDER BY c.category, YEAR(r.date_created) DESC");

                    $current_category = "";
                    $current_year = "";

                    while ($row = $qry->fetch_assoc()):
                        // Check if a new category or year starts
                        if ($current_category !== $row['category'] || $current_year !== $row['year']) {
                            // Display the new row
                            if ($current_category !== "") {
                                // Close previous row
                                echo "</tr>";
                            }
                            // Start new row
                            echo "<tr>";
                            echo "<td>{$row['category']}</td>";
                            echo "<td>{$row['year']}</td>";
                            // ... other columns ...
                            echo "<td><p class='m-0 text-right'>" . number_format($row['budget']) . "</p></td>";
                            echo "<td><p class='m-0 text-right'>" . number_format($row['spent']) . "</p></td>";
                            echo "<td><p class='m-0 text-right'>" . number_format($row['budget'] - $row['spent']) . "</p></td>";
                            // ... action column ...
                            echo "<td align='center'>
                                     <a class='manage_expense' href='javascript:void(0)' data-category='{$current_category}' data-year='{$current_year}'>
                                    <span class='fa fa-edit text-primary'></span>
                                  </a>
                                   <a class='delete_data' href='javascript:void(0)' data-category='{$current_category}' data-year='{$current_year}'>
                                    <span class='fa fa-trash text-danger'></span>
                                  </a>
                              </td>";
                            echo "</tr>";
                            // Update current category and year
                            $current_category = $row['category'];
                            $current_year = $row['year'];
                        }
                    endwhile;

                    // Close the last row if it's not closed yet
                    if ($current_category !== "") {
                        echo "</tr>";
                    }
                        ?>
<!--						<tr>-->
<!--							<td class="text-center">--><?php //echo $i++; ?><!--</td>-->
<!--							<td>--><?php //echo date("Y-m-d H:i",strtotime($row['date_created'])) ?><!--</td>-->
<!--							Date Created start----->
<!--							Date Created end----->
<!--							<td>--><?php //echo $row['category'] ?><!--</td>-->
<!--                            <td><p class="m-0 text-right">--><?php //echo number_format($row['budget']) ?><!--</p></td>-->
<!--                            <td><p class="m-0 text-right">--><?php //echo number_format($row['spent']) ?><!--</p></td>-->
<!--                            <td><p class="m-0 text-right">--><?php //echo number_format($remaining_balance) ?><!--</p></td>-->
<!---->
<!--                           Date Release start----->
<!--							<td ><p class="">--><?php //echo date("Y-m-d H:i",strtotime($row['daterelease'])) ?><!--</p></td>-->
<!--							Date Release end ----->
<!--							<td ><p class="m-0 truncate">--><?php //echo ($row['remarks']) ?><!--</p></td>-->

<!--						</tr>-->

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