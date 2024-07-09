<?php
include_once("Header copy.php");
include_once("../DB_Files/db.php");

// Define variables to store feedback messages
$feedback = '';
$error = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate form inputs
    if (empty($_POST['course_id'])) {
        $error = "Please select a course.";
    } elseif (empty($_POST['title'])) {
        $error = "Please enter a title for the notice.";
    } elseif (empty($_POST['content'])) {
        $error = "Please enter the content of the notice.";
    } else {
        // No errors, proceed with inserting the notice into the database
        $lecturer_id = $_SESSION['l_id'];
        $course_id = $_POST['course_id'];
        $title = $_POST['title'];
        $content = $_POST['content'];

        $sql = "INSERT INTO notices (lecturer_id, course_id, title, content) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiss", $lecturer_id, $course_id, $title, $content);
        $stmt->execute();

        // Get the ID of the inserted notice
        $notice_id = $stmt->insert_id;

        // Insert notification
        $sql_notification = "INSERT INTO notifications (stu_id, material_id, is_read, notification_date, notification_type, item_id, notification_message) VALUES (?, ?, ?, NOW(), ?, ?, ?)";
        $stmt_notification = $conn->prepare($sql_notification);

        // Get all student IDs enrolled in the course
        $sql_students = "SELECT stu_id FROM courseorder WHERE course_id = ?";
        $stmt_students = $conn->prepare($sql_students);
        $stmt_students->bind_param("i", $course_id);
        $stmt_students->execute();
        $result_students = $stmt_students->get_result();

        // Iterate through each student to insert a notification
        while ($student = $result_students->fetch_assoc()) {
            $stu_id = $student['stu_id'];
            $is_read = 0; // Notification is not read initially
            $notification_type = "Notice";
            $item_id = $notice_id; // ID of the notice
            $notification_message = "A new notice has been posted in one of your courses.";

            $stmt_notification->bind_param("iiisis", $stu_id, $notice_id, $is_read, $notification_type, $item_id, $notification_message);
            $stmt_notification->execute();
        }

        // Set feedback message
        $feedback = "Notice posted successfully!";
    }
}

// Fetch courses taught by the lecturer
$sql = "SELECT * FROM course WHERE lec_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['l_id']);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container" style="padding-left:6%; margin-top:5%;">
    <h2>Post Notice</h2>
    <?php if (!empty($error)) { ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php } ?>
    <?php if (!empty($feedback)) { ?>
        <div class="alert alert-success"><?php echo $feedback; ?></div>
    <?php } ?>
    <form method="post" action="post_notice.php">
        <div class="form-group">
            <label for="course_id">Select Course:</label>
            <select class="form-control" id="course_id" name="course_id">
                <option value="">Select Course</option>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <option value="<?php echo $row['course_id']; ?>"><?php echo $row['course_name']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="content">Content:</label>
            <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
<?php
include_once("manage_post.php");
include_once("Footer.php");
?>
