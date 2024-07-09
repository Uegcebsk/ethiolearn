<?php
ob_start(); // Start output buffering
include_once("Header copy.php");
include_once("../DB_Files/db.php");

// Function to send or edit reply
function sendReply($feedback_id, $reply_content, $conn) {
    $feedback_id = mysqli_real_escape_string($conn, $feedback_id);
    $reply_content = mysqli_real_escape_string($conn, $reply_content);

    // Check if a reply already exists for the feedback
    $check_sql = "SELECT * FROM replies WHERE feedback_id = '$feedback_id'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        // If a reply exists, update it
        $edit_sql = "UPDATE replies SET reply_content = '$reply_content', edited = 1, edit_time = NOW() WHERE feedback_id = '$feedback_id'";
        $result = $conn->query($edit_sql);
    } else {
        // If no reply exists, insert a new reply
        $insert_sql = "INSERT INTO replies (feedback_id, reply_content, reply_time) VALUES ('$feedback_id', '$reply_content', NOW())";
        $result = $conn->query($insert_sql);
    }
    return $result;
}

// Process reply sending or editing
if (isset($_POST['send_reply'])) {
    $feedback_id = $_POST['feedback_id'];
    $reply_content = $_POST['reply_content'];

    $result = sendReply($feedback_id, $reply_content, $conn);
    if ($result) {
        $reply_status = 'Reply sent successfully';
    }
}

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

// Delete reply if requested
if (isset($_POST['delete']) && isset($_POST['id'])) {
    $delete_id = mysqli_real_escape_string($conn, $_POST['id']);
    $sql_delete_reply = "DELETE FROM replies WHERE reply_id='$delete_id'";
    if ($conn->query($sql_delete_reply) === TRUE) {
        echo '<meta http-equiv="refresh" content="0;URL=?deleted"/>';
    } else {
        echo "Delete Failed";
    }
}
include_once("Header copy.php");
include_once("../DB_Files/db.php");

// Function to handle testimonial approval
function approveTestimonial($feedback_id, $approved, $conn) {
    $feedback_id = mysqli_real_escape_string($conn, $feedback_id);
    $approved = mysqli_real_escape_string($conn, $approved);

    // Update the 'approved' field for the testimonial in the database
    $sql_update = "UPDATE feedback SET approved = '$approved' WHERE f_id = '$feedback_id'";
    $result = $conn->query($sql_update);

    return $result;
}
// Process testimonial approval
if (isset($_POST['approve'])) {
    $feedback_id = $_POST['feedback_id'];
    $approved = 1;

    $result = approveTestimonial($feedback_id, $approved, $conn);
    if ($result) {
        $approval_status = 'Testimonial approved successfully';
        // Redirect or refresh the page after approval
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    }
}

// Process testimonial disapproval
if (isset($_POST['disapprove'])) {
    $feedback_id = $_POST['feedback_id'];
    $approved = 0;

    $result = approveTestimonial($feedback_id, $approved, $conn);
    if ($result) {
        $approval_status = 'Testimonial disapproved successfully';
        // Redirect or refresh the page after disapproval
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Management</title>
    <style>
        /* Modal CSS styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            right: 50%;
            width: 50%;
            height: 50%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .pagination {
            margin-top: 20px;
            text-align: center;
        }

        .pagination a {
            padding: 8px 12px;
            margin: 0 4px;
            border: 1px solid #ccc;
            background-color: #f8f9fa;
            color: #333;
            text-decoration: none;
            border-radius: 4px;
        }

        .pagination a.active {
            background-color: #007bff;
            color: #fff;
        }
        .container{
            padding: 5%;
        } </style>
</head>
<body>
    <div class="container">
<div class="col-sm-12 mt-6">
    <p class="bg-dark text-white p-2">List of Feedback</p>
    <div class="search-bar">
        <form id="searchForm" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="search_text" name="search_text" placeholder="Search by Student Name">
                <select name="itemsPerPage" id="itemsPerPage" class="form-select">
                    <option value="5" <?php if(isset($_GET['itemsPerPage']) && $_GET['itemsPerPage'] == 5) echo 'selected'; ?>>5 per page</option
                    <option value="10" <?php if(isset($_GET['itemsPerPage']) && $_GET['itemsPerPage'] == 10) echo 'selected'; ?>>10 per page</option>
                    <option value="20" <?php if(isset($_GET['itemsPerPage']) && $_GET['itemsPerPage'] == 20) echo 'selected'; ?>>20 per page</option>
                </select>
            </div>
        </form>
    </div>
    <div id="feedbackTable">
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
                                    <td class="text-dark fw-bolder">
                                    <td class="text-dark fw-bolder">
                                    <td class="text-dark fw-bolder">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <input type="hidden" name="feedback_id" value="<?php echo $row['f_id']; ?>">
        <?php if ($row['approved'] == 1): ?>
            <button type="submit" class="btn btn-success" name="disapprove" onclick="return confirm('Are you sure you want to disapprove this testimonial?')">Approved</button>
        <?php else: ?>
            <button type="submit" class="btn btn-primary" name="approve" onclick="return confirm('Are you sure you want to approve this testimonial?')">Approve</button>
        <?php endif; ?>
    </form>
</td>

</td>


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

    <!-- Modal -->
    <div class="modal" id="replyModal">
        <div class="modal-content">
            <h5>Reply to Feedback</h5>
            <form action="" method="POST">
                <label for="reply_content">Your Reply</label>
                <textarea class="form-control" id="reply_content" name="reply_content" rows="3" maxlength="255" required></textarea>
                <input type="hidden" id="feedback_id" name="feedback_id" value="">
                <br>
                <button type="button" onclick="toggleModal('replyModal')">Close</button>
                <button type="submit" name="send_reply">Send Reply</button>
            </form>
        </div>
    </div>
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

    // Function to perform live search while typing
    document.getElementById('search_text').addEventListener('input', function() {
        var form = document.getElementById('searchForm');
        var formData = new FormData(form);
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    document.getElementById('feedbackTable').innerHTML = xhr.responseText;
                } else {
                    console.error('Failed to retrieve data');
                }
            }
        };
        xhr.open('GET', '<?php echo $_SERVER['PHP_SELF']; ?>?' + new URLSearchParams(formData).toString());
        xhr.send();
    });

    // Function to handle changes in items per page
    document.getElementById('itemsPerPage').addEventListener('change', function() {
        var form = document.getElementById('searchForm');
        var formData = new FormData(form);
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    document.getElementById('feedbackTable').innerHTML = xhr.responseText;
                } else {
                    console.error('Failed to retrieve data');
                }
            }
        };
        xhr.open('GET', '<?php echo $_SERVER['PHP_SELF']; ?>?' + new URLSearchParams(formData).toString());
        xhr.send();
    });
</script>
</body>
</html>

<?php
include_once("Footer.php");
?>
<?php
ob_end_flush(); // Flush the output buffer
?>

<?php

