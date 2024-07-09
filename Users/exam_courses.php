<?php
include_once("ProfileHeader.php");
include_once("../DB_Files/db.php");

// Fetch student ID from session
$studentId = $_SESSION['stu_id'];

// Query to fetch enrolled courses and progress (calculate progress accurately)
$sql = "SELECT c.course_id, c.course_name, 
               COALESCE(SUM(lp.progress / 100), 0) AS total_progress, 
               COUNT(l.lesson_id) AS total_lessons
        FROM course c
        INNER JOIN courseorder co ON c.course_id = co.course_id
        LEFT JOIN lesson l ON c.course_id = l.course_id
        LEFT JOIN lesson_progress lp ON l.lesson_id = lp.lesson_id AND lp.student_id = $studentId
        WHERE co.stu_id = $studentId
        GROUP BY c.course_id";
$result = $conn->query($sql);
?>

<div class="container" style="padding: 4%;">
    <div class="row justify-content-center">
        <div class="col-sm-11 mt-4">
            <p class="bg-dark text-white p-2 fw-bolder text-center">Select Course</p>
            <br>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $courseId = $row["course_id"];
                    $courseName = $row["course_name"];
                    $totalProgress = $row["total_progress"];
                    $totalLessons = $row["total_lessons"];

                    // Calculate the accurate progress percentage
                    $progressPercentage = ($totalLessons > 0) ? ($totalProgress / $totalLessons) * 100 : 0;
                    $progressPercentage = number_format($progressPercentage, 2);

                    // Determine progress message
                    if ($progressPercentage >= 70) {
                        $progressMessage = "Your progress: " . $progressPercentage . "%";
                        $buttonText = "Select Exam Category";
                        $buttonDisabled = false;
                    } else {
                        $progressMessage = "Your progress: " . $progressPercentage . "%";
                        $buttonText = "You need to complete more lessons";
                        $buttonDisabled = true;
                    }
                    ?>
                    <div class="mt-3">
                        <h5><?php echo $courseName; ?></h5>
                        <p><?php echo $progressMessage; ?></p>
                        <form action="enrollexam.php" method="get">
                            <input type="hidden" name="course_id" value="<?php echo $courseId; ?>">
                            <input type="submit" class="btn btn-secondary border-5 form-control fw-bolder text-light" value="<?php echo $buttonText; ?>" <?php echo $buttonDisabled ? 'disabled' : ''; ?>>
                        </form>
                    </div>
                <?php
                }
            } else {
                echo "<p class='text-center'>No courses found.</p>";
            }
            ?>
        </div>
    </div>
</div>
