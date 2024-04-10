<?php
// Include database connection
include_once("../DB_Files/db.php");

// Fetch messages from the database
$sql = "SELECT * FROM messages ORDER BY timestamp DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output messages
    while ($row = $result->fetch_assoc()) {
        echo '<div class="message">';
        echo '<strong>' . $row['sender_id'] . ':</strong> ' . $row['message_content'];
        echo '</div>';
    }
} else {
    echo '<div class="no-messages">No messages found.</div>';
}
?>
