<?php
include_once("Header copy.php");
include_once("../DB_Files/db.php");

// Get lecturer ID from session
$lecturer_id = $_SESSION['l_id'];

// Fetch all students enrolled in courses taught by the lecturer
$sql_students = "SELECT DISTINCT s.stu_id AS user_id, s.stu_img AS profile_pic, s.stu_name AS sender_name, s.online_status
                 FROM students s
                 INNER JOIN courseorder co ON s.stu_id = co.stu_id
                 INNER JOIN course c ON co.course_id = c.course_id
                 WHERE c.lec_id = ?";

$stmt_students = $conn->prepare($sql_students);
$stmt_students->bind_param("i", $lecturer_id);
$stmt_students->execute();
$result_students = $stmt_students->get_result();
?>
<style>
    .dot-student {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }

    .dot-online {
        background-color: #4CAF50; /* Green */
    }

    .dot-offline {
        background-color: #f44336; /* Red */
    }

    .dot-message {
        margin-right: 10px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }

    .message-body {
        display: flex;
        align-items: left;
    }

    /* Adjust message body width */
    .message-body-content {
        width: calc(100% - 70px); /* Adjust this value as needed */
    }
    
</style>
<div class="container mt-5" style="padding: 6%;">
    <h3 class="text-center">Students</h3>
    <div class="row mt-9 overflow-auto">
        <?php if ($result_students->num_rows > 0) { ?>
            <?php while ($row_student = $result_students->fetch_assoc()) { ?>
                <div class="col-1">
                    <div class="media position-relative">
                        <img src="<?php echo $row_student['profile_pic']; ?>" class="mr-2 rounded-circle" alt="Profile Pic" style="width: 50px; height: 50px;">
                        <div class="media-body">
                            <div class="">
                                <h6 class="" style="font-size: 12px;"><?php echo $row_student['sender_name']; ?></h6>
                                <!-- Dot indicating online or offline status for students -->
                                <?php if ($row_student['online_status'] === 'online') { ?>
                                    <div class="dot-student dot-online"></div>
                                <?php } else { ?>
                                    <div class="dot-student dot-offline"></div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <div class="alert alert-warning" role="alert">
                No students found
            </div>
        <?php } ?>
    </div>
</div>

<div class="container mt-5">
    <h3 class="text-center">Recent Messages</h3>
    <div class="row mt-4">
        <div class="col-md-8 offset-md-2">
            <?php
            // Retrieve the most recent message from each sender (including admins)
            $sql_recent_messages = "SELECT message.*, 
                                           CASE 
                                               WHEN message.sender_type = 'student' THEN students.stu_img 
                                               WHEN message.sender_type = 'lecturer' THEN lectures.l_img 
                                               WHEN message.sender_type = 'admin' THEN '/path/to/admin/image.jpg' 
                                           END AS profile_pic,
                                           CASE 
                                               WHEN message.sender_type = 'student' THEN students.stu_name
                                               WHEN message.sender_type = 'lecturer' THEN lectures.l_name
                                               WHEN message.sender_type = 'admin' THEN 'Admin'
                                           END AS sender_name,
                                           CASE 
                                               WHEN message.sender_type = 'student' THEN students.online_status
                                               WHEN message.sender_type = 'lecturer' THEN lectures.online_status
                                               WHEN message.sender_type = 'admin' THEN 'online' -- Assume admins are always online
                                           END AS online_status
                                    FROM (
                                        SELECT MAX(sent_at) AS max_sent_at, sender_id
                                        FROM message
                                        WHERE receiver_id = ? AND receiver_type = 'lecturer'
                                        GROUP BY sender_id
                                    ) AS latest
                                    LEFT JOIN message ON latest.sender_id = message.sender_id AND latest.max_sent_at = message.sent_at
                                    LEFT JOIN students ON message.sender_id = students.stu_id AND message.sender_type = 'student'
                                    LEFT JOIN lectures ON message.sender_id = lectures.l_id AND message.sender_type = 'lecturer'
                                    ORDER BY message.sent_at DESC";

            $stmt_recent_messages = $conn->prepare($sql_recent_messages);
            $stmt_recent_messages->bind_param("i", $lecturer_id);
            $stmt_recent_messages->execute();
            $result_recent_messages = $stmt_recent_messages->get_result();

            if ($result_recent_messages->num_rows > 0) {
                while ($row_recent_message = $result_recent_messages->fetch_assoc()) {
            ?>
                    <a href="inbox_detail.php?id=<?php echo $row_recent_message['message_id']; ?>" class="text-decoration-none">
                        <div class="media mb-4">
                            <div class="message-body">
                                <img src="<?php echo $row_recent_message['profile_pic']; ?>" class="mr-3 rounded-circle" alt="Profile Pic" style="width: 50px; height: 50px;">
                                <!-- Dot indicating online or offline status for recent message senders -->
                                <?php if ($row_recent_message['online_status'] === 'online') { ?>
                                    <div class="dot dot-message dot-online"></div>
                                <?php } else { ?>
                                    <div class="dot dot-message dot-offline"></div>
                                <?php } ?>
                                <div class="bg-light rounded p-3 message-body-content">
                                    <h5 class="mt-0"><?php echo $row_recent_message['sender_name']; ?></h5>
                                    <p class="mb-1"><?php echo $row_recent_message['content']; ?></p>
                                    <small class="text-muted"><?php echo date("M j, Y, g:i a", strtotime($row_recent_message['sent_at'])); ?></small>
                                </div>
                            </div>
                        </div>
                    </a>
            <?php
                }
            } else {
            ?>
                <div class="alert alert-warning" role="alert">
                    No messages found
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php include_once("Footer.php"); ?>
<?php $conn->close(); ?>

