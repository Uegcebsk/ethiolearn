<?php
include_once("../DB_Files/db.php");

// Function to display success or error messages
function displayMessage($msg, $type = 'success')
{
    return '<div class="alert alert-' . $type . ' col-sm-6 ml-5 mt-2 m-2">' . $msg . '</div>';
}

// Function to check if a question already exists in the database
function isQuestionExists($question_text)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM exam_questions WHERE question_text = ?");
    $stmt->bind_param("s", $question_text);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}

// Process form submission to insert questions
if (isset($_POST['submit_questions'])) {
    $duplicate_questions = [];

    // Check if true/false questions exist
    if (isset($_POST['true_false_questions'])) {
        foreach ($_POST['true_false_questions'] as $question) {
            $question_text = isset($question['question_text']) ? $question['question_text'] : '';
            if (!empty($question_text) && isQuestionExists($question_text)) {
                $duplicate_questions[$question_text] = 'True/False';
            } else {
                // Insert the question into the database
                $stmt = $conn->prepare("INSERT INTO exam_questions (question_text, question_type) VALUES (?, 'True/False')");
                $stmt->bind_param("s", $question_text);
                $stmt->execute();
            }
        }
    }

    // Check if multiple choice questions exist
    if (isset($_POST['multiple_choice_questions'])) {
        foreach ($_POST['multiple_choice_questions'] as $question) {
            $question_text = isset($question['question_text']) ? $question['question_text'] : '';
            if (!empty($question_text) && isQuestionExists($question_text)) {
                $duplicate_questions[$question_text] = 'Multiple Choice';
            } else {
                // Insert the question into the database
                $stmt = $conn->prepare("INSERT INTO exam_questions (question_text, question_type) VALUES (?, 'Multiple Choice')");
                $stmt->bind_param("s", $question_text);
                $stmt->execute();
            }
        }
    }

    // Check if fill-in-the-blank questions exist
    if (isset($_POST['fill_in_the_blank_questions'])) {
        foreach ($_POST['fill_in_the_blank_questions'] as $question) {
            $question_text = isset($question['question_text']) ? $question['question_text'] : '';
            if (!empty($question_text) && isQuestionExists($question_text)) {
                $duplicate_questions[$question_text] = 'Fill in the Blank';
            } else {
                // Insert the question into the database
                $stmt = $conn->prepare("INSERT INTO exam_questions (question_text, question_type) VALUES (?, 'Fill in the Blank')");
                $stmt->bind_param("s", $question_text);
                $stmt->execute();
            }
        }
    }

    // Display message for duplicate questions, if any
    if (!empty($duplicate_questions)) {
        $message = "Duplicate questions found:<br>";
        foreach ($duplicate_questions as $question_text => $question_type) {
            $message .= "Question: $question_text (Type: $question_type)<br>";
        }
        echo displayMessage($message, 'danger');
    } else {
        // If no duplicate questions found, display success message
        $message = "Questions inserted successfully!";
        echo displayMessage($message);
    }
}
?>
