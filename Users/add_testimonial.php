<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>testimonial Page</title>
    <link rel="stylesheet" href="styles.css"> <!-- Include your custom CSS file here for styling -->
    <style>
        .long-content {
            display: none;
        }
    </style>
</head>
<body>

<?php
include_once("ProfileHeader.php");
include_once("../DB_Files/db.php");

$stu_email = $_SESSION['stu_email'];
$sql = "SELECT * FROM students WHERE stu_email='$stu_email'";
$result = $conn->query($sql);
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $stuId = $row["stu_id"];
}

// Fetch enrolled courses for the student
$sql_courses = "SELECT co.course_id, c.course_name 
                FROM courseorder co
                INNER JOIN course c ON co.course_id = c.course_id
                WHERE co.stu_id = '$stuId'";
$result_courses = $conn->query($sql_courses);

if (isset($_REQUEST['submitFeedback'])) {
    if (empty($_REQUEST['course_id']) || empty($_REQUEST['f_content'])) {
        $passmsg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert">All Fields Required</div>';
    } else {
        $courseId = $_REQUEST['course_id'];
        $fContent = $_REQUEST['f_content'];

        // Insert feedback with corresponding course ID
        $sql = "INSERT INTO feedback (f_content, stu_id, course_id) VALUES ('$fContent', '$stuId', '$courseId')";
        if ($conn->query($sql) == TRUE) {
            $passmsg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert">Feedback Submitted</div>';
        } else {
            $passmsg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert">Feedback Submission Failed</div>';
        }
    }
}
?>

<div class="container"style="padding:6%;">
    <div class="row justify-content-right" >
        <div class="col-sm-12 mt-4" ;>
            <form method="POST" enctype="multipart/form-data" class="feedback-form">
                <p class="bg-dark text-white p-2 fw-bolder">testimonial</p>
                <?php if (isset($passmsg)) {
                    echo $passmsg;
                } ?>
                <div class="form-group">
                    <label class="text-dark" for="course_id">Select Course:</label>
                    <select id="course_id" class="form-control" name="course_id">
                        <?php while ($row_course = $result_courses->fetch_assoc()): ?>
                            <option value="<?php echo $row_course['course_id']; ?>"><?php echo $row_course['course_name']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="text-dark" for="f_content">Write testimonial:</label>
                    <textarea id="f_content" name="f_content" class="form-control"></textarea>
                </div>
                <button type="submit" name="submitFeedback" class="btn btn-danger">Submit</button>
            </form>
        </div>

        <div class="col-sm-12 mt-4">
            <div class="feedback-replies">
                <p class="bg-dark text-white p-2 fw-bolder">testimonial Replies</p>
                <!-- Display feedback replies in a table -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Course</th>
                            <th>testimonial</th>
                            <th>Reply</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Fetch feedback along with corresponding replies
                        $sql_feedback_replies = "SELECT f.*, c.course_name, r.reply_content, r.reply_time
                                                FROM feedback f
                                                INNER JOIN course c ON f.course_id = c.course_id
                                                LEFT JOIN replies r ON f.f_id = r.feedback_id
                                                WHERE f.stu_id = '$stuId'";
                        $result_feedback_replies = $conn->query($sql_feedback_replies);

                        while ($row = $result_feedback_replies->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['course_name']; ?></td>
                                <td><?php echo $row['f_content']; ?></td>
                                <td>
                                    <?php 
                                    if ($row['reply_content']) {
                                        if (strlen($row['reply_content']) > 50) {
                                            echo '<span class="short-content">' . substr($row['reply_content'], 0, 50) . '...</span>';
                                            echo '<span class="long-content">' . $row['reply_content'] . '</span>';
                                            echo '<br><a href="#" class="show-more-link">Show More</a>';
                                        } else {
                                            echo $row['reply_content'];
                                        }
                                        if ($row['reply_time']) {
                                            echo '<br><small class="text-muted">' . $row['reply_time'] . '</small>';
                                        }
                                    } else {
                                        echo 'No reply yet';
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
                                </div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const showMoreLinks = document.querySelectorAll('.show-more-link');
        showMoreLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const longContent = this.parentElement.querySelector('.long-content');
                const shortContent = this.parentElement.querySelector('.short-content');
                longContent.style.display = 'inline';
                shortContent.style.display = 'none';
                this.style.display = 'none';
                
                // Scroll to the expanded content
                const tableRow = this.closest('tr');
                tableRow.scrollIntoView({ behavior: 'smooth', block: 'center' });
            });
        });
    });
</script>


</body>
</html>
