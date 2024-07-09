<?php
include_once("Header copy.php");
include_once("../DB_Files/db.php");

// Initialize error and success messages
$errorMessage = "";
$successMessage = "";

// Define the question types and their corresponding IDs
$questionTypes = array(
    1 => 'Choose',
    2 => 'True/False',
    3 => 'Fill in the Blank'
);

// Fetch exam name from $_REQUEST if available
$exam_name = "";
if (isset($_REQUEST['view'])) {
    if (isset($_REQUEST['id']) && !empty($_REQUEST['id'])) {
        $id = $_REQUEST['id'];
        $sql = "SELECT * FROM exam_category WHERE id=$id";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $exam_name = $row['exam_name'];
        }
    } else {
        // Handle case when id is not set or empty
        $errorMessage = "Invalid exam category ID.";
    }
}

// Handle form submission for generating form fields
$formFields = '';
$selectedQuestionTypes = [];
if (isset($_POST['generateFormBtn']) || isset($_GET['questions'])) {
    // Retrieve the exam_name from the form submission or URL parameters
    $exam_name = isset($_POST['name']) ? $_POST['name'] : (isset($_GET['exam_category']) ? $_GET['exam_category'] : '');

    // Retrieve the number of questions and their types
    $selectedQuestionTypes = isset($_POST['question_types']) ? $_POST['question_types'] : (isset($_GET['selected_question_types']) ? explode(',', $_GET['selected_question_types']) : []);

    // Check if at least one question type is selected
    if (empty($selectedQuestionTypes)) {
        $errorMessage = '<div class="alert alert-danger col-sm-6 ml-5 mt-2">Please select at least one question type.</div>';
    } else {
        // Set minimum and maximum input lengths for questions and answers
        $minQuestionLength = 5;
        $maxQuestionLength = 255;
        $minAnswerLength = 1;
        $maxAnswerLength = 100;

        // Retrieve questions and options from URL parameters if available
        $questions = isset($_GET['questions']) ? explode(',', $_GET['questions']) : [];
        $options_choose = isset($_GET['options_choose']) ? json_decode($_GET['options_choose'], true) : [];
        $correct_answers = isset($_GET['correct_answers']) ? explode(',', $_GET['correct_answers']) : [];
        $true_false_answers = isset($_GET['true_false_answers']) ? explode(',', $_GET['true_false_answers']) : [];
        $fill_blank_answers = isset($_GET['fill_blank_answers']) ? explode(',', $_GET['fill_blank_answers']) : [];

        // Define HTML form fields based on the number and types of questions
        foreach ($selectedQuestionTypes as $i => $type) {
            $formFields .= '<div class="form-group">';
            $formFields .= '<label for="question' . ($i + 1) . '">Question ' . ($i + 1) . '</label>';
            $formFields .= '<input type="text" id="question' . ($i + 1) . '" name="questions[]" class="form-control" maxlength="' . $maxQuestionLength . '" value="' . (isset($questions[$i]) ? htmlspecialchars($questions[$i]) : '') . '">';
            $formFields .= '</div>';

            // Additional options for Choose questions
            if ($type == 1) {
                $formFields .= '<div class="form-group">';
                for ($j = 1; $j <= 4; $j++) {
                    $formFields .= '<label for="option' . ($i + 1) . '_' . $j . '">Option ' . $j . '</label>';
                    $formFields .= '<input type="text" id="option' . ($i + 1) . '_' . $j . '" name="options_choose[' . $i . '][]" class="form-control" maxlength="' . $maxAnswerLength . '" value="' . (isset($options_choose[$i][$j - 1]) ? htmlspecialchars($options_choose[$i][$j - 1]) : '') . '">';
                }
                $formFields .= '</div>';

                // Text input field for the correct answer
                $formFields .= '<div class="form-group">';
                $formFields .= '<label for="correct_answer' . ($i + 1) . '">Correct Answer ' . ($i + 1) . '</label>';
                $formFields .= '<input type="text" id="correct_answer' . ($i + 1) . '" name="correct_answers[]" class="form-control" placeholder="Enter Correct Answer" maxlength="' . $maxAnswerLength . '" value="' . (isset($correct_answers[$i]) ? htmlspecialchars($correct_answers[$i]) : '') . '">';
                $formFields .= '</div>';
            }

            // True/False question type
            if ($type == 2) {
                $formFields .= '<div class="form-group">';
                $formFields .= '<label for="true_false' . ($i + 1) . '">True/False ' . ($i + 1) . '</label>';
                $formFields .= '<select id="true_false' . ($i + 1) . '" name="true_false_answers[]" class="form-control">';
                $formFields .= '<option value="1"' . (isset($true_false_answers[$i]) && $true_false_answers[$i] == "1" ? ' selected' : '') . '>True</option>';
                $formFields .= '<option value="0"' . (isset($true_false_answers[$i]) && $true_false_answers[$i] == "0" ? ' selected' : '') . '>False</option>';
                $formFields .= '</select>';
                $formFields .= '</div>';
            }

            // Input field for Fill in the Blank questions
            if ($type == 3) {
                $formFields .= '<div class="form-group">';
                $formFields .= '<label for="fill_blank' . ($i + 1) . '">Fill in the Blank ' . ($i + 1) . '</label>';
                $formFields .= '<input type="text" id="fill_blank' . ($i + 1) . '" name="fill_blank_answers[]" class="form-control" placeholder="Enter Correct Answer" maxlength="' . $maxAnswerLength . '" value="' . (isset($fill_blank_answers[$i]) ? htmlspecialchars($fill_blank_answers[$i]) : '') . '">';
                $formFields .= '</div>';
            }
        }
    }
}

