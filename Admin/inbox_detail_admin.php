<?php
include_once("../DB_Files/db.php");
include_once("Header.php");

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $message_id = $_GET['id'];

    // Retrieve the main message
    $sql_main_message = "SELECT message.*, 
                                CASE WHEN message.sender_type = 'student' THEN students.stu_img 
                                     WHEN message.sender_type = 'lecturer' THEN lectures.l_img 
                                END AS profile_pic,
                                CASE WHEN message.sender_type = 'student' THEN students.stu_name
                                     WHEN message.sender_type = 'lecturer' THEN lectures.l_name
                                END AS sender_name,
                                CASE WHEN message.sender_type = 'student' THEN students.online_status
                                     WHEN message.sender_type = 'lecturer' THEN lectures.online_status
                                END AS online_status
                         FROM message
                         LEFT JOIN students ON message.sender_id = students.stu_id AND message.sender_type = 'student'
                         LEFT JOIN lectures ON message.sender_id = lectures.l_id AND message.sender_type = 'lecturer'
                         WHERE message.message_id = ?";

    $stmt_main_message = $conn->prepare($sql_main_message);
    $stmt_main_message->bind_param("i", $message_id);
    $stmt_main_message->execute();
    $result_main_message = $stmt_main_message->get_result();

    if ($result_main_message->num_rows > 0) {
        $main_message = $result_main_message->fetch_assoc();

        // Retrieve all messages between the sender and receiver
        $sql_all_messages = "SELECT message.*, 
                                    CASE WHEN message.sender_type = 'student' THEN students.stu_img 
                                         WHEN message.sender_type = 'lecturer' THEN lectures.l_img 
                                    END AS profile_pic,
                                    CASE WHEN message.sender_type = 'student' THEN students.stu_name
                                         WHEN message.sender_type = 'lecturer' THEN lectures.l_name
                                    END AS sender_name,
                                    CASE WHEN message.sender_type = 'student' THEN students.online_status
                                         WHEN message.sender_type = 'lecturer' THEN lectures.online_status
                                    END AS online_status
                             FROM message
                             LEFT JOIN students ON message.sender_id = students.stu_id AND message.sender_type = 'student'
                             LEFT JOIN lectures ON message.sender_id = lectures.l_id AND message.sender_type = 'lecturer'
                             WHERE (message.sender_id = ? AND message.receiver_id = ?) OR (message.sender_id = ? AND message.receiver_id = ?)
                             ORDER BY message.sent_at ASC";

        $stmt_all_messages = $conn->prepare($sql_all_messages);
        $stmt_all_messages->bind_param("iiii", $main_message['sender_id'], $main_message['receiver_id'], $main_message['receiver_id'], $main_message['sender_id']);
        $stmt_all_messages->execute();
        $result_all_messages = $stmt_all_messages->get_result();

        // If the main message is not read, mark it as read
        if ($main_message['is_read'] == 0) {
            $sql_update = "UPDATE message SET is_read = 1 WHERE message_id = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("i", $message_id);
            $stmt_update->execute();
        }

?>

<div class="container mt-5" style="padding: 7%;">
    <div class="card mb-4">
        <div class="card-header bg-light">
            <div class="media">
                <img src="<?php echo $main_message['profile_pic']; ?>" class="mr-3 rounded-circle" alt="Profile Pic" style="width: 40px; height: 40px;">
                <!-- Dot indicating online or offline status -->
                <div class="dot <?php echo ($main_message['online_status'] === 'online') ? 'dot-online' : 'dot-offline'; ?>"></div>
                <div class="media-body">
                    <h5 class="mt-0"><?php echo $main_message['sender_name']; ?></h5>
                    <p><?php echo $main_message['content']; ?></p>
                </div>
                <div class="text-muted"><?php echo date("M j, Y, g:i a", strtotime($main_message['sent_at'])); ?></div>
            </div>
        </div>
        <div class="card-body">
            <?php while ($message = $result_all_messages->fetch_assoc()) { ?>
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
            <form action="send_reply_admin.php" method="POST">
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
        margin-left: auto;
        margin-right: 0;
    }

    .message.sent {
        background-color: orange;
        color: white;
        border-radius: 20px;
        padding: 8px;
        margin-left: 0;
        margin-right: auto;
    }

    .message-content {
        display: flex;
        justify-content: space-between;
    }

    .message-content p {
        margin-bottom: 0;
    }

    .message-content small {
        text-align: <?php echo ($main_message['sender_type'] == 'student') ? 'left' : 'right'; ?>;
    }

    .dot {
        position: absolute;
        bottom: 0;
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
        header("Location: inbox_admin.php");
        exit();
    }
} else {
    header("Location: inbox_admin.php");
    exit();
}
?>
