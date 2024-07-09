<?php
include_once("Header.php");
include_once("../DB_Files/db.php");

// Pagination
$limit = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Search term
$search_term = isset($_GET['search']) ? $_GET['search'] : '';

// Fetch activities
$sql = "SELECT l.l_name, c.course_name, 'Added Material' AS activity_type, m.upload_date AS activity_timestamp
        FROM lectures l
        JOIN course c ON l.l_id = c.lec_id
        JOIN materials m ON c.course_id = m.course_id
        WHERE l.l_name LIKE '%$search_term%'
        UNION
        SELECT l.l_name, c.course_name, 'Added Lesson' AS activity_type, lsn.lesson_timestamp AS activity_timestamp
        FROM lectures l
        JOIN course c ON l.l_id = c.lec_id
        JOIN lesson lsn ON c.course_id = lsn.course_id
        WHERE l.l_name LIKE '%$search_term%'
        UNION
        SELECT l.l_name, c.course_name, 'Added Exam' AS activity_type, ec.catagory_timestamp AS activity_timestamp
        FROM lectures l
        JOIN course c ON l.l_id = c.lec_id
        JOIN exam_category ec ON c.course_id = ec.course_id
        WHERE ec.active = 1 AND ec.assessment_type = 'exam' AND l.l_name LIKE '%$search_term%'
        UNION
        SELECT l.l_name, c.course_name, 'Added Quiz' AS activity_type, ec.catagory_timestamp AS activity_timestamp
        FROM lectures l
        JOIN course c ON l.l_id = c.lec_id
        JOIN exam_category ec ON c.course_id = ec.course_id
        WHERE ec.active = 1 AND ec.assessment_type = 'quiz' AND l.l_name LIKE '%$search_term%'
        ORDER BY activity_timestamp DESC
        LIMIT $limit OFFSET $offset";

$result = $conn->query($sql);
?>

<div class="container" style="padding:5%;">
    <div id="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <div class="card ">
                        <div class="card-header" >
                            <h6 class="m-0 font-weight-bold text-dark">Recent Lecturer Activities</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <form id="searchForm" class="form-inline">
                                    <input type="text" class="form-control mr-sm-2" id="search" name="search" placeholder="Search by lecture name" value="<?php echo $search_term; ?>">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </form>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Lecturer Name</th>
                                            <th>Course Name</th>
                                            <th>Activity Type</th>
                                            <th>Timestamp</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td>" . $row['l_name'] . "</td>";
                                                echo "<td>" . $row['course_name'] . "</td>";
                                                echo "<td>" . $row['activity_type'] . "</td>";
                                                echo "<td>" . $row['activity_timestamp'] . "</td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='4'>No recent activities found.</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php
                            // Pagination
                            $sql = "SELECT COUNT(*) AS total FROM ($sql) AS activities";
                            $result = $conn->query($sql);
                            $row = $result->fetch_assoc();
                            $total_pages = ceil($row['total'] / $limit);
                            ?>
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
                                    <?php if ($page > 1) : ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?page=<?php echo ($page - 1); ?><?php echo !empty($search_term) ? '&search=' . $search_term : ''; ?>" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                                        <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                                            <a class="page-link" href="?page=<?php echo $i; ?><?php echo !empty($search_term) ? '&search=' . $search_term : ''; ?>"><?php echo $i; ?></a>
                                        </li>
                                    <?php endfor; ?>
                                    <?php if ($page < $total_pages) : ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?page=<?php echo ($page + 1); ?><?php echo !empty($search_term) ? '&search=' . $search_term : ''; ?>" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Handle search form submission
    document.getElementById('searchForm').addEventListener('submit', function(event) {
        event.preventDefault();
        var searchValue = document.getElementById('search').value;
        window.location.href = 'track_lectures.php?search=' + searchValue;
    });
</script>

<?php
include_once("Footer.php");
?>
