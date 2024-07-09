<?php
// Include necessary files
include_once("../DB_Files/db.php");
include_once("../Inc/Header.php");

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['stu_id'])) {
    header("Location: /ethiolearn/Login&SignIn.php");
    exit();
}

// Get question ID from URL
$Q_id = $_GET['Q_id'];

// Fetch the question from the database
$sql = "SELECT * FROM questions WHERE Q_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $Q_id);
$stmt->execute();
$result = $stmt->get_result();
$question = $result->fetch_assoc();

if (!$question) {
    echo "Question not found.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $q_body = $_POST['q_body'];

    // Update the question in the database
    $update_sql = "UPDATE questions SET q_body = ? WHERE Q_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("si", $q_body, $Q_id);

    if ($update_stmt->execute()) {
        header("Location: my-questions.php");
        exit();
    } else {
        echo "Error updating question.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Question</title>
    <link rel="stylesheet" href="/ethiolearn/bootstrap/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Arial', sans-serif;
        }

        .container {
            margin-top: 3%;
            max-width: 600px;
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
</head>
<body>
    <?php include_once("menu.php"); ?>
    <div class="container">
        <h1 class="my-5">Edit Question</h1>

        <form method="POST" action="">
            <div class="form-group">
                <label for="q_body">Question Body:</label>
                <textarea name="q_body" id="q_body" class="form-control" rows="5"><?php echo htmlspecialchars($question['q_body']); ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update Question</button>
        </form>
    </div>
</body>
</html>
