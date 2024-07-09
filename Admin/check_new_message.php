<?php
include_once("../DB_Files/db.php");

// Check if lecturer ID is set in session
if (isset($_SESSION['id'])) {
    // Get lecturer ID from session
    $admin_id = $_SESSION['id'];

    // Query to count new messages
    $sql = "SELECT COUNT(*) AS new_messages 
            FROM message 
            WHERE receiver_id = ? AND receiver_type = 'admin' AND is_read = 0";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the count of new messages
    $row = $result->fetch_assoc();
    $new_messages_count = $row['new_messages'];

 
} else {
    echo "0"; // No new messages if lecturer ID is not set in session
}
?>
