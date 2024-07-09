<?php
include_once("ProfileHeader.php");
include_once("../DB_Files/db.php");

if (!isset($_SESSION['stu_id'])) {
    header('Location:../Home.php');
    exit(); // Exit to prevent further execution
}

if (!isset($_GET['course_id'])) {
    header('Location: MyCourse.php');
    exit();
}

$course_id = $_GET['course_id'];
$student_id = $_SESSION['stu_id'];

// Retrieve lesson progress based on course ID and student ID
$sql = "SELECT lp.lesson_id, lp.progress, lp.completed
        FROM lesson_progress lp
        JOIN lesson l ON lp.lesson_id = l.lesson_id
        WHERE l.course_id = ? AND lp.student_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $course_id, $student_id);
$stmt->execute();
$result = $stmt->get_result();

// Create an associative array to store lesson progress
$lessonProgress = array();
while ($row = $result->fetch_assoc()) {
    $lessonProgress[$row['lesson_id']] = array(
        'progress' => $row['progress'],
        'completed' => $row['completed']
    );
}
$stmt->close();

// Retrieve lessons based on course ID
$sql_lessons = "SELECT * FROM lesson WHERE course_id = ?";
$stmt_lessons = $conn->prepare($sql_lessons);
$stmt_lessons->bind_param("i", $course_id);
$stmt_lessons->execute();
$result_lessons = $stmt_lessons->get_result();
$stmt_lessons->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watchlist</title>
    <link rel="stylesheet" href="CSS/watchcourse.css">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <style>
        .progress-circle {
            width: 50px;
            height: 50px;
            position: absolute;
            border-radius: 50%;
            background-color: #f3f3f3;
            overflow: hidden;
            margin: -7 auto;
        }

        .progress-circle::before {
            content: '';
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 3px solid transparent; /* Initially transparent */
            border-top-color: #007bff; /* Start filling from top */
            position: absolute;
            top: 0;
            left: 0;
            transform: rotate(90deg);
            transition: border-width 1s ease; /* Smooth transition */
        }

        .progress-circle.complete::before {
            border: 3px solid #007bff; /* Fill the border completely */
            transition: none; /* Remove transition when it's complete */
        }

        .progress-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 14px;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container" style="padding:5%;">
    <div class="row justify-content-center">
        <div class="col-sm-11">
            <p class="bg-dark text-white p-2">List of Lessons</p>
            <?php if ($result_lessons->num_rows > 0) { ?>
                <table class="table">
                    <thead>
                    <tr>
                        <th class="text-dark fw-bolder" scope="col">Lesson Name</th>
                        <th class="text-dark fw-bolder" scope="col">Progress</th>
                        <th class="text-dark fw-bolder" scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while ($row_lesson = $result_lessons->fetch_assoc()) { ?>
                        <tr>
                            <td class="text-dark fw-bolder"><?php echo $row_lesson['lesson_name']; ?></td>
                            <td>
                                <?php
                                // Check if lesson progress exists
                                if (array_key_exists($row_lesson['lesson_id'], $lessonProgress)) {
                                    $progress = $lessonProgress[$row_lesson['lesson_id']]['progress'];
                                    $completed = $lessonProgress[$row_lesson['lesson_id']]['completed'];
                                    if ($progress == 0) {
                                        echo "Not Started";
                                    } else {
                                        echo '<div class="progress-circle ' . ($completed == 1 ? 'complete' : '') . '">';
                                        echo '<div class="progress-text">' . round($progress, 2) . '%</div>';
                                        echo '</div>';
                                    }
                                } else {
                                    echo "Not Started";
                                }
                                ?>
                            </td>
                            <td>
                                <form action="watchh.php" method="POST" class="d-inline">
                                    <input type="hidden" name="link" value="<?php echo $row_lesson['lesson_link']; ?>">
                                    <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
                                    <input type="hidden" name="lesson_id" value="<?php echo $row_lesson['lesson_id']; ?>"> <!-- Add lesson_id -->
                                    <button type="submit" class="btn btn-info mr-3" name="view" value="View">View</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            <?php } else {
                echo "<p class='text-dark p-2 fw-bolder'>Lessons Not Found. </p>";
            } ?>
        </div>
    </div>
    <div style="height: 120px; padding-left:10%;" class="">
        <a href="MyCourse.php" class="">Back to My Course</a>
    </div>
</div>
</body>
</html>
