<?php
include_once("../DB_Files/db.php");

if (isset($_POST['id'])) {
    $questionId = $_POST['id'];

    $stmt = $conn->prepare("DELETE FROM questions WHERE Q_id = ?");
    $stmt->bind_param("i", $questionId);

    if ($stmt->execute()) {
        echo "Question deleted successfully.";
    } else {
        echo "Error deleting question: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
