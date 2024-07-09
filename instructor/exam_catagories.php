<?php
include_once("../DB_Files/db.php");
include_once("Header copy.php");

// Function to display success or error messages
function displayMessage($msg, $type = 'success')
{
    return '<div class="alert alert-' . $type . ' col-sm-6 ml-5 mt-2 m-2">' . $msg . '</div>';
}

// Function to fetch course options for the select dropdown
function fetchInstructorCourses($instructorId)
{
    global $conn;
    $sql = "SELECT * FROM course WHERE lec_id='$instructorId'";
    $result = $conn->query($sql);
    $options = '<option value="" selected disabled hidden>--Select Course--</option>';
    while ($row = $result->fetch_assoc()) {
        $options .= '<option value="' . $row['course_id'] . '">' . $row['course_name'] . '</option>';
    }
    return $options;
}

// Handling form submission to add exam category
if (isset($_POST['submit'])) {
    if (empty($_POST['category']) || empty($_POST['time']) || empty($_POST['course']) || empty($_POST['assessment_type'])) {
        $msg = displayMessage('All Fields Required', 'warning');
    } else {
        $category = $_POST['category'];
        $time = $_POST['time'];
        $courseId = $_POST['course'];
        $description = $_POST['description'];
        $assessmentType = $_POST['assessment_type']; // Added assessment type
        
        $sql = "INSERT INTO exam_category(exam_name, exam_time, exam_description, course_id, assessment_type) VALUES ('$category', '$time', '$description', '$courseId', '$assessmentType')";
        
        if ($conn->query($sql) === TRUE) {
            $msg = displayMessage('Category Added Successfully');
            echo '<meta http-equiv="refresh" content="3;"/>';
        } else {
            $msg = displayMessage('Category Added Failed', 'warning');
        }
    }
}

// Function to add notification
function addNotification($courseId, $message, $conn)
{
    $notificationType = 'exam';
    $notificationDate = date("Y-m-d H:i:s");
    
    $sql = "INSERT INTO notifications (stu_id, material_id, notification_type, notification_message, notification_date, is_read, course_id) 
            SELECT co.stu_id, NULL, ?, ?, ?, 0, ? 
            FROM courseorder co 
            WHERE co.course_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssii", $notificationType, $message, $notificationDate, $courseId, $courseId);
    $stmt->execute();
    $stmt->close();
}

// Handling activation
if (isset($_POST['activate'])) {
    $examId = $_POST['exam_id'];
    $sql = "UPDATE exam_category SET active = 1 WHERE id = $examId";
    if ($conn->query($sql) === TRUE) {
        $msg = displayMessage('Exam Activated Successfully');
        // Add activation notification
        $courseIdQuery = "SELECT course_id FROM exam_category WHERE id = $examId";
        $result = $conn->query($courseIdQuery);
        $courseIdRow = $result->fetch_assoc();
        $courseId = $courseIdRow['course_id'];
        addNotification($courseId, 'An exam has been activated', $conn);
    } else {
        $msg = displayMessage('Exam Activation Failed', 'warning');
    }
}

