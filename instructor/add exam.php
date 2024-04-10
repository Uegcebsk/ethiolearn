<?php
include_once("Header copy.php");
include_once("../DB_Files/db.php");

// Initialize error and success messages
$errorMessage = "";
$successMessage = "";

// Retrieve the exam_name from the form submission
$exam_name = isset($_POST['name']) ? $_POST['name'] : '';

// Define the question types and their corresponding IDs
$questionTypes = array(
    1 => 'Choose',
    2 => 'True/False',
    3 => 'Fill in the Blank'
);

// Retrieve the number of questions and their types
$numQuestions = isset($_POST['num_questions']) ? (int)$_POST['num_questions'] : 0;
$questionTypesSelected = isset($_POST['question_types']) ? $_POST['question_types'] : array();

// Set minimum and maximum input lengths for questions and answers
$minQuestionLength = 5;
$maxQuestionLength = 255;
$minAnswerLength = 1;
$maxAnswerLength = 100;

// Define HTML form fields based on the number and types of questions
$formFields = '';
for ($i = 0; $i < $numQuestions; $i++) {
    $formFields .= '<div class="form-group">';
    $formFields .= '<label for="question' . ($i + 1) . '">Question ' . ($i + 1) . '</label>';
    $formFields .= '<input type="text" id="question' . ($i + 1) . '" name="questions[]" class="form-control">';
    $formFields .= '</div>';

    $formFields .= '<div class="form-group">';
    $formFields .= '<label for="answer' . ($i + 1) . '">Correct Answer ' . ($i + 1) . '</label>';
    if (in_array(1, $questionTypesSelected)) {
        // Choose question type
        $formFields .= '<input type="text" id="answer' . ($i + 1) . '" name="answers_choose[]" class="form-control">';
        // Additional option fields for Choose questions
        for ($j = 1; $j <= 4; $j++) {
            $formFields .= '<input type="text" id="option' . ($i + 1) . '_' . $j . '" name="options_choose[' . $i . '][]" class="form-control" placeholder="Option ' . $j . '">';
        }
    } elseif (in_array(2, $questionTypesSelected)) {
        // True/False question type
        $formFields .= '<select id="answer' . ($i + 1) . '" name="answers_true_false[]" class="form-control">';
        $formFields .= '<option value="True">True</option>';
        $formFields .= '<option value="False">False</option>';
        $formFields .= '</select>';
    } elseif (in_array(3, $questionTypesSelected)) {
        // Fill in the Blank question type
        $formFields .= '<input type="text" id="answer' . ($i + 1) . '" name="answers_fill[]" class="form-control">';
    }
    $formFields .= '</div>';
}

