<?php
include_once("ProfileHeader.php");
include_once("../DB_Files/db.php");

$student_id = $_SESSION["stu_id"];

// Fetch the total number of courses the student is enrolled in
$sql_courses = "SELECT * FROM courseorder WHERE stu_id = ?";
$stmt_courses = $conn->prepare($sql_courses);
$stmt_courses->bind_param("i", $student_id);
$stmt_courses->execute();
$result_courses = $stmt_courses->get_result();
$tot_courses = $result_courses->num_rows;

?>

<!-- Include Chart.js library -->
<script src="/ethiolearn/bootstrap/js/chart.js"></script>
<link rel="stylesheet" href="/ethiolearn/Users/CSS/dashboard.css">

<div class="container">
    <?php
    // Loop through each enrolled course
    while ($course = $result_courses->fetch_assoc()) {
        $course_id = $course['course_id'];

        // Fetch course details
        $sql_course = "SELECT * FROM course WHERE course_id = ?";
        $stmt_course = $conn->prepare($sql_course);
        $stmt_course->bind_param("i", $course_id);
        $stmt_course->execute();
        $result_course = $stmt_course->get_result();
        $row_course = $result_course->fetch_assoc();

        // Fetch total number of lessons for the course
        $sql_lessons = "SELECT lesson_name FROM lesson WHERE course_id = ?";
        $stmt_lessons = $conn->prepare($sql_lessons);
        $stmt_lessons->bind_param("i", $course_id);
        $stmt_lessons->execute();
        $result_lessons = $stmt_lessons->get_result();

        // Fetch total number of materials for the course
        $sql_materials = "SELECT COUNT(*) AS material_count FROM materials WHERE course_id = ?";
        $stmt_materials = $conn->prepare($sql_materials);
        $stmt_materials->bind_param("i", $course_id);
        $stmt_materials->execute();
        $result_materials = $stmt_materials->get_result();
        $row_materials = $result_materials->fetch_assoc();
        $tot_materials = $row_materials['material_count'];

        // Fetch total number of exams for the course
        $sql_exams = "SELECT COUNT(*) AS exam_count FROM exam_category WHERE course_id = ? AND assessment_type = 'exam'";
        $stmt_exams = $conn->prepare($sql_exams);
        $stmt_exams->bind_param("i", $course_id);
        $stmt_exams->execute();
        $result_exams = $stmt_exams->get_result();
        $row_exams = $result_exams->fetch_assoc();
        $tot_exams = $row_exams['exam_count'];

        // Fetch total number of quizzes for the course
        $sql_quizzes = "SELECT COUNT(*) AS quiz_count FROM exam_category WHERE course_id = ? AND assessment_type = 'quiz'";
        $stmt_quizzes = $conn->prepare($sql_quizzes);
        $stmt_quizzes->bind_param("i", $course_id);
        $stmt_quizzes->execute();
        $result_quizzes = $stmt_quizzes->get_result();
        $row_quizzes = $result_quizzes->fetch_assoc();
        $tot_quizzes = $row_quizzes['quiz_count'];

        // Fetch student's lesson progress for this course
        $sql_progress = "SELECT progress FROM lesson_progress WHERE student_id = ? AND course_id = ?";
        $stmt_progress = $conn->prepare($sql_progress);
        $stmt_progress->bind_param("ii", $student_id, $course_id);
        $stmt_progress->execute();
        $result_progress = $stmt_progress->get_result();

        // Store lesson names and progress data in arrays
        $lesson_names = array();
        $progress_data = array();
        while ($row_progress = $result_progress->fetch_assoc()) {
            $progress_data[] = $row_progress['progress'];
        }

        // Fetch lesson names and store them in an array
        while ($row_lesson = $result_lessons->fetch_assoc()) {
            $lesson_names[] = $row_lesson['lesson_name'];
        }
    ?>
    <style>
         .card-text {
        margin-bottom: 15px;
        color: #212529;
    }
    </style>

        <div class="course-section">
            <div class="card border-primary"style = "background-color:green;">
                <div class="card-body">
                    <h4 class="card-title"><?php echo $row_course['course_name']; ?></h4>
                    <p class="card-text">Total Lessons: <?php echo count($lesson_names); ?></p>
                    <p class="card-text">Total Materials: <?php echo $tot_materials; ?></p>
                    <a href="MyCourse" class="btn btn-primary">View Course Details</a>
                </div>
            </div>

            <div class="card border-primary"style = "background-color:yellow; color:black;">
                <div class="card-body">
                    <h4 class="card-title color:black;">Exams</h4>
                    <p class="card-text color:black;">Total Exams: <?php echo $tot_exams; ?></p>
                    <a href="Enrollexam.php color:black;" class="btn btn-primary">View Exams</a>
                </div>
            </div>

            <div class="card border-primary"style = "background-color:red;">
                <div class="card-body">
                    <h4 class="card-title">Quizzes</h4>
                    <p class="card-text">Total Quizzes: <?php echo $tot_quizzes; ?></p>
                    <a href="EnrollQuiz.php" class="btn btn-primary">View Quizzes</a>
                </div>
            </div>

            <div class="chart-container border-primary">
                <div class="card-body">
                    <h4 class="card-title">Lesson Progress</h4>
                    <div class="chart-canvas">
                        <canvas id="lessonProgressChart-<?php echo $course_id; ?>"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Convert PHP lesson progress data to JavaScript array
            var lessonProgressData<?php echo $course_id; ?> = <?php echo json_encode($progress_data); ?>;
            var lessonNames<?php echo $course_id; ?> = <?php echo json_encode($lesson_names); ?>;

            // Get canvas element
            var ctx<?php echo $course_id; ?> = document.getElementById('lessonProgressChart-<?php echo $course_id; ?>').getContext('2d');

            // Create the chart
            var lessonProgressChart<?php echo $course_id; ?> = new Chart(ctx<?php echo $course_id; ?>, {
                type: 'line',
                data: {
                    labels: lessonNames<?php echo $course_id; ?>, // Labels: Lesson names
                    datasets: [{
                        label: 'Lesson Progress (%)',
                        data: lessonProgressData<?php echo $course_id; ?>, // Lesson progress data
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Lesson Name'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Progress (%)'
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    var label = lessonNames<?php echo $course_id; ?>[context.dataIndex] || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += context.parsed.y.toFixed(2) + '%';
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        </script>

    <?php
    }
    ?>
</div>
