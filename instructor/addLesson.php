<?php
include_once("Header copy.php");
include_once("../DB_Files/db.php");

// Check if the user is logged in as an instructor
$l_id = $_SESSION['l_id']; // Assuming you store the logged-in instructor's ID in session

// Retrieve courses associated with the instructor
$sql_select_courses = "SELECT c.* 
                       FROM course c 
                       JOIN lectures l ON c.lec_id = l.l_id 
                       WHERE l.l_id = ?";
$stmt_select_courses = $conn->prepare($sql_select_courses);
$stmt_select_courses->bind_param("i", $l_id);
$stmt_select_courses->execute();
$result_select_courses = $stmt_select_courses->get_result();

// Initialize error and success messages
$errorMessage = "";
$successMessage = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate if all fields are filled
    if (!empty($_POST['course_id']) && !empty($_POST['lesson_name']) && !empty($_POST['lesson_description'])) {
        $course_id = $_POST['course_id'];
        $lesson_name = $_POST['lesson_name']; 
        $lesson_description = $_POST['lesson_description'];
        
        // Handle lesson link or file based on the selected upload type
        if ($_POST['upload_type'] == 'youtube') {
            $lesson_link = $_POST['lesson_link'];
            $lesson_file = ''; // If it's a YouTube link, no file is uploaded
        } else {
            // Handle file upload securely
            $lesson_file = $_FILES['lesson_file']['name'];
            $lesson_file_temp = $_FILES['lesson_file']['tmp_name'];
            $targetDir = "Videos/LessonVideos/";
            $targetFile = $targetDir . basename($lesson_file);
            $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            // Check if file is a valid video format
            $allowedFormats = array("mp4", "avi", "mov");
            if (!in_array($fileType, $allowedFormats)) {
                $errorMessage = "Only MP4, AVI, and MOV formats are allowed";
            } elseif (move_uploaded_file($lesson_file_temp, $targetFile)) {
                $lesson_link = 'Videos/LessonVideos/' . basename($lesson_file); // Store file path as link
            } else {
                $errorMessage = "File upload failed";
            }
        }

        if (empty($errorMessage)) {
            // Check if the lesson with the same name and course ID already exists
            $check_existing_query = "SELECT COUNT(*) AS num_lessons FROM lesson WHERE lesson_name = ? AND course_id = ?";
            $stmt_check_existing = $conn->prepare($check_existing_query);
            $stmt_check_existing->bind_param("si", $lesson_name, $course_id);
            $stmt_check_existing->execute();
            $result_check_existing = $stmt_check_existing->get_result();
            $row_check_existing = $result_check_existing->fetch_assoc();

            if ($row_check_existing['num_lessons'] > 0) {
                $errorMessage = '<div class="alert alert-warning col-sm-6 ml-5 mt-2">A lesson with the same name already exists for this course</div>';
            } else {
                // Proceed with lesson insertion
                // Use prepared statements to prevent SQL injection
                $sql_insert_lesson = "INSERT INTO lesson (lesson_name, lesson_link, course_id, lesson_description) VALUES (?, ?, ?, ?)";
                $stmt_insert_lesson = $conn->prepare($sql_insert_lesson);
                $stmt_insert_lesson->bind_param("ssis", $lesson_name, $lesson_link, $course_id, $lesson_description);

                if ($stmt_insert_lesson->execute()) {
                    // Get the ID of the last inserted lesson
                    $lesson_id = $conn->insert_id;

                    // Generate notification for lesson addition
                    $notification_type = "lesson";
                    $notification_message = "New lesson added: $lesson_name";
                    $notification_date = date("Y-m-d H:i:s");

                    $insert_notification_query = "INSERT INTO notifications (stu_id, material_id, notification_type, item_id, notification_message, notification_date, is_read) 
                    SELECT co.stu_id, ?, ?, ?, ?, ?, 0 
                    FROM courseorder co 
                    WHERE co.course_id = ?";
                    $stmt_insert_notification = $conn->prepare($insert_notification_query);
                    $stmt_insert_notification->bind_param("isissi", $lesson_id, $notification_type, $lesson_id, $notification_message, $notification_date, $course_id);

                    if ($stmt_insert_notification->execute()) {
                        $successMessage = "Lesson Added Successfully";
                    } else {
                        $errorMessage = "Failed to add notification";
                    }
                    $stmt_insert_notification->close();
                } else {
                    $errorMessage = "Lesson Addition Failed";
                }

                $stmt_insert_lesson->close();
            }

            $stmt_check_existing->close();
        }
    } else {
        $errorMessage = "All Fields Required";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Lesson</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Link to external CSS file -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        select,
        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        .error {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
            display: <?php echo !empty($errorMessage) ? 'block' : 'none'; ?>;
        }

        .success {
            color: #28a745;
            font-size: 14px;
            margin-top: 5px;
            display: <?php echo !empty($successMessage) ? 'block' : 'none'; ?>;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add New Lesson</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
            <div class="error"><?php echo $errorMessage; ?></div>
            <div class="success"><?php echo $successMessage; ?></div>
            <label for="upload_type">Upload Type</label>
            <select name="upload_type" id="upload_type">
                <option value="youtube">YouTube Link</option>
                <option value="file">Upload File</option>
            </select>
            <div id="youtube_link_input">
                <label for="lesson_link">Lesson YouTube ID</label>
                <input type="text" id="lesson_link" name="lesson_link">
            </div>
            <div id="file_upload_input" style="display:none;">
                <label for="lesson_file">Upload Video File</label>
                <input type="file" id="lesson_file" name="lesson_file">
            </div>
            <label for="course_id">Select Course:</label>
            <select name="course_id" id="course_id">
                <?php
                while ($row = $result_select_courses->fetch_assoc()) {
                    echo '<option value="' . $row['course_id'] . '">' . $row['course_name'] . '</option>';
                }
                ?>
            </select>
            <label for="lesson_name">Lesson Name:</label>
            <input type="text" id="lesson_name" name="lesson_name">
            <label for="lesson_description">Lesson Description:</label>
            <textarea id="lesson_description" name="lesson_description" rows="4"></textarea>
            <button type="submit" name="lessonSubmitBtn">Submit</button>
</form>
</div>
<script>
    document.getElementById('upload_type').addEventListener('change', function() {
        var value = this.value;
        var linkInput = document.getElementById('youtube_link_input');
        var fileInput = document.getElementById('file_upload_input');
        if (value === 'youtube') {
            linkInput.style.display = 'block';
            fileInput.style.display = 'none';
        } else {
            linkInput.style.display = 'none';
            fileInput.style.display = 'block';
        }
    });
</script>
