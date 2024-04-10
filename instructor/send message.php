<?php
// Include database connection
include_once("../DB_Files/db.php");

// Check if message_content and receiver_id are set and not empty
if (isset($_POST['message_content']) && !empty($_POST['message_content']) && isset($_POST['receiver_id'])) {
    // Sanitize input to prevent SQL injection and XSS attacks
    $messageContent = mysqli_real_escape_string($conn, $_POST['message_content']);
    $receiverId = mysqli_real_escape_string($conn, $_POST['receiver_id']);

    // Get sender_id from session (assuming it's stored in session)
    $senderId = isset($_SESSION['l_id']) ? $_SESSION['l_id'] : $_SESSION['stu_id'];

    // Insert message into the database
    $sql = "INSERT INTO messages (sender_id, receiver_id, message_content) VALUES ('$senderId', '$receiverId', '$messageContent')";
    $result = $conn->query($sql);

    if ($result) {
        // Message sent successfully
        echo 'Message sent successfully.';
    } else {
        // Error occurred while sending
