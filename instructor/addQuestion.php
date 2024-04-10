<?php
include_once("Header copy.php");
include_once("../DB_Files/db.php");

// Initialize error and success messages
$errorMessage = "";
$successMessage = "";

// Retrieve the exam_name from the form submission
$exam_name = isset($_POST['name']) ? $_POST['name'] : '';

// Set minimum and maximum input lengths for questions and answers
$minQuestionLength = 10;
$maxQuestionLength = 100;
$minAnswerLength = 3;
$maxAnswerLength = 20;

if (isset($_POST['quesSubmitBtn'])) {
    // Validate if all fields are filled
    if (
        ($_POST['add_ques'] == "") || ($_POST['ans1'] == "") || ($_POST['ans2'] == "") || 
        ($_POST['ans3'] == "") || ($_POST['ans4'] == "") || ($_POST['correct_ans'] == "") || 
        ($_POST['name'] == "")
    ) {
        $errorMessage = '<div class="alert alert-warning col-sm-6 ml-5 mt-2">All Fields Required</div>';
    } else {
        $add_ques = $_POST['add_ques'];
        $ans1 = $_POST['ans1'];
        $ans2 = $_POST['ans2'];
        $ans3 = $_POST['ans3'];
        $ans4 = $_POST['ans4'];
        $correct_ans = $_POST['correct_ans'];
        $name = $_POST['name'];

        // Validate question length
        if (strlen($add_ques) < $minQuestionLength || strlen($add_ques) > $maxQuestionLength) {
            $errorMessage = '<div class="alert alert-warning col-sm-6 ml-5 mt-2">Question must be between '.$minQuestionLength.' and '.$maxQuestionLength.' characters</div>';
        }
        // Validate answer lengths
        elseif (
            strlen($ans1) < $minAnswerLength || strlen($ans1) > $maxAnswerLength ||
            strlen($ans2) < $minAnswerLength || strlen($ans2) > $maxAnswerLength ||
            strlen($ans3) < $minAnswerLength || strlen($ans3) > $maxAnswerLength ||
            strlen($ans4) < $minAnswerLength || strlen($ans4) > $maxAnswerLength
        ) {
            $errorMessage = '<div class="alert alert-warning col-sm-6 ml-5 mt-2">Answer must be between '.$minAnswerLength.' and '.$maxAnswerLength.' characters</div>';
        } else {
            // Check if correct answer is one of the choices
            $answerChoices = array($ans1, $ans2, $ans3, $ans4);
            if (!in_array($correct_ans, $answerChoices)) {
                $errorMessage = '<div class="alert alert-warning col-sm-6 ml-5 mt-2">Correct answer must be one of the choices</div>';
            } else {
                // Check for similar questions
                $similarQuestionQuery = "SELECT * FROM add_ques WHERE question='$add_ques' AND catergory='$name'";
                $similarQuestionResult = $conn->query($similarQuestionQuery);
                if ($similarQuestionResult->num_rows > 0) {
                    $errorMessage = '<div class="alert alert-warning col-sm-6 ml-5 mt-2">Similar question already exists</div>';
                } else {
                    // Logic to update question numbers
                    $loop = 0;
                    $count = 0;
                    $res = mysqli_query($conn, "SELECT * FROM add_ques WHERE catergory='$name' ORDER BY id ASC") or die(mysqli_error($conn));
                    $count = mysqli_num_rows($res);
                    if ($count > 0) {
                        while ($row = mysqli_fetch_array($res)) {
                            $loop = $loop + 1;
                            mysqli_query($conn, "UPDATE add_ques SET ques_no='$loop' WHERE id=$row[id]");
                        }
                    }
                    $loop = $loop + 1;

                    // Insert the new question
                    $sql = "INSERT INTO add_ques(ques_no, question, opt1, opt2, opt3, opt4, answer, catergory) VALUES ('$loop','$add_ques','$ans1','$ans2','$ans3','$ans4','$correct_ans','$name')";

                    if ($conn->query($sql) == TRUE) {
                        $successMessage = "Question Added Successfully";
                        
                        // Generate notification for quiz addition
                        $notification_type = "quiz";
                        $notification_message = "New quiz question added: $add_ques";
                        $notification_date = date("Y-m-d H:i:s");

                        // Insert notification into database
                        $insert_notification_query = "INSERT INTO notifications (notification_type, notification_message, notification_date, is_read) 
                                                      VALUES (?, ?, ?, 0)";
                        $stmt_insert_notification = $conn->prepare($insert_notification_query);
                        
                        // Bind parameters
                        $stmt_insert_notification->bind_param("sss", $notification_type, $notification_message, $notification_date);

                        if ($stmt_insert_notification->execute()) {
                            // Notification added successfully
                        } else {
                            $errorMessage = "Failed to add notification";
                        }
                        $stmt_insert_notification->close();
                    } else {
                        $errorMessage = "Question Added Failed";
                    }
                }
            }
        }
    }
}

