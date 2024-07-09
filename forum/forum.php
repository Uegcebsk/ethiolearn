<?php
// Include necessary files
include_once("../DB_Files/db.php");
include_once("../Inc/Header.php");

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['stu_id'])) {
    header("Location: /ethiolearn/Login.php");
    exit();
}

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
$sql_condition
ORDER BY q.q_timestamp DESC";

$result_questions = $conn->query($sql_questions);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>QA Forum</title>
    <link rel="stylesheet" href="/ethiolearn/bootstrap/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Arial', sans-serif;
            padding-right:10%;
        }

        .container {
            margin-top: 7%;
            max-width: 900px;
            max-height: 900px;
        }

        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
            background-color: #fff;
        }

        .card-body {
            padding: 20px;
        }

        .rounded-circle {
            overflow: hidden;
            width: 60px;
            height: 60px;
            margin-right: 20px;
        }

        .img-fluid {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .search-form {
            margin-bottom: 20px;
        }

        .resolved {
            border-left: 5px solid #28a745;
        }

        .offcanvas {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            z-index: 1045;
            display: block;
            width: 250px;
            background-color: #fff;
            box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .offcanvas-body {
            padding: 20px;
        }
    </style>
</head>
<body>
    <?php include("menu.php"); ?>

    <div class="container">
        <h1 class="my-5 text-center">Hi, <b><?php echo $stu_name; ?></b>. Welcome to QA Forum.</h1>
        
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
                        <p class="card-text"><a href="#" class="font-weight-bold">' . $row["q_body"] .'</a></p>
                        <p class="card-text">Course Name: ' . $row["course_name"] . '</p>
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle overflow-hidden">
                                <img src="' . $row["stu_img"] . '" alt="Student Image" class="img-fluid">
                            </div>
                            <div>
                               
                                <p class="mb-1"><strong>' . $row["stu_name"] . '</strong></p>
                                <p class="mb-0 text-muted">' . $row["q_timestamp"] . '</p>
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

    <script src="/ethiolearn/Users/js/min.js"></script>
    <script>
    $(document).ready(function() {
        // Function to load partial answers for a question
        $(".show-answers").click(function() {
            var qid = $(this).data("qid");
            var containerId = "#answers-container-" + qid;
            
            // Toggle visibility of answers container
            $(containerId).toggle();
            
            // If the container is visible, load answers
            if ($(containerId).is(":visible")) {
                $.ajax({
                    url: "load-answers.php",
                    method: "POST",
                    data: { Q_id: qid },
                    success: function(data) {
                        $(containerId).html(data);
                    }
                });
            }
        });
    });
    </script>
</body>
</html>
<?php
$conn->close();
?>
