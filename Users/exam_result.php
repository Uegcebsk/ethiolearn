<?php
include_once("ProfileHeader.php");
include_once("../DB_Files/db.php");

// Initialize variables
$correct = 0;
$mark = 0;

// Check if the session answer is set and not null
if (isset($_SESSION["answer"]) && is_array($_SESSION["answer"])) {
    // Loop through each question
    foreach ($_SESSION["answer"] as $questionNumber => $userAnswer) {
        // Retrieve the correct answer from the database
        $res = mysqli_query($conn, "SELECT correct_answer FROM exam_questions WHERE catergory='$_SESSION[exam_category]' AND ques_no=$questionNumber");
        
        // Check if a row is returned
        if ($res && mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            $correctAnswer = $row["correct_answer"];

            // Convert both answers to lowercase for case-insensitive comparison
            $userAnswerLower = strtolower($userAnswer);
            $correctAnswerLower = strtolower($correctAnswer);

            // Compare the answers
            if ($correctAnswerLower == $userAnswerLower) {
                $correct++;
            }
        }
    }
} else {
    // Handle the case where $_SESSION["answer"] is not set or not an array
    echo "No answers found!";
    exit; // Exit to prevent further execution
}

// Calculate total questions
$count = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM exam_questions WHERE catergory='$_SESSION[exam_category]'"));
// Calculate wrong answers
$wrong = $count - $correct;
// Calculate mark
if ($count > 0) {
    $mark = ($correct / $count) * 100;
}

// Display result
echo "<div class='container' style='padding: 5%;'>";
echo "<div class='col-sm-12 mt-5 bg-transparent carousel-fade ms-5'>";
echo "<h5 class='bg-dark card text-white p-2 text-center'>Result</h5>";
echo "<br><br>";
echo "<center>";
echo "<h4 class='fw-bolder text-dark'>Total Questions: $count</h4>";
echo "<h4 class='fw-bolder text-dark'>Correct Answers: $correct</h4>";
echo "<h4 class='fw-bolder text-dark'>Wrong Answers: $wrong</h4>";
echo "<h4 class='fw-bolder text-dark'>Your Marks: $mark</h4>";
echo "</center>";
echo "<br><br><br><br>";

// Get current date and time
$date = date("Y-m-d H:i:s");

// Insert data into exam_results table
$insertResultQuery = "INSERT INTO exam_results (student_id, exam_category, total_questions, correct_answers, wrong_answers, exam_time, mark) VALUES ('$_SESSION[stu_id]', '$_SESSION[exam_category]', '$count', '$correct', '$wrong', '$date', '$mark')";
if (mysqli_query($conn, $insertResultQuery)) {
    echo "<div class='alert alert-success text-center'>Result inserted successfully!</div>";
} else {
    echo "<div class='alert alert-danger text-center'>Error inserting result: " . mysqli_error($conn) . "</div>";
}

echo "<br><br>";
echo "<div class='container'>";
echo "<div class='col-md-12 text-center'>";
echo "<a href='EnrollExam.php'><button type='button' name='mainmenu' class='btn btn-danger text-light fw-bolder'>Main Menu</button></a>";
echo "<a href='review_exam_ansewrs.php?exam_category=" . $_SESSION['exam_category'] . "'><button type='button' name='review' class='btn btn-primary text-light fw-bolder'>Review All Questions</button></a>";
echo "</div>";
echo "</div>";

echo "</div>";
echo "</div>";

// Unset exam start session
unset($_SESSION["exam_start"]);
?>
