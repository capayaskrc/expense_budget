<style>
  .info-tooltip,.info-tooltip:focus,.info-tooltip:hover{
    background:unset;
    border:unset;
    padding:unset;
  }
</style>
<h1>Welcome to <?php echo $_settings->info('name') ?></h1>
<hr>
<br/>
<div class="row">
          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-money-bill-alt"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Total Budget</span>
                <br/>
                <span class="info-box-number text-right">
                  <?php 
                    $today_budget = $conn->query("SELECT sum(amount) as total FROM `running_balance` where category_id in (SELECT id FROM categories where status =1) and date(date_created) = '".(date("Y-m-d"))."' and balance_type = 1 ")->fetch_assoc()['total'];
                    echo number_format($today_budget);
                  ?>
                  <?php ?>
                </span>
              </div>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-calendar-day"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Total Expense</span>
                <br/>
                <span class="info-box-number text-right">
                  <?php 
                   $today_expense = $conn->query("SELECT sum(amount) as total FROM `running_balance` where category_id in (SELECT id FROM categories where status =1) and date(date_created) = '".(date("Y-m-d"))."' and balance_type = 2 ")->fetch_assoc()['total'];
                    echo number_format($today_expense);
                  ?>
                </span>
              </div>
            </div>
          </div>
          <div class="clearfix hidden-md-up"></div>
          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-calendar-day"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Remaining Balance</span>
                <br/>
                <span class="info-box-number text-right">
                <?php
                $query = "SELECT
                            SUM(CASE WHEN balance_type = 1 THEN amount ELSE 0 END) AS total_budget,
                            SUM(CASE WHEN balance_type = 2 THEN amount ELSE 0 END) AS total_expense,
                            SUM(CASE WHEN balance_type = 1 THEN amount ELSE 0 END) - SUM(CASE WHEN balance_type = 2 THEN amount ELSE 0 END) AS remaining_balance
                        FROM
                            running_balance
                        WHERE
                            category_id IN (SELECT id FROM categories WHERE status = 1)
                            AND DATE(date_created) = CURRENT_DATE";
                $remaining_balance = $conn->query( $query)->fetch_assoc()['remaining_balance'];
                echo number_format($remaining_balance);
                ?>
                </span>
              </div>
            </div>
          </div>
        </div>
<div class="row">
    <?php
 $connect = mysqli_connect("localhost", "root", "", "expense_budget_db");

 $query = "SELECT category, sum(balance) as number FROM categories GROUP BY category";
 $result = mysqli_query($connect, $query);

    $query = "
    SELECT
        SUM(CASE WHEN balance_type = 1 THEN amount ELSE 0 END) AS budget,
        SUM(CASE WHEN balance_type = 2 THEN amount ELSE 0 END) AS expense,
        SUM(CASE WHEN balance_type = 1 THEN amount ELSE 0 END) - SUM(CASE WHEN balance_type = 2 THEN amount ELSE 0 END) AS remaining_balance
    FROM running_balance
";
    $result1 = mysqli_query($connect, $query);
    $row = mysqli_fetch_assoc($result1);


 $query = "SELECT date_created, sum(amount) as total FROM running_balance GROUP BY year(date_created)";
 $result2 = mysqli_query($connect, $query);

 ?>

<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Statistics</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
			google.charts.load("current", {packages:['corechart']});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
				//data
                var data1 = google.visualization.arrayToDataTable([
                    ['', 'Total Amount'],
                    ['Budget', <?php echo $row["budget"]; ?>],
                    ['Expense', <?php echo $row["expense"]; ?>],
                    ['Remaining Balance', <?php echo $row["remaining_balance"]; ?>]
                ]);

				var data = google.visualization.arrayToDataTable([  
                ['hehe', 'Balance'],  
                <?php  
                while($row = mysqli_fetch_array($result))  
                {  
                echo "['".$row["category"]."', ".$row["number"]."],";  
                }  
                ?>  
                ]);

				

				var data2 = google.visualization.arrayToDataTable([  
                ['', 'Total Amount'],  
                <?php  
                while($row = mysqli_fetch_array($result2))  
                {  
                echo "['".$row["date_created"]."', ".$row["total"]."],";  
                }  
                ?>  
                ]);

				

				//option


				var options1 = {
                    title: 'Running Balance',
                    width: 550,
                    height: 450,
                    vAxis : {
                        title: "1: Total Budget;         2: Total Expenses;         3: Remaining Balance"
                            },
                    hAxis : {
                        title: ''
                            },
                    // colors: ['#00FFFF', '#e6693e', '#68a71f'],

                      // is3D:true,
                };

                	var options = {  
                    title: 'Budget Status',  
                    width: 550,
                    height: 450,
                    hAxis: {
                        title: "Budget"
                            },
                    vAxis: {
                        title: 'Categories'
                            },
                    //colors: ['1b2431', '#e6693e'],
        
                      //is3D:true, 
                };

				var options2 = {  
                    title: 'Budget Per Year',  
                    width: 550,
                    height: 450,
                    hAxis: {
                        title: "year"
                            },
                    vAxis: {
                        title: 'total amount'
                            },
                    colors: ['#0d6efd', '#e6693e'],
        
                      //is3D:true, 
                };

				

				//chart
                var chart = new google.visualization.BarChart(document.getElementById('barchart_values1'));
                chart.draw(data1, options1);

				var chart1 = new google.visualization.PieChart(document.getElementById('donutchart'));  
                chart1.draw(data, options);

				var chart2 = new google.visualization.ColumnChart(document.getElementById('columnchart_values2'));  
                chart2.draw(data2, options2);

				
			}
		
		</script>
