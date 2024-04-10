<?php
include_once("../DB_Files/db.php");

// Fetch courses from the database
$sql = "SELECT course_id, course_name FROM course";
$result = $conn->query($sql);

// Store unique courses in an array
$courses = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $courses[$row['course_id']] = $row['course_name'];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Post a Question</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.tiny.cloud/1/oe8cjbuk4afb07uokw5fvh4em4tgv2ozvm5cmopq9p1biwbm/tinymce/5/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            height: 300,
            menubar: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help'
        });
    </script>
    <style>
        body {
            font: 14px sans-serif;
            text-align: center;
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
        }

        h1 {
            font-size: 2em;
        }

        form {
            margin-top: 20px;
        }
    </style>

    <script>
        var coursesObject = <?php echo json_encode($courses); ?>;
        window.onload = function () {
            var coursesSel = document.getElementById("courses");

            for (var course_id in coursesObject) {
                var option = document.createElement("option");
                option.value = course_id;
                option.text = coursesObject[course_id];
                coursesSel.add(option);
            }
        };

        function validateForm() {
            var qBody = tinymce.get("q_body").getContent({ format: 'text' });
            var selectedCourse = document.forms["form1"]["courses"].value;

            if (qBody.length <= 10) {
                alert("Question body must be more than 10 characters.");
                return false;
            }

            if (selectedCourse === "") {
                alert("Please select a course.");
                return false;
            }

            return true; // Submit the form if all conditions are fulfilled
        }
        function displayMessage($msg, $type = 'success') {
            return '<div class="alert alert-' + type + ' col-sm-6 ml-5 mt-2 m-2">' + msg + '</div>';
        }
        
    </script>
</head>
<body>
    <div class="container">
        <h1 class="my-5">Post a Question</h1>

        <form name="form1" method="POST" action="submit-question.php" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="courses">Courses:</label>
                <select name="courses" id="courses" class="form-control">
                    <option value="" selected="selected">Select a course</option>
                </select>
            </div>

            <div class="form-group">
                <label for="q_body">Question Body:</label>
                <textarea name="q_body" id="q_body" class="form-control" placeholder="Enter your question"></textarea>
            </div>

            <button type="submit" class="btn btn-primary" name="Submit1">Submit</button>
        </form>
    </div>
</body>

</html>

?