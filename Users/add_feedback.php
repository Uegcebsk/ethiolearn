<?php
include_once("../DB_Files/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form fields are set and not empty
    if (isset($_POST["feedback_id"]) && isset($_POST["feedback"]) && !empty($_POST["feedback_id"]) && !empty($_POST["feedback"])) {
        $feedbackId = $_POST["feedback_id"];
        $feedbackContent = $_POST["feedback"];

        // Insert feedback into the database
        $sql = "INSERT INTO feedback (f_content, stu_id) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $feedbackContent, $feedbackId);

        if ($stmt->execute()) {
            $passmsg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert">Feedback Submitted</div>';
        } else {
            $passmsg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert">Feedback Submission Failed</div>';
        }
    } else {
        $passmsg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert">All Fields Required</div>';
    }
}
?>
