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
    if (!empty($_POST['course_id']) && !empty($_POST['material_name']) && !empty($_POST['material_type']) && !empty($_POST['material_description']) && isset($_FILES["material_file"])) {
        $course_id = $_POST['course_id'];
        $material_name = $_POST['material_name']; 
        $material_type = $_POST['material_type'];
        $material_description = $_POST['material_description'];
        $file = $_FILES["material_file"];

        // Check if a file is uploaded
        if ($file["error"] === UPLOAD_ERR_OK) {
            // Use fileinfo extension to determine MIME type
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime_type = finfo_file($finfo, $file['tmp_name']);
            finfo_close($finfo);

            // Map MIME type to material type
            $allowedTypes = [
                'Document' => ['application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
                'Presentation' => ['application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation'],
                'PDF' => 'application/pdf'
            ];

            // Check if the MIME type matches the selected material type
            if (!isset($allowedTypes[$material_type]) || !in_array($mime_type, (array) $allowedTypes[$material_type])) {
                $errorMessage = "Invalid file type selected. Please choose a {$material_type} file.";
            } else {
                // Specify the directory where the file will be moved
                $target_directory = "../instructor/material/";

                // Get the file extension
                $file_extension = pathinfo($file["name"], PATHINFO_EXTENSION);

                // Generate a unique filename to prevent conflicts
                $file_name = uniqid() . '_' . $material_name . '.' . $file_extension;

                // File path to move the uploaded file
                $target_path = $target_directory . $file_name;

                // Move uploaded file to the target directory
                if (move_uploaded_file($file["tmp_name"], $target_path)) {
                    // Insert material details into the database
                    $sql_insert_material = "INSERT INTO materials (course_id, material_name, material_type, material_desc, material_url, upload_date) VALUES (?, ?, ?, ?, ?, NOW())";
                    $stmt_insert_material = $conn->prepare($sql_insert_material);
                    $stmt_insert_material->bind_param("issss", $course_id, $material_name, $material_type, $material_description, $target_path); // Use the target path
                    
                    if ($stmt_insert_material->execute()) {
                        // Generate notification for material upload
                        $notification_type = "material";
                        $notification_message = "New material added: $material_name";
                        $notification_date = date("Y-m-d H:i:s");

                        $insert_notification_query = "INSERT INTO notifications (stu_id, material_id, notification_type, notification_message, notification_date, is_read, course_id) 
                        SELECT co.stu_id, LAST_INSERT_ID(), ?, ?, ?, 0, ? 
                        FROM courseorder co 
                        WHERE co.course_id = ?";
                        $stmt_insert_notification = $conn->prepare($insert_notification_query);
                        $stmt_insert_notification->bind_param("sssii", $notification_type, $notification_message, $notification_date, $course_id, $course_id);

                        if ($stmt_insert_notification->execute()) {
                            $successMessage = "Material uploaded successfully.";
                        } else {
                            $errorMessage = "Error occurred while adding notification for material.";
                        }
                        $stmt_insert_notification->close();
                    } else {
                        $errorMessage = "Error occurred while uploading material.";
                    }
                    $stmt_insert_material->close();
                } else {
                    $errorMessage = "Failed to move the uploaded file.";
                }
            }
        } else {
            $errorMessage = "Failed to upload the file. Please try again.";
        }
    } else {
        $errorMessage = "All fields are required.";
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Material</title>
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
            padding: 5%;
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
        input[type="file"],
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
        <div class="row justify-content-center">
            <div class="col-md-13 mt-5">
                <h2>Upload Material</h2>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" id="uploadForm">
                    <label for="course_id">Select Course:</label>
                    <select name="course_id" id="course_id">
                        <?php
                        while ($row = $result_select_courses->fetch_assoc()) {
                            echo '<option value="' . $row['course_id'] . '">' . $row['course_name'] . '</option>';
                        }
                        ?>
                    </select>
                    <label for="material_name">Material Name:</label>
                    <input type="text" name="material_name" id="material_name" placeholder="Enter material name">
                    <label for="material_type">Material Type:</label>
                    <select name="material_type" id="material_type">
                        <option value="Document">Document</option>
                        <option value="Presentation">Presentation</option>
                        <option value="PDF">PDF</option>
                        <!-- Add more options if needed -->
                    </select>
                    <label for="material_description">Material Description:</label>
                    <textarea name="material_description" id="material_description" rows="5" placeholder="Enter material description"></textarea>
                    <label for="material_file">Choose File:</label>
                    <input type="file" name="material_file" id="material_file">
                    <div id="fileError" class="error"><?php echo $errorMessage; ?></div>
                    <div id="successMessage" class="success"><?php echo $successMessage; ?></div>
                    <button type="submit" id="uploadBtn">Upload</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Script to hide error and success messages after a certain time
        document.addEventListener("DOMContentLoaded", function() {
            var errorDiv = document.getElementById('fileError');
            var successDiv = document.getElementById('successMessage');

            if (errorDiv.innerHTML.trim() !== "") {
                setTimeout(function() {
                    errorDiv.style.display = "none";
                }, 3000); // 3 seconds
            }

            if (successDiv.innerHTML.trim() !== "") {
                setTimeout(function() {
                    successDiv.style.display = "none";
                }, 3000); // 3 seconds
            }
        });
    </script>
</body>
</html>
