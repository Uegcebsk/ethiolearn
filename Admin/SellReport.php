<?php
include_once("Header.php");
include_once("../DB_Files/db.php");

// Fetch all courses for filtering
$sql_courses = "SELECT * FROM course";
$result_courses = $conn->query($sql_courses);

// Set default values for pagination
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$records_per_page = 10;
$offset = ($page - 1) * $records_per_page;

// Variables to store form input values
$start = isset($_POST['start']) ? $_POST['start'] : '';
$end = isset($_POST['end']) ? $_POST['end'] : '';
$course_id = isset($_POST['course_id']) ? $_POST['course_id'] : '';
$order_id = isset($_POST['order_id']) ? $_POST['order_id'] : '';
$stu_name = isset($_POST['stu_name']) ? $_POST['stu_name'] : '';

// Build the WHERE clause for search
$where_clause = "1=1";
if (!empty($start) && !empty($end)) {
    // Convert the date format to match the database format (YYYY-MM-DD)
    $start = date('Y-m-d', strtotime($start));
    $end = date('Y-m-d', strtotime($end));
    $where_clause .= " AND date BETWEEN '$start' AND '$end'";
}
if (!empty($course_id)) {
    $where_clause .= " AND course_id = '$course_id'";
}
if (!empty($order_id)) {
    $where_clause .= " AND order_id = '$order_id'";
}
if (!empty($stu_name)) {
    $where_clause .= " AND stu_name LIKE '%$stu_name%'";
}

// Fetch records based on the selected date range, course, order ID, student name
$sql = "SELECT COUNT(*) AS total_records FROM courseorder WHERE $where_clause";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$total_records = $row['total_records'];

$total_pages = ceil($total_records / $records_per_page);

$sql = "SELECT * FROM courseorder WHERE $where_clause ORDER BY amount DESC LIMIT $offset, $records_per_page";
$result = $conn->query($sql);

// Variables to store total sales amount
$total_sales = 0;
$free_courses = [];
$paid_courses = [];

while ($row = $result->fetch_assoc()) {
    // Separate free and paid courses
    if ($row['amount'] == 0) {
        $free_courses[] = $row;
    } else {
        $paid_courses[] = $row;
        // Calculate total sales
        $total_sales += (float)$row["amount"];
    }
}

?>

<div class="container" style="padding: 6%;">
    <div class="col-sm-12 mt-5">
        <p class="bg-dark text-white p-2">Sales Report</p>
        <form class="form-inline" method="POST" action="">
            <label for="start">From:</label>
            <input type="date" name="start" id="start" class="form-control mr-2" value="<?php echo $start; ?>">
            <label for="end">To:</label>
            <input type="date" name="end" id="end" class="form-control mr-2" value="<?php echo $end; ?>">
            <label for="course_id">Course:</label>
            <select name="course_id" id="course_id" class="form-control mr-2">
                <option value="">All Courses</option>
                <?php
                while ($row_course = $result_courses->fetch_assoc()) {
                    echo '<option value="' . $row_course["course_id"] . '" ' . ($course_id == $row_course["course_id"] ? 'selected' : '') . '>' . $row_course["course_name"] . '</option>';
                }
                ?>
            </select>
            <label for="order_id">Order ID:</label>
            <input type="text" name="order_id" id="order_id" class="form-control mr-2" value="<?php echo $order_id; ?>">
            <label for="stu_name">Student Name:</label>
            <input type="text" name="stu_name" id="stu_name" class="form-control mr-2" value="<?php echo $stu_name; ?>">
            <input type="submit" class="btn btn-secondary" name="searchsubmit" value="View">
        </form>

        <?php
        // Display paid courses
        if (!empty($paid_courses)) {
            echo '<br><h3>Paid Courses</h3>';
            echo '<table class="table">';
            echo '<thead><tr><th>Order ID</th><th>Course Name</th><th>Student Name</th><th>Order Date</th><th>Amount</th></tr></thead>';
            echo '<tbody>';
            foreach ($paid_courses as $course) {
                echo '<tr>';
                echo '<td>' . $course['order_id'] . '</td>';
                echo '<td>' . $course['course_name'] . '</td>';
                echo '<td>' . $course['stu_name'] . '</td>';
                echo '<td>' . $course['date'] . '</td>';
                echo '<td>' . number_format((float)$course['amount'], 2) . ' birr</td>';
                echo '</tr>';
            }
            echo '</tbody></table>';
            // Display total sales amount
            echo '<br><div>Total Sales for Paid Courses: ' . number_format($total_sales, 2) . ' birr</div>';
            // Add export to Excel button
            echo '<br><a href="export_sales.php?start=' . $start . '&end=' . $end . '&course_id=' . $course_id . '&order_id=' . $order_id . '&stu_name=' . $stu_name . '" class="btn btn-success">Export to Excel</a>';
        }

        // Display free courses
        if (!empty($free_courses)) {
            echo '<br><h3>Free Courses</h3>';
            echo '<table class="table">';
            echo '<thead><tr><th>Order ID</th><th>Course Name</th><th>Student Name</th><th>Order Date</th><th>Amount</th></tr></thead>';
            echo '<tbody>';
            foreach ($free_courses as $course) {
                echo '<tr>';
                echo '<td>' . $course['order_id'] . '</td>';
                echo '<td>' . $course['course_name'] . '</td>';
                echo '<td>' . $course['stu_name'] . '</td>';
                echo '<td>' . $course['date'] . '</td>';
                echo '<td>' . number_format((float)$course['amount'], 2) . ' birr</td>';
                echo '</tr>';
            }
            echo '</tbody></table>';
        }

        // Display pagination
        echo '<br><ul class="pagination">';
        for ($i = 1; $i <= $total_pages; $i++) {
            echo '<li class="page-item"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
        }
        echo '</ul>';
        ?>

    </div>
</div>
<script>
    // Enable searching while typing
    const searchForm = document.querySelector('.form-inline');
    const inputs = searchForm.querySelectorAll('input, select');

    inputs.forEach(input => {
        input.addEventListener('input', () => {
            searchForm.submit();
        });
    });
</script>

<?php
include_once("Footer.php");
?>