</head>

<body>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Budget Status</h3>
		<div class="card-tools">
			<!--<a href="?page=maintenance/manage_category" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Create New</a>-->
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
			<div class="page-inner">
					<div class="row mt--2">
						<div class="col-md-12">
                            <!--<h4 align="center">Statistics at a glance (as of <?php echo date('F j, Y') ?>) </h4>-->
                            <div>
                                <div id="barchart_values1"  style="float: left;"></div>
                                <div id="donutchart" style="float: left;"></div>
                                <div style="clear: both;"></div>
                            </div>

						</div>
					</div>
				</div>
			</div>

			<div class="page-inner">
					<div class="row mt--2">
						<div class="col-md-12">
                            <!--<h4 align="center">Statistics at a glance (as of <?php echo date('F j, Y') ?>) </h4>-->
                            <div>
                                <div id="columnchart_values2" style="float: left;"></div>
								<div id=""  style="float: right;"></div>
                                <div style="clear: both;"></div>
                            </div>

						</div>
					</div>
				</div>
			</div>


		</div>
	</div>
</div>
</body>
</html>

</div>

<!--<div class="row">
  <div class="col-lg-12">
    <h4>Current Budget in each Categories</h4>
    <hr>
  </div>
</div>
<div class="col-md-12 d-flex justify-content-center">
  <div class="input-group mb-3 col-md-5">
    <input type="text" class="form-control" id="search" placeholder="Search Category">
    <div class="input-group-append">
      <span class="input-group-text"><i class="fa fa-search"></i></span>
    </div>
  </div>
</div>-->

<div class="row">
  <div class="col-lg-12">
    <br/><br/>
    <h4></h4>
  </div>
</div>

<!-- Search Category --->

  <iframe src="./search/index.php" height="800" width="100%" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" title="Calendar"></iframe>	 

<!-- End Search Category --->

<!--<div class="row row-cols-4 row-cols-sm-1 row-cols-md-4 row-cols-lg-4">
  <?php 
  $categories = $conn->query("SELECT * FROM `categories` where status = 1 order by `category` asc ");
    while($row = $categories->fetch_assoc()):
  ?>
  <div class="col p-2 cat-items">
    <div class="callout callout-info">
      <span class="float-right ml-1">
        <button type="button" class="btn btn-secondary info-tooltip" data-toggle="tooltip" data-html="true" title='<?php echo (html_entity_decode($row['description'])) ?>'>
          <span class="fa fa-info-circle text-info"></span>
        </button>
      </span>
      <h5 class="mr-4"><b><?php echo $row['category'] ?></b></h5>
      <div class="d-flex justify-content-end">
        <b><?php echo number_format($row['balance']) ?></b>
      </div>
    </div>
  </div>
  <?php endwhile; ?>
</div>
<div class="col-md-12">
  <h3 class="text-center" id="noData" style="display:none">No Data to display.</h3>
</div>-->

<script>
  function check_cats(){
    if($('.cat-items:visible').length > 0){
      $('#noData').hide('slow')
    }else{
      $('#noData').show('slow')
    }
  }
  $(function(){
    $('[data-toggle="tooltip"]').tooltip({
      html:true
    })
    check_cats()
    $('#search').on('input',function(){
      var _f = $(this).val().toLowerCase()
      $('.cat-items').each(function(){
        var _c = $(this).text().toLowerCase()
        if(_c.includes(_f) == true)
          $(this).toggle(true);
        else
          $(this).toggle(false);
      })
    check_cats()
    })
  })
</script>
