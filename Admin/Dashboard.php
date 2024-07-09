<?php
include_once("Header.php");
include_once("../DB_Files/db.php");

// Fetch data for different metrics
$sql = "SELECT * FROM course";
$result = $conn->query($sql);
$tot_course = $result->num_rows;

$sql = "SELECT * FROM students WHERE email_verified=1";
$result = $conn->query($sql);
$tot_stu = $result->num_rows;

$sql = "SELECT * FROM certificates";
$result = $conn->query($sql);
$tot_certified = $result->num_rows;

$sql = "SELECT * FROM lectures";
$result = $conn->query($sql);
$tot_lec = $result->num_rows;

$sql = "SELECT MONTHNAME(date) AS month, COUNT(*) AS total_orders FROM courseorder GROUP BY MONTH(date)";
$order_result = $conn->query($sql);
$order_data = array_fill(0, 12, 0);
while ($row = $order_result->fetch_assoc()) {
    $month = date('m', strtotime($row['month']));
    $order_data[$month - 1] = $row['total_orders'];
}
?>

<div class="container" style="padding:5%;">
    <div id="content">
        <div class="container-fluid">
            <div class="row">

                <!-- Total Courses Card -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card bg-transparent border-secondary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">Total Courses</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $tot_course; ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-book fa-2x text-danger"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <a href="Course.php" class="btn btn-outline-dark btn-sm btn-block">View Details</a>
                        </div>
                    </div>
                </div>

                <!-- Certified Students Card -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card bg-transparent border-secondary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">Certified Students</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $tot_certified; ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-graduation-cap fa-2x text-success"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <a href="certified.php" class="btn btn-outline-dark btn-sm btn-block">View Details</a>
                        </div>
                    </div>
                </div>

                <!-- Total Students Card -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card bg-transparent border-secondary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">Total Students</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $tot_stu; ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-primary"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <a href="Students.php" class="btn btn-outline-dark btn-sm btn-block">View Details</a>
                        </div>
                    </div>
                </div>

                <!-- Total Lecturers Card -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card bg-transparent border-secondary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">Total Lecturers</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $tot_lec; ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-chalkboard-teacher fa-2x text-warning"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <a href="Lectures.php" class="btn btn-outline-dark btn-sm btn-block">View Details</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Chart for Course Orders -->
                <div class="col-lg-8 mb-4">
                    <div class="card bg-transparent border-secondary shadow h-100">
                        <div class="card-header bg-transparent border-bottom">
                            <h6 class="m-0 font-weight-bold text-dark">Course Orders Overview</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="courseOrdersChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Recent Course Orders Table -->
                <div class="col-lg-4 mb-4">
                    <div class="card bg-transparent border-secondary shadow h-100">
                        <div class="card-header bg-transparent border-bottom">
                            <h6 class="m-0 font-weight-bold text-dark">Recent Course Orders</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>student name</th>
                                            <th>ordered course</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT * FROM courseorder ORDER BY date DESC LIMIT 5";
                                        $result = $conn->query($sql);
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . $row['order_id'] . "</td>";
                                            echo "<td>" . $row['stu_name'] . "</td>";
                                            echo "<td>" . $row['course_name'] . "</td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/ethiolearn/bootstrap/js/chart.js"></script>
<script>
    // Course Orders Chart
    var ctx = document.getElementById('courseOrdersChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Course Orders',
                data: <?php echo json_encode($order_data); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Monthly Course Orders',
                    font: {
                        size: 16,
                        weight: 'bold'
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 14
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        display: true,
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    ticks: {
                        font: {
                            size: 14
                        }
                    }
                }
            },
            animation: {
                duration: 1500,
                easing: 'easeInOutQuad'
            }
        }
    });
</script>

<?php
include_once("Footer.php");
?>
