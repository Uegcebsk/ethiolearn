<?php
include_once("../DB_Files/db.php");
include_once("../Inc/Header.php");

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

        h1 {
            font-size: 2em;
            color: #007bff;
        }

        form {
            margin-top: 20px;
        }

        label {
            font-weight: bold;
        }

        .form-group {
            margin-bottom: 20px;
        }

        textarea {
            height: 200px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-primary:focus {
            box-shadow: none;
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
            var qBody = document.forms["form1"]["q_body"].value;
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
    </script>
</head>
<body>
<?php
include_once("menu.php");
?>
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
