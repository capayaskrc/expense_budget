<?php if($_settings->chk_flashdata('success')): ?>
    <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>",'success');
    </script>
<?php endif; ?>
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
                <table class=" table-bordered table-stripped">
                    <?php
                    $i = 1;
                    $qry = $conn->query("
                    SELECT 
                        category_id, 
                        id,
                        category,
                        category_year,
                        balance, 
                        year,
                        expense_title,
                        budget,
                        sub_spent,
                        total_sub_spent
                    FROM (
                        SELECT 
                            c.id AS category_id, 
                            r.id,
                            c.category,
                            CONCAT(c.category, ' (', YEAR(r.date_created), ')') AS category_year,
                            c.balance, 
                            YEAR(r.date_created) AS year,
                            NULLIF(r.expense_title, '') AS expense_title,
                            budget_subquery.budget AS budget,
                            subquery.spent AS sub_spent,
                            total_sub_spent.total AS total_sub_spent
                        FROM `running_balance` r 
                        INNER JOIN `categories` c ON r.category_id = c.id 
                        LEFT JOIN (
                            SELECT category_id, YEAR(date_created), SUM(amount) AS spent
                            FROM `running_balance`
                            WHERE balance_type = 2
                            GROUP BY category_id, YEAR(date_created)
                        ) AS subquery
                        ON c.id = subquery.category_id
                        LEFT JOIN (
                            SELECT category_id, YEAR(date_created) AS date_year, SUM(amount) AS budget
                            FROM `running_balance`
                            WHERE balance_type = 1
                            GROUP BY category_id, date_year
                        ) AS budget_subquery
                        ON c.id = budget_subquery.category_id AND YEAR(r.date_created) = budget_subquery.date_year
                        LEFT JOIN (
                            SELECT category_id, SUM(spent) AS total
                            FROM (
                                SELECT category_id, YEAR(date_created), SUM(amount) AS spent
                                FROM `running_balance`
                                WHERE balance_type = 2
                                GROUP BY category_id, YEAR(date_created)
                            ) AS subquery
                            GROUP BY category_id
                        ) AS total_sub_spent
                        ON c.id = total_sub_spent.category_id
                        WHERE c.status = 1 
                        GROUP BY c.id, category, c.balance, year, expense_title, total_sub_spent.total
                    ) AS subquery
                    WHERE category_year = CONCAT(category, ' (', year, ')')  -- Filter by category_year
                    ORDER BY category_year, year DESC, expense_title;
");

                    $current_category = "";
                    $current_year = "";
                    while ($row = $qry->fetch_assoc()):
                        // Check if there are expenses for this category (where the type is "expense")
                        $category_has_expense = $row['expense_title'] !== null;

                        // Extract the year from the category_year field
                        $category_year = preg_match('/\((\d{4})\)$/', $row['category_year'], $matches) ? $matches[1] : '';

                        if ($category_has_expense && $current_category != $row['category']):
                            if ($current_category != "") {
                                // Close the previous table if it's open
                                echo '</tbody>';
                                echo '</table>';
                            }

                            $current_category = $row['category'];
                            $current_year = $category_year;
                            $category_id = $row['category_id'];
                            $expense_id = $row['id'];

                            echo '<div class="category-container row mb-2">';
                            echo '<div class="col-5 ml-2"><strong>' . $current_category . ' ' . $current_year . '</strong></div>';
                            echo '<div class="col-2">Budget: ' . number_format($row['budget']) . '</div>';
                            echo '<div class="col-2">Total Spent: ' . number_format($row['total_sub_spent']) . '</div>';
                            echo '<div class="col-2">RB: ' . number_format($row['budget'] - $row['sub_spent']) . '</div>';
                            echo '</div>';
                            echo '<table class="table table-bordered table-stripped">';
                            echo '<thead>';
                            echo '<tr>';
                            echo '<th class="col-4">Subcategory</th>';
                            echo '<th class="col-4">Spent</th>';
                            echo '<th class="col-4">Action</th>';
                            echo '</tr>';
                            echo '</thead>';
                            echo '<tbody>';
                        endif;

                        // Only display the row if it has a valid expense title and the years match
                        if ($category_has_expense && $current_year == $category_year) {
                            echo '<tr>';
                            echo '<td>' . $row['expense_title'] . '</td>';
                            echo '<td>' . number_format($row['sub_spent']) . '</td>';
                            echo "<td align='center'>
              <a class='manage_expense' href='javascript:void(0)' data-category='{$current_category}' data-year='{$current_year}'>
                <span class='fa fa-edit text-primary'></span>
              </a>
              <a class='delete_data' href='javascript:void(0)' data-category-id='{$category_id}' data-id='{$row['id']}' data-year='{$current_year}'>
                <span class='fa fa-trash text-danger'></span>
              </a>
          </td>";
                            echo '</tr>';
                        }

                    endwhile;

                    if ($current_category == "") {
                        echo '<p>No expenses found.</p>';
                    } else {
                        // Close the last table if it's still open
                        echo '</tbody>';
                        echo '</table>';
                    }


                    ?>


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
            const id = $(this).attr('data-id');
            console.log(id);
            const category_id = $(this).attr('data-category_id');
            console.log(category_id);
            _conf("Are you sure to delete this expense permanently?", "delete_expense", [id, category_id]);
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
            });
        });
        $('.table').dataTable({
            columnDefs: [
                { orderable: false, targets: 5 }
            ],
            order: [[0, 'asc']]
        });
    })
    function delete_expense(id, category_id) {
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=delete_expense",
            method: "POST",
            data: {
                id: id,
                category_id: category_id
            },
            dataType: "json",
            error: function (err) {
                console.log(err);
                alert_toast("An error occurred.", 'error');
                end_loader();
            },
            success: function (resp) {
                if (resp.status === 'success') {
                    location.reload();
                } else {
                    alert_toast("An error occurred.", 'error');
                    end_loader();
                }
            }
        });
    }
</script>
