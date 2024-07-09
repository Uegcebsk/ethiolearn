<?php
include_once("../DB_Files/db.php");
include_once("header copy.php");

if (isset($_GET['id'])) {
    $question_id = $_GET['id'];
    $message = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $question_text = $_POST['question_text'];
        $question_type = $_POST['question_type'];
        $opt1 = $_POST['opt1'];
        $opt2 = $_POST['opt2'];
        $opt3 = $_POST['opt3'];
        $opt4 = $_POST['opt4'];
        $correct_answer = $_POST['correct_answer'];

        // Validate inputs
        if (empty($question_text) || empty($question_type) || empty($correct_answer) || ($question_type == 'multiple_choice' && (empty($opt1) || empty($opt2) || empty($opt3) || empty($opt4)))) {
            $message = "All fields are required.";
        } else {
            // Check if the question already exists in the database, excluding the current question
            $sql = "SELECT * FROM exam_questions WHERE question_text = ? AND id != ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('si', $question_text, $question_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $message = "This question already exists.";
            } else {
                // For multiple-choice questions, check if the correct answer is one of the options
                if ($question_type == 'multiple_choice' && !in_array($correct_answer, [$opt1, $opt2, $opt3, $opt4])) {
                    $message = "Correct answer must be one of the options.";
                } else {
                    // Update the question in the database
                    $sql = "UPDATE exam_questions SET question_text = ?, question_type = ?, opt1 = ?, opt2 = ?, opt3 = ?, opt4 = ?, correct_answer = ? WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('sssssssi', $question_text, $question_type, $opt1, $opt2, $opt3, $opt4, $correct_answer, $question_id);

                    if ($stmt->execute()) {
                        $message = "Question updated successfully.";
                        echo "<script>
                        setTimeout(function() {
                            window.location.href = 'success.php?exam_category=" . urlencode($_GET['exam_category']) . "&message=" . urlencode($message) . "';
                        }, 300);
                    </script>";
                    
                        exit;
                    } else {
                        $message = "Error updating question: " . $stmt->error;
                    }

                    $stmt->close();
                }
            }
        }
    }

    // Fetch the current question details
    $sql = "SELECT * FROM exam_questions WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $question_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $question = $result->fetch_assoc();
    $stmt->close();
} else {
    echo "<p>No question ID provided.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Question</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Question</h2>
        <?php if (!empty($message)) echo "<div class='alert alert-info'>$message</div>"; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="question_text">Question Text:</label>
                <textarea id="question_text" name="question_text" class="form-control" rows="4"><?php echo htmlspecialchars($question['question_text']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="question_type">Question Type:</label>
                <select id="question_type" name="question_type" class="form-control">
                    <option value="multiple_choice" <?php if ($question['question_type'] == 'multiple_choice') echo 'selected'; ?>>Multiple Choice</option>
                    <option value="true_false" <?php if ($question['question_type'] == 'true_false') echo 'selected'; ?>>True/False</option>
                    <option value="fill_in_the_blank" <?php if ($question['question_type'] == 'fill_in_the_blank') echo 'selected'; ?>>Fill in the Blank</option>
                </select>
            </div>
            <div id="multiple_choice_options" class="multiple-choice-options" style="display: <?php echo ($question['question_type'] == 'multiple_choice') ? 'block' : 'none'; ?>;">
                <div class="form-group">
                    <label for="opt1">Option 1:</label>
                    <input type="text" id="opt1" name="opt1" class="form-control" value="<?php echo htmlspecialchars($question['opt1']); ?>">
                </div>
                <div class="form-group">
                    <label for="opt2">Option 2:</label>
                    <input type="text" id="opt2" name="opt2" class="form-control" value="<?php echo htmlspecialchars($question['opt2']); ?>">
                </div>
                <div class="form-group">
                    <label for="opt3">Option 3:</label>
                    <input type="text" id="opt3" name="opt3" class="form-control" value="<?php echo htmlspecialchars($question['opt3']); ?>">
                </div>
                <div class="form-group">
                    <label for="opt4">Option 4:</label>
                    <input type="text" id="opt4" name="opt4" class="form-control" value="<?php echo htmlspecialchars($question['opt4']); ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="correct_answer">Correct Answer:</label>
                <input type="text" id="correct_answer" name="correct_answer" class="form-control" value="<?php echo htmlspecialchars($question['correct_answer']); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Update Question</button>
        </form>
    </div>

    <script>
        document.getElementById('question_type').addEventListener('change', function() {
            var displayStyle = (this.value == 'multiple_choice') ? 'block' : 'none';
            document.getElementById('multiple_choice_options').style.display = displayStyle;
        });
    </script>
</body>
</html>
