<?php
session_start();
include_once("../DB_Files/db.php");

if (!isset($_SESSION['stu_id'])) {
    header('Location:../Home.php');
    exit; // Ensure script stops execution after redirection
}

$link = isset($_REQUEST['link']) ? $_REQUEST['link'] : '';

// Sanitize the input to prevent SQL injection
$link = $conn->real_escape_string($link);
// Retrieve lesson data only if link is set
if ($link !== '') {
    $sql = "SELECT * FROM lesson WHERE lesson_link='$link'";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
?>
<link rel="stylesheet" href="CSS/watchcourse.css">
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<title>Imperial College - <?php echo isset($row['lesson_name']) ? $row['lesson_name'] : 'Lesson not found'; ?></title>

<div style="height: 80px;" class="container-fluid bg-dark p-2">
    <h4 class="text-white mt-4">Lesson Name: <?php echo isset($row['lesson_name']) ? $row['lesson_name'] : 'Lesson not found'; ?></h4>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-md-6 border-right mt-5">
            <?php if (isset($row['lesson_name'])): ?>
                <h3 style="width: 800px;" class="ms-5">Lesson Name: <?php echo $row['lesson_name']; ?></h3>
                <video width="100%" height="auto" controls class="mt-5 ml-5">
                    <source src="<?php echo 'LearningManagementSystem-main/instructor/Videos/LessonVideos' . $row['lesson_link']; ?>" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            <?php else: ?>
                <p class="text-danger">Lesson not found.</p>
            <?php endif; ?>
            <a href="WatchList.php?course_id=<?php echo isset($row['course_id']) ? $row['course_id'] : ''; ?>" class="btn btn-danger mt-3 ms-5">Finish</a>
        </div>
    </div>
</div>
<?php
    } else {
        echo "Error: Lesson not found.";
    }
} else {
    echo "Error: Lesson link not set.";
}
?>