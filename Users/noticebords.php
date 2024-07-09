<?php
include_once("ProfileHeader.php");
include_once("../DB_Files/db.php");

if (!isset($_SESSION['stu_id'])) {
    // Redirect to the login page if not logged in
    header("Location: index.php");
    exit();
}

if (!isset($_GET['id'])) {
    // Redirect to the notice board if no notice ID is provided
    header("Location: notice_board.php");
    exit();
}

$notice_id = $_GET['id'];

// Step 1: Retrieve the Notice Details
$sql_notice = "SELECT * FROM notices WHERE notice_id = ?";
$stmt_notice = $conn->prepare($sql_notice);
$stmt_notice->bind_param("i", $notice_id);
$stmt_notice->execute();
$result_notice = $stmt_notice->get_result();

if ($result_notice->num_rows == 0) {
    // Redirect to the notice board if no notice is found
    header("Location: notice_board.php");
    exit();
}

$notice = $result_notice->fetch_assoc();
?>

<div class="container" style="padding-left:6%; margin-top:5%;">
    <h2>Notice Details</h2>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title"><?php echo htmlspecialchars($notice['title']); ?></h5>
            <p class="card-text"><?php echo nl2br(htmlspecialchars($notice['content'])); ?></p>
            <a href="notice bord.php" class="btn btn-primary">Back to Notice Board</a>
        </div>
    </div>
</div>

