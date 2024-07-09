<?php
include_once("Header copy.php");
include_once("../DB_Files/db.php");

// Check if the action is to delete a notice
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $notice_id = $_GET['id'];

    // Delete the notice
    $sql = "DELETE FROM notices WHERE notice_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $notice_id);
    $stmt->execute();

    // Redirect back to post_notice.php after deletion
    echo "<script>window.location.href = 'post_notice.php';</script>";
    exit();
}

// Fetch notice to be edited if notice_id is provided
$edit_notice = null;
if (isset($_GET['id'])) {
    $notice_id = $_GET['id'];
    $sql = "SELECT * FROM notices WHERE notice_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $notice_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $edit_notice = $result->fetch_assoc();
}

// Check if the action is to edit a notice
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'edit') {
    $notice_id = $_POST['notice_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Update the notice
    $sql = "UPDATE notices SET title = ?, content = ? WHERE notice_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $title, $content, $notice_id);
    $stmt->execute();

    // Redirect back to manage_notices.php after edit
    echo "<script>window.location.href = 'post_notice.php';</script>";
    exit();
}

?>

<div class="container" style="padding-left:6%; margin-top:5%;">
    <h2>Edit Notice</h2>
    <form method="post" action="">
        <div class="form-group">
            <input type="hidden" name="notice_id" value="<?php echo $edit_notice['notice_id'] ?? ''; ?>">
            <label for="title">Title:</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo $edit_notice['title'] ?? ''; ?>" required>
        </div>
        <div class="form-group">
            <label for="content">Content:</label>
            <textarea class="form-control" id="content" name="content" rows="5" required><?php echo $edit_notice['content'] ?? ''; ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary" name="action" value="edit">Update Notice</button>
    </form>
</div>

<?php
include_once("Footer.php");
?>
