<?php
include_once("ProfileHeader.php");
include_once("../DB_Files/db.php");

// Fetch course ID from GET parameter
if (isset($_GET['course_id'])) {
    $courseId = $_GET['course_id'];
} else {
    echo "<p class='text-center'>Course ID not provided.</p>";
    exit;
}

// Fetch student ID from session
$studentId = $_SESSION['stu_id'];

// Query to fetch exam categories
$sql = "SELECT ec.* 
        FROM exam_category ec
        INNER JOIN course c ON ec.course_id = c.course_id
        INNER JOIN courseorder co ON c.course_id = co.course_id
        WHERE co.stu_id = $studentId AND ec.active = 1 AND ec.assessment_type = 'exam' AND ec.course_id = $courseId";
$result = $conn->query($sql);

?>

<div class="container" style="padding: 4%;">
    <div class="row justify-content-center">
        <div class="col-sm-11 mt-4">
            <p class="bg-dark text-white p-2 fw-bolder text-center">List of Exam Categories</p>
            <br>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $category = $row["exam_name"];
                    $categoryId = $row["id"]; // Fetch the exam category ID

                    // Check if the student has already attempted this exam
                    $checkAttempt = $conn->query("SELECT * FROM exam_results WHERE student_id = '$studentId' AND exam_category = '$category'");
                    if ($checkAttempt->num_rows == 0) {
                        // If no attempts found, allow starting the exam
            ?>
                        <div class="mt-3">
                            <form action="exam.php" method="get">
                                <input type="hidden" name="exam_category" value="<?php echo $category; ?>">
                                <input type="hidden" name="exam_category_id" value="<?php echo $categoryId; ?>"> <!-- Passed exam category ID as a URL parameter -->
                                <input type="submit" name="test" class="btn btn-secondary border-5 form-control fw-bolder text-light" value="<?php echo $category; ?>">
                            </form>
                        </div>
            <?php
                    } else {
                        // If attempts found, display a message
                        echo "<div class='mt-3'><p class='text-danger'>You have already taken the $category exam.</p></div>";
                    }
                }
            } else {
                echo "<p class='text-center'>No exam categories found for the courses you have ordered.</p>";
            }
            ?>
            <br><br><br><br><br><br><br>
            <div class="text-center">
                <a href="OldResult.php" class="btn btn-danger border-5 fw-bolder text-light">Show Result</a>
            </div>
        </div>
    </div>
</div>
