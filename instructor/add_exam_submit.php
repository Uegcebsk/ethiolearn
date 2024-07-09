<?php
error_reporting(E_ALL); // Turn on error reporting

include_once("../DB_Files/db.php");

// Initialize error message
$errorMessage = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $exam_category = $_POST['exam_category'];
    $questions = $_POST['questions']; // Array of questions
    $questionTypes = $_POST['selected_question_types'];

    // Initialize additional form data
    $options_choose = isset($_POST['options_choose']) ? $_POST['options_choose'] : [];
    $correct_answers = isset($_POST['correct_answers']) ? $_POST['correct_answers'] : [];
    $true_false_answers = isset($_POST['true_false_answers']) ? $_POST['true_false_answers'] : [];
    $fill_blank_answers = isset($_POST['fill_blank_answers']) ? $_POST['fill_blank_answers'] : [];

    // Check if at least one question type is selected
    if (empty($questionTypes)) {
        $errorMessage = "Please select at least one question type.";
    } else {
        // Prepare and execute SQL statement to insert questions
        $sql = "INSERT INTO exam_questions (catergory, question_type, question_text, correct_answer, opt1, opt2, opt3, opt4, ques_no) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bind_param("ssssssssi", $exam_category, $questionType, $question, $correctAnswer, $opt1, $opt2, $opt3, $opt4, $ques_no);

        // Fetch the highest current ques_no value
        $res = mysqli_query($conn, "SELECT MAX(CAST(ques_no AS UNSIGNED)) AS max_ques_no FROM exam_questions");
        $row = mysqli_fetch_assoc($res);
        $max_ques_no = $row['max_ques_no'];

        // Increment the value for the new questions
        $ques_no = $max_ques_no + 1;

        foreach ($questionTypes as $key => $type) {
            $question = $questions[$key];
            $questionType = $type;

            // Check if the question already exists in the database
            $res = mysqli_query($conn, "SELECT * FROM exam_questions WHERE catergory='$exam_category' AND question_text='$question'");
            if (mysqli_num_rows($res) > 0) {
                $errorMessage .= "Question '" . $question . "' already exists. Please enter a different question.<br>";
                continue; // Skip this question and move to the next one
            }

            // Initialize options and correct answer
            $opt1 = $opt2 = $opt3 = $opt4 = $correctAnswer = "";

            // Process options and correct answer based on question type
            if ($type == 1) { // Choose
                $options_choose[$key] = $_POST['options_choose'][$key];
                $correctAnswer = $_POST['correct_answers'][$key]; // Correct answer is directly taken from input field
                $opt1 = $options_choose[$key][0];
                $opt2 = $options_choose[$key][1];
                $opt3 = $options_choose[$key][2];
                $opt4 = $options_choose[$key][3];
            } elseif ($type == 2) { // True/False
                $true_false_answers[$key] = $_POST['true_false_answers'][$key];
                $correctAnswer = $true_false_answers[$key] == 1 ? "True" : "False";
            } elseif ($type == 3) { // Fill in the Blank
                $fill_blank_answers[$key] = $_POST['fill_blank_answers'][$key]; // Correct answer for Fill in the Blank
                $correctAnswer = $fill_blank_answers[$key]; // Set correct answer directly from input
            }

            // Execute the statement
            if (!$stmt->execute()) {
                $errorMessage .= "Error: " . $stmt->error . "<br>"; // Append error message
            }
        }

        // Close statement
        $stmt->close();
    }

    // Update ques_no for existing questions
    $loop = 0;
    $count = 0;
    $res = mysqli_query($conn, "SELECT * FROM exam_questions WHERE catergory='$exam_category' ORDER BY id ASC") or die(mysqli_error($conn));
    $count = mysqli_num_rows($res);
    if ($count > 0) {
        while ($row = mysqli_fetch_array($res)) {
            $loop = $loop + 1;
            mysqli_query($conn, "UPDATE exam_questions SET ques_no='$loop' WHERE id=$row[id]");
        }
    }

    // If there's no error, redirect to success page
if (empty($errorMessage)) {
    header("Location: success.php?exam_category=" . urlencode($exam_category));
    exit();
} else {
    // If there are errors, redirect back to the form with error message and form data
    $formData = array(
        'exam_category' => $exam_category,
        'questions' => implode(',', $questions),
        'selected_question_types' => implode(',', $questionTypes),
        'options_choose' => json_encode($options_choose),
        'correct_answers' => implode(',', $correct_answers),
        'true_false_answers' => implode(',', $true_false_answers),
        'fill_blank_answers' => implode(',', $fill_blank_answers)
    );
    header("Location: add_exam.php?error=" . urlencode($errorMessage) . "&" . http_build_query($formData));
    exit();
}

}
?>
