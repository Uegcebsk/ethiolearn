<?php
include_once("../DB_Files/db.php");
include_once("header copy.php");

// Redirect to login page if user is not logged in
if (!isset($_SESSION['stu_id']) && !isset($_SESSION['l_id'])) {
    header('Location: login.php');
    exit();
}

// Function to send message
function sendMessage($sender_id, $receiver_id, $message_content) {
    global $conn;
    $sender_id = mysqli_real_escape_string($conn, $sender_id);
    $receiver_id = mysqli_real_escape_string($conn, $receiver_id);
    $message_content = mysqli_real_escape_string($conn, $message_content);
    
    $sql = "INSERT INTO messages (sender_id, receiver_id, message_content) VALUES ('$sender_id', '$receiver_id', '$message_content')";
    $result = $conn->query($sql);
    return $result;
}

// Function to get messages
function getMessages($user_id) {
    global $conn;
    $user_id = mysqli_real_escape_string($conn, $user_id);
    $sql = "SELECT * FROM messages WHERE sender_id = $user_id OR receiver_id = $user_id ORDER BY timestamp DESC";
    $result = $conn->query($sql);
    $messages = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $messages[] = $row;
        }
    }
    return $messages;
}

// Process message sending
if (isset($_POST['send_message'])) {
    $sender_id = $_SESSION['l_id'];
    $receiver_id = $_POST['receiver_id'];
    $message_content = $_POST['message_content'];

    $result = sendMessage($sender_id, $receiver_id, $message_content);
    if ($result) {
        // Message sent successfully
    } else {
        // Error occurred while sending message
    }
}

// Get messages for the logged-in instructor
$messages = getMessages($_SESSION['l_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Application</title>
    <link rel="stylesheet" href="styles.css">
    <style>
          <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

.chat-container {
    max-width: 600px;
    margin: 50px auto;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.messages-container {
    height: 300px;
    overflow-y: scroll;
    padding: 10px;
}

.input-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
    border-top: 1px solid #ccc;
}

#message-input {
    flex: 1;
    height: 50px;
    padding: 5px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

#send-button {
    height: 50px;
    padding: 0 20px;
    border: none;
    border-radius: 5px;
    background-color: #007bff;
    color: #fff;
    cursor: pointer;
}

    </style>
    </style>
</head>
<body>
    <div class="chat-container">
        <div class="messages-container" id="messages-container">
            <?php 
            // Display messages
            foreach ($messages as $message) {
                echo '<div class="message">';
                echo '<strong>' . $message['sender_id'] . ':</strong> ' . $message['message_content'];
                echo '</div>';
            }
            ?>
        </div>
        <form id="message-form">
            <textarea id="message-input" placeholder="Type your message..."></textarea>
            <input type="hidden" id="receiver-id" value="2"> <!-- Example receiver ID, replace with your logic -->
            <button type="submit" id="send-button">Send</button>
        </form>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="message_script.js"></script>
</body>
</html>
