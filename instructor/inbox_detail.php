<?php
include_once("../DB_Files/db.php");

// Check if message ID is set and not empty
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $message_id = $_GET['id'];

    // Retrieve the main message
    $sql = "SELECT message.*, 
                   CASE WHEN message.sender_type = 'student' THEN students.stu_img 
                        WHEN message.sender_type = 'lecturer' THEN lectures.l_img 
                   END AS profile_pic,
                   CASE WHEN message.sender_type = 'student' THEN students.stu_name
                        WHEN message.sender_type = 'lecturer' THEN lectures.l_name
                   END AS sender_name,
                   CASE WHEN message.sender_type = 'student' THEN students.online_status
                   END AS online_status_student
            FROM message
            LEFT JOIN students ON message.sender_id = students.stu_id AND message.sender_type = 'student'
            LEFT JOIN lectures ON message.sender_id = lectures.l_id AND message.sender_type = 'lecturer'
            WHERE message.message_id = ?"; 

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $message_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if message exists
    if ($result->num_rows > 0) {
        // Fetch the main message
        $main_message = $result->fetch_assoc();

        // If the message is not read by the receiver (admin and student), mark it as read
       // If the main message is not read, mark it as read
       if ($main_message['is_read'] == 0) {
        $sql_update = "UPDATE message SET is_read = 1 WHERE message_id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("i", $message_id);
        $stmt_update->execute();
    }

        // Retrieve all messages between the sender and receiver
        $sql = "SELECT message.*, 
                       CASE WHEN message.sender_type = 'student' THEN students.stu_img 
                            WHEN message.sender_type = 'lecturer' THEN lectures.l_img 
                       END AS profile_pic,
                       CASE WHEN message.sender_type = 'student' THEN students.stu_name
                            WHEN message.sender_type = 'lecturer' THEN lectures.l_name
                       END AS sender_name,
                       CASE WHEN message.sender_type = 'student' THEN students.online_status
                       END AS online_status_student
                FROM message
                LEFT JOIN students ON message.sender_id = students.stu_id AND message.sender_type = 'student'
                LEFT JOIN lectures ON message.sender_id = lectures.l_id AND message.sender_type = 'lecturer'
                WHERE (message.sender_id = ? AND message.receiver_id = ?) OR (message.sender_id = ? AND message.receiver_id = ?)
                ORDER BY message.sent_at ASC"; 

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiii", $main_message['sender_id'], $main_message['receiver_id'], $main_message['receiver_id'], $main_message['sender_id']);
        $stmt->execute();
        $all_messages_result = $stmt->get_result();

?>

<?php include_once("Header copy.php"); ?>

<div class="container mt-5" style="padding:7%;">
    <div class="card mb-4">
        <div class="card-header bg-light">
            <div class="media">
                <a href="editstudent.php?id=<?php echo $main_message['sender_id']; ?>" class="text-decoration-none position-relative">
                    <img src="<?php echo $main_message['profile_pic']; ?>" class="mr-3 rounded-circle" alt="Profile Pic" style="width: 40px; height: 40px;">
                    <!-- Dot indicating online or offline status for students -->
                    <?php if ($main_message['online_status_student'] === 'online') { ?>
                        <div class="dot dot-student dot-online"></div>
                    <?php } else { ?>
                        <div class="dot dot-student dot-offline"></div>
                    <?php } ?>
                </a>
                <div class="media-body">
                    <h5 class="mt-0"><?php echo $main_message['sender_name']; ?></h5>
                    <p><?php echo $main_message['content']; ?></p>
                </div>
                <div class="text-muted"><?php echo date("M j, Y, g:i a", strtotime($main_message['sent_at'])); ?></div>
            </div>
        </div>
        <div class="card-body">
            <?php while ($message = $all_messages_result->fetch_assoc()) { ?>
                <div class="message <?php echo ($message['sender_type'] == $main_message['sender_type']) ? 'sent' : 'received'; ?>">
                    <div class="message-content">
                        <p><?php echo $message['content']; ?></p>
                        <small class="text-muted"><?php echo date("M j, Y, g:i a", strtotime($message['sent_at'])); ?></small>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form action="<?php echo ($main_message['sender_type'] == 'student') ? 'send_reply.php' : 'send_reply.php'; ?>" method="POST">
                <input type="hidden" name="message_id" value="<?php echo $message_id; ?>">
                <div class="form-group">
                    <label for="reply_content">Your Reply</label>
                    <textarea class="form-control" id="reply_content" name="reply_content" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Send Reply</button>
            </form>
        </div>
    </div>
</div>


<style>
    .message {
        max-width: 60%;
        margin-bottom: 7px;
    }

    .message.received {
        background-color: #e7e7e7;
        border-radius: 10px;
        padding: 8px;
        margin-left: auto; /* Align received messages to the left */
        margin-right: 0;
    }

    .message.sent {
        background-color: orange;
        color: white;
        border-radius: 20px;
        padding: 8px;
        margin-left: 0;
        margin-right: auto; /* Align sent messages to the right */
    }

    .message-content {
        display: flex;
        justify-content: space-between;
    }

    .message-content p {
        margin-bottom: 0;
    }

    .message-content small {
        text-align: <?php echo ($main_message['sender_type'] == 'student') ? 'left' : 'right'; ?>; /* Align timestamps based on sender type */
    }

    .dot-student {
        position: absolute;
        bottom: 0.00000000000;
        right: 0;
        width: 9px;
        height: 9px;
        border-radius: 50%;
    }

    .dot-online {
        background-color: #4CAF50; /* Green */
    }

    .dot-offline {
        background-color: #f44336; /* Red */
    }
</style>

<?php include_once("Footer.php"); ?>

<?php
    } else {
        // Redirect back to inbox page if message does not exist
        header("Location: inbox.php");
        exit();
    }
} else {
    // Redirect back to inbox page if message ID is not provided
    header("Location: inbox.php");
    exit();
}
?>
