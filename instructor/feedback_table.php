<?php
// Include necessary files and start sessions if required
include_once("Header copy.php");
include_once("../DB_Files/db.php");

// Assuming $lec_id contains the instructor's ID
$lec_id = $_SESSION['l_id'];

// Pagination settings
$itemsPerPage = isset($_GET['itemsPerPage']) ? (int)$_GET['itemsPerPage'] : 5; // Default items per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
$offset = ($page - 1) * $itemsPerPage; // Calculate offset

// Retrieve feedback for courses taught by the instructor with pagination
$search_text = isset($_GET['search_text']) ? $_GET['search_text'] : '';
$sql_select_feedback = "SELECT f.*, co.stu_name, r.reply_content AS reply_content, r.reply_time AS reply_time, r.reply_id AS reply_id
                        FROM feedback f
                        INNER JOIN courseorder co ON f.stu_id = co.stu_id
                        INNER JOIN course c ON co.course_id = c.course_id
                        LEFT JOIN replies r ON f.f_id = r.feedback_id
                        WHERE c.lec_id = '$lec_id'";
if (!empty($search_text)) {
    $sql_select_feedback .= " AND co.stu_name LIKE '%$search_text%'";
}

$sql_select_feedback .= " ORDER BY f.feedback_time DESC
                          LIMIT $offset, $itemsPerPage";

$result = $conn->query($sql_select_feedback);

// Count total feedback for pagination
$sql_count_feedback = "SELECT COUNT(*) AS total 
                       FROM feedback f
                       INNER JOIN courseorder co ON f.stu_id = co.stu_id
                       INNER JOIN course c ON co.course_id = c.course_id
                       LEFT JOIN replies r ON f.f_id = r.feedback_id
                       WHERE c.lec_id = '$lec_id'";
if (!empty($search_text)) {
    $sql_count_feedback .= " AND co.stu_name LIKE '%$search_text%'";
}

$totalItemsRow = $conn->query($sql_count_feedback)->fetch_assoc();
$totalItems = $totalItemsRow['total'];
$totalPages = ceil($totalItems / $itemsPerPage);
?>

<div class="col-sm-9 mt-5">
    <!-- Feedback table -->
    <div class="container mt-3">
        <?php if ($result->num_rows > 0): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-dark fw-bolder">Student Name</th>
                        <th class="text-dark fw-bolder">Feedback</th>
                        <th class="text-dark fw-bolder">Reply</th>
                        <th class="text-dark fw-bolder">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="text-dark fw-bolder"><?php echo $row['stu_name']; ?></td>
                            <td class="text-dark fw-bolder"><?php echo $row['f_content']; ?> - <?php echo date('l, F j, Y g:i A', strtotime($row['feedback_time'])); ?></td>
                            <td class="text-dark fw-bolder"><?php echo $row['reply_content'] ? substr($row['reply_content'], 0, 50) . '...' : ''; ?></td>
                            <td class="text-dark fw-bolder">
                                <button type="button" class="btn btn-primary" onclick="toggleModal('<?php echo $row['f_id']; ?>')">Reply</button>
                                <form action="" method="POST" class="d-inline">
                                    <input type="hidden" name="id" value="<?php echo $row['reply_id']; ?>">
                                    <button type="submit" class="btn btn-secondary" name="delete" value="Delete">
                                        <i class="uil uil-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <!-- Pagination -->
            <div class="pagination" id="pagination">
                <?php if ($totalPages > 1): ?>
                    <a href="?page=1&itemsPerPage=<?php echo $itemsPerPage; ?>&search_text=<?php echo isset($_GET['search_text']) ? $_GET['search_text'] : ''; ?>">&laquo; First</a>
                    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                        <a href="?page=<?php echo $i; ?>&itemsPerPage=<?php echo $itemsPerPage; ?>&search_text=<?php echo isset($_GET['search_text']) ? $_GET['search_text'] : ''; ?>" class="<?php echo $i == $page ? 'active' : ''; ?>"><?php echo $i; ?></a>
                    <?php endfor; ?>
                    <a href="?page=<?php echo $totalPages; ?>&itemsPerPage=<?php echo $itemsPerPage; ?>&search_text=<?php echo isset($_GET['search_text']) ? $_GET['search_text'] : ''; ?>">Last &raquo;</a>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <p class="text-dark p-2 fw-bolder">No feedback found.</p>
        <?php endif; ?>
    </div>
</div>
<script>
    // JavaScript function to toggle modal visibility
    function toggleModal(feedbackId) {
        var modal = document.getElementById('replyModal');
        var feedbackIdInput = document.getElementById('feedback_id');
        modal.style.display = (modal.style.display === "none" || modal.style.display === "") ? "block" : "none";
        feedbackIdInput.value = feedbackId;
    }
</script>

<?php
// Include footer or any other scripts if required
include_once("Footer.php");
?>
