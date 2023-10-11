<style>
    table td,table th{
        padding: 3px !important;
    }


    .card-image {
        width: 100%; /* Set the image width to 100% of its parent container (the card) */
        min-width: 80%; /* Ensure the image doesn't exceed the card width */
        height: 100%; /* Set the height to 100% to fill the card vertically */
        object-fit: cover; /* Make the image fit while maintaining its aspect ratio */
        display: block; /* Ensures block-level display to work with margin: 0 auto; */
        margin: 0 auto; /* Center the image horizontally */
    }
    @media print {
        .card-image {
            max-width: 100% !important;
            height: auto !important;
        }
    }

</style>
<?php 
$date_start = isset($_GET['date_start']) ? $_GET['date_start'] :  date("Y-m-d",strtotime(date("Y-m-d")." -7 days")) ;
$date_end = isset($_GET['date_end']) ? $_GET['date_end'] :  date("Y-m-d") ;
?>
<div class="card card-primary card-outline">
    <div class="card-header">
        <h5 class="card-title">Expense Report</h5>
    </div>
    <div class="card-body">
        <form id="filter-form">
            <div class="row align-items-end">
                <div class="form-group col-md-3">
                    <label for="date_start">Date Start</label>
                    <input type="date" class="form-control form-control-sm" name="date_start" value="<?php echo date("Y-m-d",strtotime($date_start)) ?>">
                </div>
                <div class="form-group col-md-3">
                    <label for="date_start">Date End</label>
                    <input type="date" class="form-control form-control-sm" name="date_end" value="<?php echo date("Y-m-d",strtotime($date_end)) ?>">
                </div>
                <div class="form-group col-md-1">
                    <button class="btn btn-flat btn-block btn-primary btn-sm"><i class="fa fa-filter"></i> Filter</button>
                </div>
                <div class="form-group col-md-1">
                    <button class="btn btn-flat btn-block btn-success btn-sm" type="button" id="printBTN"><i class="fa fa-print"></i> Print</button>
                </div>
            </div>
        </form>
        <hr>
        <div id="printable">
            <img src="../uploads/HEADER.png" class="card-image">
            <div>
                <h4 class="text-center m-0"><?php echo $_settings->info('name') ?></h4>
                <h3 class="text-center m-0"><b>Expense Report</b></h3>
                <hr style="width:15%">
                <p class="text-center m-0">Date Between <b><?php echo date("M d, Y",strtotime($date_start)) ?> and <?php echo date("M d, Y",strtotime($date_end)) ?></b></p>
                <hr>
            </div>
            <table class="table table-bordered">
                <colgroup>
                    <col width="5%">                
                    <col width="15%">
                    <col width="15%">
                    <col width="15%">
                    <col width="15%">                
                    <col width="35%">                
                </colgroup>
                <thead>
                    <tr class="bg-gray-light">
                        <th class="text-center">#</th>
                        <th>Entry DateTime</th>
                        <th>Category</th>
                        <th>Expense Name</th>
                        <th>Amount</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                        <?php
                        $i = 1;
                        $total = 0;
                        $i = 1;
                        $total = 0;
                        $qry = $conn->query("SELECT r.*, c.category, c.balance, r.expense_title FROM `running_balance` r INNER JOIN `categories` c ON r.category_id = c.id WHERE c.status = 1 AND r.balance_type = 2 AND DATE(r.date_created) BETWEEN '{$date_start}' AND '{$date_end}' ORDER BY UNIX_TIMESTAMP(r.date_created) ASC");
                            while($row = $qry->fetch_assoc()):
                                $row['remarks'] = (stripslashes(html_entity_decode($row['remarks'])));
                                $total += $row['amount'];
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $i++ ?></td>
                            <td><?php echo date("M d, Y",strtotime($row['date_created'])) ?></td>
                            <td><?php echo $row['category'] ?></td>
                            <td><?php echo $row['expense_title'] ?></td>
                            <td class="text-right"><?php echo number_format($row['amount']) ?></td>
                            <td><div><?php echo $row['remarks'] ?></div></td>
                        </tr>
                        <?php endwhile; ?>
                    <?php if($qry->num_rows <= 0): ?>
                    <tr>
                        <td class="text-center" colspan="5">No Data...</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td class="text-right px-3" colspan="4"><b>Total</b></td>
                        <td class="text-right"><b><?php echo number_format($total) ?></b></td>
                        <td class="bg-gray"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('#filter-form').submit(function(e){
            e.preventDefault()
            location.href = "./?page=reports/budget&date_start="+$('[name="date_start"]').val()+"&date_end="+$('[name="date_end"]').val()
        })

        $('#printBTN').click(function () {
            var rep = $('#printable').clone();
            start_loader();
            var ns = $('head').clone();

            rep.prepend(ns);

            var nw = window.document.open('', '_blank', 'width=900,height=600');
            nw.document.write(rep.html());
            nw.document.close();

            // Add a CSS rule for printing to make the image flexible
            var printStyles = '<style>@media print { .card-image { max-width: 100%; height: auto; } }</style>';
            nw.document.head.innerHTML += printStyles;

            setTimeout(function () {
                nw.print();
                setTimeout(function () {
                    nw.close();
                    end_loader();
                }, 500);
            }, 500);
        });

    })
</script>