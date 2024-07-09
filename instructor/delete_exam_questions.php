<?php
include_once("../DB_Files/db.php");
include_once("header copy.php");

if (isset($_GET['id'])) {
    $question_id = $_GET['id'];

    $sql = "DELETE FROM exam_questions WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $question_id);

    if ($stmt->execute()) {
        $message = "Question deleted successfully.";
        echo "<script>
            setTimeout(function() {
                window.location.href = 'success.php?exam_category=" . urlencode($_GET['exam_category']) . "&message=" . urlencode($message) . "';
            }, 300);
        </script>";
    } else {
        echo "<p>Error deleting question: " . $stmt->error . "</p>";
    }

    $stmt->close();
} else {
    echo "<p>No question ID provided.</p>";
    exit;
}
?>
