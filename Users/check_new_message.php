<?php

// Check if student ID is set in session
if (isset($_SESSION['stu_id'])) {
    include_once("../DB_Files/db.php");

    // Get student ID from session
    $student_id = $_SESSION['stu_id'];

    // Query to count new messages
    $sql = "SELECT COUNT(*) AS new_messages 
            FROM message 
            WHERE receiver_id = ? AND receiver_type = 'student' AND is_read = 0";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the count of new messages
    $row = $result->fetch_assoc();
    $new_messages_count = $row['new_messages'];

    echo $new_messages_count;
} else {
    
}
?>
