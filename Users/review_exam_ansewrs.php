<?php
include_once("ProfileHeader.php");
include_once("../DB_Files/db.php");

// Fetch the exam category from the GET parameter
if (isset($_GET['exam_category'])) {
    $examCategory = $_GET['exam_category'];
} else {
    echo "<p class='text-center'>Exam category not provided.</p>";
    exit;
}

// Fetch student ID from session
$studentId = $_SESSION['stu_id'];

// Fetch questions and correct answers from the database
$sql = "SELECT ques_no, question_text, correct_answer, question_type, opt1, opt2, opt3, opt4 FROM exam_questions WHERE catergory = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $examCategory);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container" style="padding: 4%;">
    <div class="row justify-content-center">
        <div class="col-sm-11 mt-4">
            <p class="bg-dark text-white p-2 fw-bolder text-center">Review Exam Answers</p>
            <br>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $quesNo = $row["ques_no"];
                    $question = $row["question_text"];
                    $correctAnswer = $row["correct_answer"];
                    $questionType = $row["question_type"];
                    $studentAnswer = isset($_SESSION["answer"][$quesNo]) ? $_SESSION["answer"][$quesNo] : "Not Answered";
                    
                    // Determine if the student's answer is correct
                    $isCorrect = strtolower($studentAnswer) == strtolower($correctAnswer);
                    $statusIcon = $isCorrect ? "<span style='color: green;'>&#10004;</span>" : "<span style='color: red;'>&#10008;</span>";
                    ?>
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="card-title">Question <?php echo $quesNo; ?> <?php echo $statusIcon; ?></h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text"><strong>Question:</strong> <?php echo $question; ?></p>
                            <?php if ($questionType == 'multiple_choice') { ?>
                                <p class="card-text"><strong>Options:</strong></p>
                                <ul>
                                    <li><?php echo "A.) ".$row["opt1"]; ?></li>
                                    <li><?php echo "B.) ".$row["opt2"]; ?></li>
                                    <li><?php echo "C.) ".$row["opt3"]; ?></li>
                                    <li><?php echo "D.) ".$row["opt4"]; ?></li>
                                </ul>
                            <?php } ?>
                            <p class="card-text"><strong>Your Answer:</strong> <?php echo htmlspecialchars($studentAnswer); ?></p>
                            <p class="card-text"><strong>Correct Answer:</strong> <?php echo htmlspecialchars($correctAnswer); ?></p>
                            <p class="card-text"><strong>Question Type:</strong> <?php echo htmlspecialchars($questionType); ?></p>
                        </div>
                    </div>

                    <?php
                }
            } else {
                echo "<p class='text-center'>No questions found for the selected exam category.</p>";
            }
            echo "<a href='exam_courses.php'><button type='button' name='mainmenu' class='btn btn-danger text-light fw-bolder'>Main Menu</button></a>";

            ?>
        </div>
        
    </div>
</div>
?>
