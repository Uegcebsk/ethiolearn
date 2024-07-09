<?php
include_once("../DB_Files/db.php");
include_once("../Inc/Header.php");
// Fetch subjects from the database
$sql = "SELECT course_name FROM course";
$result = $conn->query($sql);

// Store subjects in an array
$course = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $course[] = $row["course_name"];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="/ethiolearn/bootstrap/css/bootstrap.min.css">
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

        .btn-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        .search-form {
            margin-top: 20px;
        }

        /* Responsive styles */
        @media (max-width: 767px) {
            .btn-container {
                flex-direction: column;
            }

            .btn-container a {
                margin-bottom: 10px;
            }
        }
    </style>

    <script>
        var courseObject = <?php echo json_encode(array_combine($course, array_fill(0, count($course), []))); ?>;
        window.onload = function () {
            var courseSel = document.getElementById("course");

            for (var x in courseObject) {
                courseSel.options[coursesubjectSel.options.length] = new Option(x, x);
            }
        };
    </script>
</head>
<body>
    <div class="container">
        <h1 class="my-5">Hi, <b> ?></b>. Welcome to QA Forum.</h1>

        <div class="btn-container">
            <a href="expand-all.php" class="btn btn-warning">Main Forum</a>
            <a href="post-question.php" class="btn btn-warning">Post Question</a>
            <a href="your-questions.php" class="btn btn-warning">Your Questions</a>
            <a href="your-answers.php" class="btn btn-warning">Your Answers</a>
        </div>

        <form name="form1" method="POST" action="keysearch.php" class="search-form">
            <input type="text" value="Enter a search keyword" name="keyword" class="form-control">
            <br>
            <div class="form-row align-items-center">
                <div class="col-md-6 mb-3">
                    <label for="course">course:</label>
                    <select name="course" id="course" class="form-control">
                        <option value="" selected="selected">Select course</option>
                    </select>
                </div>
            </div>
            <br>
            <button type="submit" class="btn btn-primary" name="Submit1">Search by Relevance</button>
            <button type="submit" class="btn btn-primary" formaction="keysearch2.php">Search by Time</button>
        </form>
</body>
</html>
