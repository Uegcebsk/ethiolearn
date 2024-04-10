<?php
session_start();
include_once("../DB_Files/db.php");

// Check if the user is logged in
if (!isset($_SESSION['stu_id'])) {
    echo json_encode(array("error" => "User not logged in"));
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['notification_id'])) {
    $notification_id = $_POST['notification_id'];
    $stu_id = $_SESSION['stu_id'];

    // Update the notification to mark it as read
    $sql = "UPDATE notifications SET is_read = 1 WHERE notification_id = ? AND stu_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $notification_id, $stu_id);

    if ($stmt->execute()) {
        // Notification marked as read successfully
        echo json_encode(array("success" => "Notification marked as read"));
        
        // Update session variable with new notification count
        $_SESSION['notification_count'] = count(fetchNewNotifications($conn));
    } else {
        // Error occurred while updating the notification
        echo json_encode(array("error" => "Failed to mark notification as read"));
    }

    $stmt->close();
} else {
    // Invalid request
    echo json_encode(array("error" => "Invalid request"));
}
?>