// Handling deactivation
if (isset($_POST['deactivate'])) {
    $examId = $_POST['exam_id'];
    $sql = "UPDATE exam_category SET active = 0 WHERE id = $examId";
    if ($conn->query($sql) === TRUE) {
        $msg = displayMessage('Exam Deactivated Successfully');
        // Add deactivation notification
        $courseIdQuery = "SELECT course_id FROM exam_category WHERE id = $examId";
        $result = $conn->query($courseIdQuery);
        $courseIdRow = $result->fetch_assoc();
        $courseId = $courseIdRow['course_id'];
        addNotification($courseId, 'An exam has been deactivated', $conn);
    } else {
        $msg = displayMessage('Exam Deactivation Failed', 'warning');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Exam Category</title>
    <link rel="stylesheet" href="/ethioleant/bootstrap/css/bootstrap.min.css">
    <style>
        .container {
         padding:5%;
        }
    </style>
</head>
<body>
<div class="container" style="padding:5%";>
    <div class="row justify-content-center">
        <div class="col-lg-11 mt=4">
            <div class="card bg-transparent">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <div class="card-header bg-dark text-light"><strong>Add Exam Category</strong></div>
                    <?php if (isset($msg)) {
                        echo $msg;
                    } ?>
                    <div class="card-body card-block">
                        <div class="form-group">
                            <label for="category" class="form-control-label"><b>Category Name</b></label>
                            <input type="text" id="category" name="category" class="form-control">
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="description" class="form-control-label"><b>Exam Description</b></label>
                            <textarea id="description" name="description" class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="time" class="form-control-label"><b>Time in Minutes</b></label>
                            <input type="text" id="time" name="time" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="course" class="form-control-label"><b>Select Course</b></label>
                            <select class="form-control" name="course" id="course">
                                <?php echo fetchInstructorCourses($_SESSION['l_id']); ?>
                            </select>
                        </div>
                        <!-- Added assessment type field -->
                        <div class="form-group">
                            <label for="assessment_type" class="form-control-label"><b>Assessment Type</b></label>
                            <select class="form-control" name="assessment_type" id="assessment_type">
                                <option value="quiz">Quiz</option>
                                <option value="exam">Exam</option>
                            </select>
                        </div>
                        <!-- End of added assessment type field -->
                        <div class="form-group">
                            <br>
                            <button type="submit" name="submit" class="btn btn-success">Add Exam Category</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
<br>
<br>
        <div class="col-lg-11" style="margin-top:5%;">
            <div class="card bg-transparent">
                <div class="card-header bg-dark">
                    <strong class="card-title text-light">Exam Categories</strong>
                </div>
                <div class="card-body">
                    <?php
                    $sql = "SELECT ec.id, ec.exam_name, ec.exam_time,ec.assessment_type, ec.active, c.course_name 
                            FROM exam_category ec
                            INNER JOIN course c ON ec.course_id = c.course_id
                            WHERE c.lec_id = '{$_SESSION['l_id']}'";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        ?>
                        <table class="table">
                            <thead>
                            <tr>
                                <th class="text-dark fw-bolder">ID</th>
                                <th class="text-dark fw-bolder">Assessment Type </th>
                                <th class="text-dark fw-bolder">Category Name</th>
                                <th class="text-dark fw-bolder">Time</th>
                                <th class="text-dark fw-bolder">Course</th>
                                <th class="text-dark fw-bolder">Status</th>
                                <th class="text-dark fw-bolder">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php while ($row = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td class="text-dark fw-bolder"><?php echo $row['id']; ?></td>
                                    <td class="text-dark fw-bolder"><?php echo $row['assessment_type']; ?></td>
                                    <td class="text-dark fw-bolder"><?php echo $row['exam_name']; ?></td>
                                    <td class="text-dark fw-bolder"><?php echo $row['exam_time']; ?></td>
                                    <td class="text-dark fw-bolder"><?php echo $row['course_name']; ?></td>
                                    <td>
                                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                            <input type="hidden" name="exam_id" value="<?php echo $row['id']; ?>">
                                            <?php if ($row['active'] == 1) { ?>
                                                <button type="submit" class="btn btn-success" name="deactivate">Active</button>
                                            <?php } else { ?>
                                                <button type="submit" class="btn btn-secondary" name="activate">Inactive</button>
                                            <?php } ?>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="editExam.php" method="POST" class="d-inline">
                                            <input type="hidden" name="id" value='<?php echo $row["id"]; ?>'>
                                            <button type="submit" class="btn btn-info mr-3" name="view" value="View"><i class="fas fa-eye"></i></button>
                                        </form>
                                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="d-inline">
                                            <input type="hidden" name="id" value='<?php echo $row["id"]; ?>'>
                                            <button type="submit" class="btn btn-secondary" name="delete" value="Delete"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                    <td class="text-dark fw-bolder"><?php echo isset($row['exam_description']) ? $row['exam_description'] : ''; ?></td>
                                    
                                    
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    <?php } else {
                        echo "<p class='text-dark p-2 fw-bolder'>No Exam Categories found for this instructor. </p>";
                    }
                    ?>
</div>
                    <?php
                    // Handling category deletion
                    if (isset($_POST['delete'])) {
                        $sql = "DELETE FROM exam_category WHERE id={$_POST['id']}";
                        if ($conn->query($sql) === TRUE) {
                            echo '<meta http-equiv="refresh" content="0;URL=?deleted"/>';
                        } else {
                            echo "Delete Failed";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