// Handle question deletion
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_query = "DELETE FROM add_ques WHERE id='$delete_id'";
    if ($conn->query($delete_query) === TRUE) {
        $successMessage = "Question Deleted Successfully";
    } else {
        $errorMessage = "Error deleting question: " . $conn->error;
    }
}
?>

<?php
include_once("Footer.php");
?>

<div class="container" style="padding:5%;">
    <div class="col-sm-11 mt-5 jumbotron">
        <?php
        if (isset($_REQUEST['view'])) {
            $id = $_REQUEST['id'];
            $sql = "SELECT * FROM exam_category WHERE id=$id";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $exam_name = $row['exam_name'];
        }
        ?>
        <h3 class="text-center">Add Question</h3>
        <form id="addQuestionForm" method="POST" enctype="multipart/form-data">
            <br>
            <div class="form-group">
                <label for="course_name">Exam Category</label>
                <input type="text" id="name" name="name" value="<?php echo $exam_name; ?>" class="form-control fw-bold bg-transparent border-0 text-dark" readonly>
            </div>
            <br>
            <div class="form-group">
                <label for="course_name">Add Question</label>
                <input type="text" id="add_ques" name="add_ques" class="form-control">
            </div>
            <br>
            <label for="course_desc">Answer 01</label>
            <input type="text" id="ans1" name="ans1" row=2 class="form-control">
            <br>
            <div class="form-group">
                <label for="course_desc">Answer 02</label>
                <input type="text" id="ans2" name="ans2" row=2 class="form-control">
            </div>
            <br>
            <div class="form-group">
                <label for="course_desc">Answer 03</label>
                <input type="text" id="ans3" name="ans3" row=2 class="form-control">
            </div>
            <br>
            <div class="form-group">
                <label for="course_desc">Answer 04</label>
                <input type="text" id="ans4" name="ans4" class="form-control">
            </div>
            <br>
            <div class="form-group">
                <label for="course_desc">Correct Answer</label>
                <input type="text" id="correct_ans" name="correct_ans" row=2 class="form-control">
            </div>
            <div class="text-center">
                <button class="btn btn-danger" type="submit" id="quesSubmitBtn" name="quesSubmitBtn" onclick="disableButton()">Submit</button>
                <a href="AddQuizz.php" class="btn btn-secondary">Close</a>
            </div>
        </form>
        <div id="messageDiv">
            <?php echo $successMessage; ?>
            <?php echo $errorMessage; ?>
        </div>
        <div class="col-lg-12">
            <div class="card bg-transparent">
                <div class="card-body">
                    <?php
                    $sql = "SELECT * FROM add_ques WHERE catergory='$exam_name'";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                    ?>
                        <table class="table">
                            <thead class="">
                                <tr>
                                    <th class="text-dark" scope="col">ID</th>
                                    <th class="text-dark" scope="col">Question</th>
                                    <th class="text-dark" scope="col">Ans 1</th>
                                    <th class="text-dark" scope="col">Ans 2</th>
                                    <th class="text-dark" scope="col">Ans 3</th>
                                    <th class="text-dark" scope="col">Ans 4</th>
                                    <th scope="col">Correct Ans</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()) {
                                    echo '<tr>';
                                    echo '<th class="text-dark" scope="row">' . $row['id'] . '</th>';
                                    echo '<td class="text-dark">' . $row['question'] . '</td>';
                                    echo '<td class="text-dark">' . $row['opt1'] . '</td>';
                                    echo '<td class="text-dark">' . $row['opt2'] . '</td>';
                                    echo '<td class="text-dark">' . $row['opt3'] . '</td>';
                                    echo '<td class="text-dark">' . $row['opt4'] . '</td>';
                                    echo '<td class="text-dark">' . $row['answer'] . '</td>';
                                    echo '<td>';
                                    echo '
                                        <form action="" method="GET" class="d-inline">
                                            <input type="hidden" name="delete" value="' . $row["id"] . '">
                                            <button type="submit" class="btn btn-danger mr-3" name="deleteBtn" value="Delete"><i class="fas fa-trash"></i></button>
                                        </form>
                                        <form action="editQuiz.php" method="POST" class="d-inline">
                                            <input type="hidden" name="id" value=' . $row["id"] . '>
                                            <button type="submit" class="btn btn-info" name="view" value="View"><i class="fas fa-pen"></i></button>
                                        </form>
                                    </td>
                                </tr>';
                                } ?>
                            </tbody>
                        </table>
                    <?php } else {
                        echo "Exam Not Found";
                    }
                    ?>
                </div>
            </div>
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
$(document).ready(function(){
    $('#addQuestionForm').submit(function(e){
        e.preventDefault(); // Prevent form submission
        console.log('Form submitted'); // Debug statement
        $.ajax({
            type: 'POST',
            url: 'add_question.php',
            data: $('#addQuestionForm').serialize(), // Serialize form data
            success: function(response){
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
