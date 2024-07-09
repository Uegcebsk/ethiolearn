<?php
ob_start(); // Start output buffering
include_once("Header.php");
include_once("../DB_Files/db.php");

// Function to send or edit reply
function sendReply($feedback_id, $reply_content, $conn) {
    // Implementation as per your requirements
}

// Function to handle testimonial approval
function approveTestimonial($feedback_id, $approved, $conn) {
    $feedback_id = mysqli_real_escape_string($conn, $feedback_id);
    $approved = (int) $approved; // Ensure $approved is treated as integer for database safety

    // Update the feedback with approval status
    $sql_update = "UPDATE feedback SET approved = $approved WHERE f_id = '$feedback_id'";
    $result = $conn->query($sql_update);

    return $result;
}

// Function to handle testimonial deletion
function deleteTestimonial($feedback_id, $conn) {
    $feedback_id = mysqli_real_escape_string($conn, $feedback_id);

    // Delete the feedback from the database
    $sql_delete = "DELETE FROM feedback WHERE f_id = '$feedback_id'";
    $result = $conn->query($sql_delete);

    // Also delete associated replies if needed
    // Example: DELETE FROM replies WHERE feedback_id = '$feedback_id';

    return $result;
}

// Process reply sending or editing
if (isset($_POST['send_reply'])) {
    // Functionality remains unchanged as per your previous implementation
}

// Process testimonial approval
if (isset($_POST['approve'])) {
    $feedback_id = $_POST['feedback_id'];
    $result = approveTestimonial($feedback_id, 1, $conn); // Approve (assuming 1 means approved)
    if ($result) {
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    }
}

// Process testimonial disapproval
if (isset($_POST['disapprove'])) {
    $feedback_id = $_POST['feedback_id'];
    $result = approveTestimonial($feedback_id, 0, $conn); // Disapprove (assuming 0 means disapproved)
    if ($result) {
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    }
}

// Process testimonial deletion
if (isset($_POST['delete'])) {
    $feedback_id = $_POST['id'];

    $result = deleteTestimonial($feedback_id, $conn);
    if ($result) {
        // Redirect or refresh the page after deletion
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    }
}

// Pagination settings and SQL query for feedback retrieval
$itemsPerPage = isset($_GET['itemsPerPage']) ? (int)$_GET['itemsPerPage'] : 5; // Default items per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
$offset = ($page - 1) * $itemsPerPage; // Calculate offset

$search_text = isset($_GET['search_text']) ? $_GET['search_text'] : '';
$sql_select_feedback = "SELECT f.*, co.stu_name, r.reply_content AS reply_content, r.reply_time AS reply_time, r.reply_id AS reply_id
                        FROM feedback f
                        INNER JOIN courseorder co ON f.stu_id = co.stu_id
                        INNER JOIN course c ON co.course_id = c.course_id
                        LEFT JOIN replies r ON f.f_id = r.feedback_id";
if (!empty($search_text)) {
    $sql_select_feedback .= " WHERE co.stu_name LIKE '%$search_text%'";
}

$sql_select_feedback .= " ORDER BY f.feedback_time DESC
                          LIMIT $offset, $itemsPerPage";

$result = $conn->query($sql_select_feedback);

// Count total feedback for pagination
$sql_count_feedback = "SELECT COUNT(*) AS total 
                       FROM feedback f
                       INNER JOIN courseorder co ON f.stu_id = co.stu_id
                       INNER JOIN course c ON co.course_id = c.course_id
                       LEFT JOIN replies r ON f.f_id = r.feedback_id";
if (!empty($search_text)) {
    $sql_count_feedback .= " WHERE co.stu_name LIKE '%$search_text%'";
}

$totalItemsRow = $conn->query($sql_count_feedback)->fetch_assoc();
$totalItems = $totalItemsRow['total'];
$totalPages = ceil($totalItems / $itemsPerPage);

// Prepare HTML for table body
ob_start(); // Start output buffering for HTML generation

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        ?>
        <tr>
            <td class="text-dark fw-bolder"><?php echo htmlspecialchars($row['stu_name']); ?></td>
            <td class="text-dark fw-bolder"><?php echo htmlspecialchars($row['f_content']); ?> - <?php echo date('l, F j, Y g:i A', strtotime($row['feedback_time'])); ?></td>
            <td class="text-dark fw-bolder"><?php echo htmlspecialchars($row['reply_content'] ? substr($row['reply_content'], 0, 50) . '...' : ''); ?></td>
            <td class="text-dark fw-bolder">
                <button type="button" class="btn btn-primary" onclick="toggleModal('<?php echo htmlspecialchars($row['f_id']); ?>')">Reply</button>
                <!-- Form for delete button -->
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="d-inline">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['f_id']); ?>">
                    <button type="submit" class="btn btn-secondary" name="delete" value="Delete">
                        <i class="uil uil-trash-alt"></i>
                    </button>
                </form>
                <!-- Approve/disapprove buttons form -->
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="d-inline">
                    <input type="hidden" name="feedback_id" value="<?php echo htmlspecialchars($row['f_id']); ?>">
                    <?php if ($row['approved'] == 1): ?>
                        <button type="submit" class="btn btn-success" name="disapprove" onclick="return confirm('Are you sure you want to disapprove this testimonial?')">Approved</button>
                    <?php else: ?>
                        <button type="submit" class="btn btn-primary" name="approve" onclick="return confirm('Are you sure you want to approve this testimonial?')">Approve</button>
                    <?php endif; ?>
                </form>
            </td>
        </tr>
        <?php
    }
} else {
    echo '<tr><td colspan="4" class="text-dark fw-bolder">No feedback found.</td></tr>';
}

$tableBodyHTML = ob_get_clean(); // Get the generated HTML

// Prepare JSON response for AJAX requests
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    $response = [
        'html' => $tableBodyHTML,
    ];
    echo json_encode($response);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Management</title>
    <style>
        /* Styles remain the same as your previous code */
    </style>
</head>
<body>
    <div class="container">
        <!-- Your HTML content as before -->
    </div>

    <script>
        // JavaScript functions remain the same as your previous code
    </script>
</body>
</html>

<?php
include_once("Footer.php");
ob_end_flush(); // Flush the output buffer
?>
