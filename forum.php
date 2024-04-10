<?php
// Include necessary files
include_once("Inc/Header.php");
include_once("DB_Files/db.php");

// Check if user is not logged in, redirect to login page
// 
/*
if (!isset($_SESSION['stu_email'])) {
    header("Location: Login&SignIn.php");
    exit();
}
*/
// Fetch student name based on student ID
$stu_id = $_SESSION['stu_id'];
$sql_student = "SELECT stu_name FROM students WHERE stu_id = $stu_id";
$result_student = $conn->query($sql_student);
$row_student = $result_student->fetch_assoc();
$stu_name = $row_student['stu_name'];

// Initialize variables for search and course filter
$search_keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
$selected_course = isset($_POST['course']) ? $_POST['course'] : '';

// Construct the SQL query based on search and course filter
$sql_conditions = [];
if (!empty($search_keyword)) {
    $sql_conditions[] = "(q.q_body LIKE '%$search_keyword%')";
}
if (!empty($selected_course)) {
    $sql_conditions[] = "(c.course_name = '$selected_course')";
}

$sql_condition = !empty($sql_conditions) ? "WHERE " . implode(" AND ", $sql_conditions) : "";
$sql_questions = "SELECT Q_id, q.Q_stu_id, q.q_body, q.course_id, q.q_timestamp, q.resolved, c.course_name, s.stu_name, stu_img 
FROM questions q 
JOIN course c ON q.course_id = c.course_id 
JOIN students s ON q.Q_stu_id = s.stu_id 
$sql_condition";

$result_questions = $conn->query($sql_questions);
?>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
    
        .container {
            margin-top: 10px;
        }

        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .card-body {
            padding: 1.25rem;
        }

        .rounded-circle {
            overflow: hidden;
            width: 50px;
            height: 50px;
            margin-right: 10px;
        }

        .img-fluid {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .btn-success i {
            margin-right: 5px;
        }

        a.card-link {
            color: blue;
            font-weight: bold;
        }

        a.card-link:hover {
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container" >
        <h1 class="my-5">Hi, <b><?php echo $stu_name; ?></b>. Welcome to QA Forum.</h1>
        <div class="btn-container">
            <a href="expand-all.php" class="btn btn-warning">Main Forum</a>
            <a href="post-question.php" class="btn btn-warning">Post Question</a>
            <a href="your-questions.php" class="btn btn-warning">Your Questions</a>
            <a href="your-answers.php" class="btn btn-warning">Your Answers</a>
        </div>

        <form name="form1" method="POST" action="" class="search-form">
            <div class="form-row align-items-center">
                <div class="col-md-6 mb-3">
                    <input type="text" value="<?php echo $search_keyword; ?>" name="keyword" class="form-control" placeholder="Enter a search keyword">
                </div>
                <div class="col-md-6 mb-3">
                    <select name="course" id="course" class="form-control">
                        <option value="" selected="selected">Select Course</option>
                        <?php
                        // Fetch courses from the database
                        $sql_courses = "SELECT course_name FROM course";
                        $result_courses = $conn->query($sql_courses);

                        // Display courses as options
                        if ($result_courses->num_rows > 0) {
                            while ($row = $result_courses->fetch_assoc()) {
                                $selected = ($selected_course == $row["course_name"]) ? 'selected' : '';
                                echo '<option value="' . $row["course_name"] . '" ' . $selected . '>' . $row["course_name"] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <!-- Implement real-time search functionality -->
            <button type="submit" class="btn btn-primary" name="Submit1">Search</button>
        </form>

        <?php
        // Display questions
        if ($result_questions->num_rows > 0) {
            while ($row = $result_questions->fetch_assoc()) {
                $resolved_class = $row["resolved"] ? "resolved" : "";
                echo '
                <div class="card '.$resolved_class.'">
                    <div class="card-body">
                        <p class="card-text"><a href="#" style="color: blue; font-weight: bold;">' . $row["q_body"] . '?</a></p>
                        <p class="card-text">Course Name: ' . $row["course_name"] . '</p>
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle overflow-hidden" style="width: 50px; height: 50px; margin-right: 10px;">
                                <img src="' . $row["stu_img"] . '" alt="Student Image" class="img-fluid rounded-circle">
                            </div>
                            <div>
                                <p class="mb-0 text-muted">' . $row["q_timestamp"] . '</p>
                                <p class="mb-1"><strong>' . $row["stu_name"] . '</strong></p>
                            </div>
                        </div>
                        <!-- Show More button to load all answers -->
                        <button type="button" class="btn btn-primary mt-3 show-answers" data-qid="'.$row["Q_id"].'">Show More Answers</button>
                        <!-- Container for displaying partial answers -->
                        <div class="partial-answers" id="answers-container-'.$row["Q_id"].'"></div>
                    </div>
                </div>';
            }
        } else {
            echo "<p>No questions found.</p>";
        }
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Function to load partial answers for a question
            $(".show-answers").click(function() {
                var qid = $(this).data("qid");
                var containerId = "#answers-container-" + qid;
                $.ajax({
                    url: "load-answers.php",
                    method: "POST",
                    data: { Q_id: qid },
                    success: function(data) {
                        $(containerId).html(data);
                    }
                });
            });
        });
    </script>
</body>
</html>

<?php
$conn->close();
?>