if (isset($_POST['quesSubmitBtn'])) {
    // Validate if all fields are filled
    if (empty($_POST['questions'])) {
        $errorMessage = '<div class="alert alert-warning col-sm-6 ml-5 mt-2">All Questions Required</div>';
    } else {
        $questions = $_POST['questions'];
        $answers_choose = isset($_POST['answers_choose']) ? $_POST['answers_choose'] : array();
        $answers_true_false = isset($_POST['answers_true_false']) ? $_POST['answers_true_false'] : array();
        $answers_fill = isset($_POST['answers_fill']) ? $_POST['answers_fill'] : array();
        $options_choose = isset($_POST['options_choose']) ? $_POST['options_choose'] : array();

        // Validate each question and answer
        foreach ($questions as $key => $question) {
            // Check if question is empty
            if (empty($question)) {
                $errorMessage = '<div class="alert alert-warning col-sm-6 ml-5 mt-2">Question ' . ($key + 1) . ' is empty</div>';
                break;
            }
            // Check question length
            if (strlen($question) < $minQuestionLength || strlen($question) > $maxQuestionLength) {
                $errorMessage = '<div class="alert alert-warning col-sm-6 ml-5 mt-2">Question ' . ($key + 1) . ' must be between ' . $minQuestionLength . ' and ' . $maxQuestionLength . ' characters</div>';
                break;
            }
            // Check answer lengths for Choose questions
            if (in_array(1, $questionTypesSelected) && isset($answers_choose[$key]) && (strlen($answers_choose[$key]) < $minAnswerLength || strlen($answers_choose[$key]) > $maxAnswerLength)) {
                $errorMessage = '<div class="alert alert-warning col-sm-6 ml-5 mt-2">Answer for question ' . ($key + 1) . ' must be between ' . $minAnswerLength . ' and ' . $maxAnswerLength . ' characters</div>';
                break;
            }
            // Check answer lengths for Fill in the Blank questions
            if (in_array(3, $questionTypesSelected) && isset($answers_fill[$key]) && (strlen($answers_fill[$key]) < $minAnswerLength || strlen($answers_fill[$key]) > $maxAnswerLength)) {
                $errorMessage = '<div class="alert alert-warning col-sm-6 ml-5 mt-2">Answer for question ' . ($key + 1) . ' must be between ' . $minAnswerLength . ' and ' . $maxAnswerLength . ' characters</div>';
                break;
            }
        }

        // If no errors, insert questions into the database
        if (empty($errorMessage)) {
            // Insert the questions into the database
            // Use prepared statements to prevent SQL injection
            $insertQuestionStmt = $conn->prepare("INSERT INTO exam_questions (category_id, question_text, correct_answer, opt1, opt2, opt3, opt4, question_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

            foreach ($questions as $key => $question) {
                $questionType = $questionTypesSelected[$key];
                $correctAnswer = '';
            
                // Retrieve correct answer based on question type
                switch ($questionType) {
                    case 1: // Choose question type
                        $correctAnswer = isset($answers_choose[$key]) ? $answers_choose[$key] : '';
                        break;
                    case 2: // True/False question type
                        $correctAnswer = isset($answers_true_false[$key]) ? $answers_true_false[$key] : '';
                        break;
                    case 3: // Fill in the Blank question type
                        $correctAnswer = isset($answers_fill[$key]) ? $answers_fill[$key] : '';
                        break;
                    default:
                        break;
                }
            
                // Bind parameters and execute query
                $option1 = isset($options_choose[$key][0]) ? $options_choose[$key][0] : '';
                $option2 = isset($options_choose[$key][1]) ? $options_choose[$key][1] : '';
                $option3 = isset($options_choose[$key][2]) ? $options_choose[$key][2] : '';
                $option4 = isset($options_choose[$key][3]) ? $options_choose[$key][3] : '';
            
                $insertQuestionStmt->bind_param("sssssssi", $exam_name, $question, $correctAnswer, $option1, $option2, $option3, $option4, $questionType);
                $insertQuestionStmt->execute();
            }
            

            $insertQuestionStmt->close();
            $successMessage = '<div class="alert alert-success col-sm-6 ml-5 mt-2">Questions added successfully</div>';
        }
    }
}
?>

<?php
include_once("Footer.php");
?>

<div class="container" style="padding:5%;">
    <div class="col-sm-11 mt-5 jumbotron">
        <h3 class="text-center">Add Exam Questions</h3>
        <form id="addQuestionForm" method="POST" enctype="multipart/form-data">
            <br>
            <div class="form-group">
                <label for="name">Exam Category</label>
                <input type="text" id="name" name="name" value="<?php echo $exam_name; ?>" class="form-control fw-bold bg-transparent border-0 text-dark" readonly>
            </div>
            <br>
            <div class="form-group">
                <label for="num_questions">Number of Questions</label>
                <input type="number" id="num_questions" name="num_questions" class="form-control" min="1" required>
            </div>
            <br>
            <div class="form-group">
                <label for="question_types">Question Types</label><br>
                <?php foreach ($questionTypes as $id => $type) { ?>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="question_type_<?php echo $id; ?>" name="question_types[]" value="<?php echo $id; ?>">
                        <label class="form-check-label" for="question_type_<?php echo $id; ?>"><?php echo $type; ?></label>
                    </div>
                <?php } ?>
            </div>
            <br>
            <!-- Dynamic form fields based on number of questions and types -->
            <?php echo $formFields; ?>
            <div class="text-center">
                <button class="btn btn-danger" type="submit" id="quesSubmitBtn" name="quesSubmitBtn" onclick="disableButton()">Submit</button>
                <a href="AddQuizz.php" class="btn btn-secondary">Close</a>
            </div>
        </form>
        <div id="messageDiv">
            <?php echo $successMessage; ?>
            <?php echo $errorMessage; ?>
        </div>
    </div>
</div>

<?php
include_once("Footer.php");
?>

<script>
    function disableButton() {
        $('#quesSubmitBtn').prop('disabled', true); // Disable the submit button
    }
    $(document).ready(function() {
        $('#addQuestionForm').submit(function(e) {
            e.preventDefault(); // Prevent form submission
            console.log('Form submitted'); // Debug statement
            $.ajax({
                type: 'POST',
                url: 'add_question.php',
                data: $('#addQuestionForm').serialize(), // Serialize form data
                success: function(response) {
                    console.log('AJAX success'); // Debug statement
                    $('#messageDiv').html(response); // Show success/error message
                    $('#quesSubmitBtn').prop('disabled', false); // Enable the submit button after AJAX success
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', error); // Log any errors to the console
                    $('#quesSubmitBtn').prop('disabled', false); // Enable the submit button after AJAX error
                }
            });
        });
    });
</script>
