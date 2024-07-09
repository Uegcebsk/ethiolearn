<?php
include_once("../DB_Files/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form fields are set and not empty
    if (isset($_POST['message_id']) && isset($_POST['reply_content']) && !empty($_POST['message_id']) && !empty($_POST['reply_content'])) {
        $message_id = $_POST['message_id'];
        $reply_content = $_POST['reply_content'];

        // Insert the reply into the database
        $sql = "INSERT INTO message (sender_id, sender_type, receiver_id, receiver_type, subject, content, is_read, parent_id)
                SELECT ?, 'admin', sender_id, sender_type, CONCAT('Re: ', subject), ?, 0, ?
                FROM message
                WHERE message_id = ?";
        $stmt = $conn->prepare($sql);
        // Admin's ID is used as the sender_id
        $admin_id = 1; // Change this to the actual admin's ID
        $stmt->bind_param("issi", $admin_id, $reply_content, $message_id, $message_id);
        
        if ($stmt->execute()) {
            // Redirect back to the message details page with a success message
            header("Location: inbox_detail_admin.php?id=" . $message_id . "&success=1");
            exit();
        } else {
            // Redirect back to the message details page with an error message
            header("Location: inbox_detail_admin.php?id=" . $message_id . "&error=1");
            exit();
        }
    } else {
        // Redirect back to the message details page with an error message if form fields are not set or empty
        header("Location: inbox_detail_admin.php?id=" . $message_id . "&error=1");
        exit();
    }
} else {
    // Redirect back to the message details page with an error message if not a POST request
    header("Location: inbox_detail_admin.php?id=" . $message_id . "&error=1");
    exit();
}
?>
