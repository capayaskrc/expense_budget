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
    c.id AS category_id,
    r.id,
    c.category,
    CONCAT(c.category, YEAR(r.date_created)) AS category_year,
    c.balance,
    YEAR(r.date_created) AS year,
    NULLIF(r.expense_title, '') AS expense_title,
    budget_subquery.budget AS budget,
    subquery.spent AS sub_spent,
    total_sub_spent.total AS total_sub_spent
FROM `running_balance` r
INNER JOIN `categories` c ON r.category_id = c.id
LEFT JOIN (
    SELECT category_id, YEAR(date_created) AS date_year, expense_title, SUM(amount) AS spent
    FROM `running_balance`
    WHERE balance_type = 2
    GROUP BY category_id, date_year, expense_title
) AS subquery ON c.id = subquery.category_id
AND YEAR(r.date_created) = subquery.date_year
AND NULLIF(r.expense_title, '') = subquery.expense_title
LEFT JOIN (
    SELECT category_id, YEAR(date_created) AS date_year, SUM(amount) AS budget
    FROM `running_balance`
    WHERE balance_type = 1
    GROUP BY category_id, date_year
) AS budget_subquery ON c.id = budget_subquery.category_id
AND YEAR(r.date_created) = budget_subquery.date_year
LEFT JOIN (
    SELECT category_id, SUM(spent) AS total
    FROM (
        SELECT category_id, YEAR(date_created) AS date_year, expense_title, SUM(amount) AS spent
        FROM `running_balance`
        WHERE balance_type = 2
        GROUP BY category_id, date_year, expense_title
    ) AS subquery
    GROUP BY category_id
) AS total_sub_spent ON c.id = total_sub_spent.category_id
WHERE c.status = 1
ORDER BY category_year, YEAR(r.date_created) DESC, expense_title;


");

                    $current_category = null;
                    $current_year = null;

                    while ($row = $qry->fetch_assoc()) {
                        $category_has_expense = $row['expense_title'] !== null;

                        if ($current_category !== $row['category'] || $current_year !== $row['year']) {
                            // Close the previous table if it's open
                            if ($current_category !== null && $current_year !== null) {
                                echo '</tbody>';
                                echo '</table>';
                            }

                            // Update the current category and year
                            $current_category = $row['category'];
                            $current_year = $row['year'];

                            // Display the category and year information
                            echo '<div class="category-container row mb-2">';
                            echo '<div class="col-5 ml-2"><strong>' . $current_category . ' ' . $current_year . '</strong></div>';
                            echo '<div class="col-2">Budget: ' . number_format($row['budget']) . '</div>';
                            echo '<div class="col-2">Total Spent: ' . number_format($row['total_sub_spent']) . '</div>';
                            echo '<div class="col-2">RB: ' . number_format($row['budget'] - $row['total_sub_spent']) . '</div>';
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
                        }
                        // Only display the row if it has a valid expense title
                        if ($category_has_expense) {
                            echo '<tr>';
                            echo '<td>' . $row['expense_title'] . '</td>';
                            echo '<td>' . number_format($row['sub_spent']) . '</td>';
                            echo "<td align='center'>
          <a class='manage_expense' href='javascript:void(0)' data-category='{$current_category}' data-year='{$current_year}'>
            <span class='fa fa-edit text-primary'></span>
          </a>
          <a class='delete_data' href='javascript:void(0)' data-id='{$row['id']}'  data-category='{$row['category_id']}'>
            <span class='fa fa-trash text-danger'></span>
          </a>
          </td>";
                            echo '</tr>';
                        }
                    }

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
            const category_id = $(this).attr('data-category');
            console.log(category_id);
            _conf("Are you sure to delete this expense permanently?", "delete_expense", [id, category_id]);
        })
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