// Display error message if present
if (isset($_GET['error'])) {
    $errorMessage = '<div class="alert alert-danger col-sm-6 ml-5 mt-2">' . htmlspecialchars($_GET['error']) . '</div>';
}

// Include the footer
include_once("Footer.php");
?>

<!-- HTML form for generating form fields -->
<div class="container" style="padding:6%;">
    <div class="col-sm-11 mt-5 jumbotron">
        <h3 class="text-center">Generate Exam Questions</h3>
        <form id="generateForm" method="POST" enctype="multipart/form-data">
            <br>
            <div class="form-group">
                <input type="hidden" name="exam_category" value="<?php echo htmlspecialchars($exam_name); ?>">
                <label for="course_name">Exam Category</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($exam_name); ?>" class="form-control fw-bold bg-transparent border-0 text-dark" readonly>
            </div>
            <br>
            <div class="form-group">
                <label for="question_types">Question Types</label><br>
                <?php foreach ($questionTypes as $id => $type) { ?>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="question_type_<?php echo $id; ?>" name="question_types[]" value="<?php echo $id; ?>"
                               <?php echo in_array($id, $selectedQuestionTypes) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="question_type_<?php echo $id; ?>"><?php echo $type; ?></label>
                    </div>
                <?php } ?>
            </div>
            <br>
            <!-- Submit button to generate form fields -->
            <div class="text-center">
                <button class="btn btn-primary" type="submit" id="generateFormBtn" name="generateFormBtn">Generate Form</button>
            </div>
        </form>
    </div>
</div>

<!-- HTML form for submitting questions -->
<div class="container" style="padding:7%;">
    <div class="col-sm-11 mt-5 jumbotron">
        <h3 class="text-center">Add Exam Questions</h3>
        <form id="addQuestionForm" method="POST" enctype="multipart/form-data" action="add_exam_submit.php">
            <br>
            <div class="form-group">
                <input type="hidden" name="exam_category" value="<?php echo htmlspecialchars($exam_name); ?>">
                <label for="course_name">Exam Category</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($exam_name); ?>" class="form-control fw-bold bg-transparent border-0 text-dark" readonly>
            </div>
            <br>
            <!-- Display success/error messages -->
            <div id="messageDiv">
                <?php echo $successMessage; ?>
                <?php
                if (!empty($errorMessage)) {
                    echo $errorMessage;
                }
                ?>
            </div>

            <!-- Form fields will be populated dynamically based on the form generated -->
            <div id="formFieldsContainer">
                <?php echo $formFields; ?>
            </div>
            <!-- Hidden input to store selected question types -->
            <?php if (isset($selectedQuestionTypes)) {
                foreach ($selectedQuestionTypes as $selectedType) {
                    echo '<input type="hidden" name="selected_question_types[]" value="' . $selectedType . '">';
                }
            } ?>
            <br>
            <!-- Submit button to submit questions -->
            <div class="text-center">
                <button class="btn btn-danger" type="submit" id="quesSubmitBtn" name="quesSubmitBtn" onclick="return validateForm()">Submit Questions</button>
                <a href="Add exams.php" class="btn btn-secondary">Close</a>
            </div>
        </form>
    </div>
</div>

<!-- Include jQuery library -->
<script src="/ethiolearn/js/jquery-3.3.1.min.js"></script>
<script>
// Function to validate the form before submitting
function validateForm() {
    let isValid = true;
    let errorMessage = '';

    // Check for duplicate questions
    let questions = [];
    $('input[name="questions[]"]').each(function() {
        let question = $(this).val().trim();
        if (questions.includes(question)) {
            isValid = false;
            errorMessage += 'Duplicate question detected: ' + question + '<br>';
        }
        questions.push(question);
    });

    // Validate Choose questions
    $('input[name^="options_choose"]').each(function() {
        let options = $(this).closest('.form-group').find('input[name^="options_choose"]').map(function() {
            return $(this).val().trim();
        }).get();

        if (new Set(options).size !== options.length) {
            isValid = false;
            errorMessage += 'Options must be unique for: ' + $(this).closest('.form-group').find('input[name="questions[]"]').val() + '<br>';
        }

        let correctAnswer = $(this).closest('.form-group').find('input[name="correct_answers[]"]').val().trim();
        if (!options.includes(correctAnswer)) {
            isValid = false;
            errorMessage += 'Correct answer must be one of the options for: ' + $(this).closest('.form-group').find('input[name="questions[]"]').val() + '<br>';
        }
    });

    // Display error message if validation fails
    if (!isValid) {
        $('#messageDiv').html('<div class="alert alert-danger col-sm-6 ml-5 mt-2">' + errorMessage + '</div>');
    }
    return isValid;
}
</script>
<?php
include_once("Footer.php");
?>
