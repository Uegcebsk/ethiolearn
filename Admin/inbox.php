<?php
include_once("Header.php");
include_once("../DB_Files/db.php");

// Fetch all students
$sql_students = "SELECT stu_id AS user_id, stu_img AS profile_pic, stu_name AS sender_name, online_status
                 FROM students";

$result_students = $conn->query($sql_students);

// Fetch all lecturers
$sql_lecturers = "SELECT l_id AS user_id, l_img AS profile_pic, l_name AS sender_name, online_status
                  FROM lectures";

$result_lecturers = $conn->query($sql_lecturers);

// Retrieve recent messages sent to admin
$sql_recent_admin_messages = "SELECT message.*, 
                                    CASE WHEN message.sender_type = 'student' THEN students.stu_img 
                                         WHEN message.sender_type = 'lecturer' THEN lectures.l_img 
                                    END AS profile_pic,
                                    CASE WHEN message.sender_type = 'student' THEN students.stu_name
                                         WHEN message.sender_type = 'lecturer' THEN lectures.l_name
                                    END AS sender_name,
                                    CASE WHEN message.sender_type = 'student' THEN students.online_status
                                         WHEN message.sender_type = 'lecturer' THEN lectures.online_status
                                    END AS online_status
                              FROM (
                                  SELECT MAX(message_id) AS message_id, sender_id
                                  FROM message
                                  WHERE receiver_type = 'admin'
                                  GROUP BY sender_id
                              ) AS recent_messages
                              LEFT JOIN message ON recent_messages.message_id = message.message_id
                              LEFT JOIN students ON message.sender_id = students.stu_id AND message.sender_type = 'student'
                              LEFT JOIN lectures ON message.sender_id = lectures.l_id AND message.sender_type = 'lecturer'
                              ORDER BY message.sent_at DESC
                              LIMIT 5"; // Limit to 5 recent messages

$result_recent_admin_messages = $conn->query($sql_recent_admin_messages);
?>

<style>
    .dot {
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
    <div class="row mt-4 overflow-auto">
        <?php if ($result_students->num_rows > 0) { ?>
            <?php while ($row_student = $result_students->fetch_assoc()) { ?>
                <div class="col-1">
                    <div class="media position-relative">
                        <a href="messagee.php?receiver_id=<?php echo $row_student['user_id']; ?>&receiver_type=student" class="text-decoration-none">
                            <img src="<?php echo $row_student['profile_pic']; ?>" class="mr-2 rounded-circle" alt="Profile Pic" style="width: 50px; height: 50px;">
                            <div class="media-body">
                                <div class="">
                                    <h6 class="" style="font-size: 12px;"><?php echo $row_student['sender_name']; ?></h6>
                                    <div class="dot <?php echo ($row_student['online_status'] === 'online') ? 'dot-online' : 'dot-offline'; ?>"></div>
                                </div>
                            </div>
                        </a>
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

<div class="container mt-5" style="padding-left: 6%;">
    <h3 class="text-center">Lecturers</h3>
    <div class="row mt-4 overflow-auto">
        <?php if ($result_lecturers->num_rows > 0) { ?>
            <?php while ($row_lecturer = $result_lecturers->fetch_assoc()) { ?>
                <div class="col-1">
                    <div class="media position-relative">
                        <a href="messagee.php?receiver_id=<?php echo $row_lecturer['user_id']; ?>&receiver_type=lecturer" class="text-decoration-none">
                            <img src="<?php echo $row_lecturer['profile_pic']; ?>" class="mr-2 rounded-circle" alt="Profile Pic" style="width: 50px; height: 50px;">
                            <div class="media-body">
                                <div class="">
                                    <h6 class="" style="font-size: 12px;"><?php echo $row_lecturer['sender_name']; ?></h6>
                                    <div class="dot <?php echo ($row_lecturer['online_status'] === 'online') ? 'dot-online' : 'dot-offline'; ?>"></div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <div class="alert alert-warning" role="alert">
                No lecturers found
            </div>
        <?php } ?>
    </div>
</div>

<div class="container mt-5">
    <h3 class="text-center">Recent Messages to Admin</h3>
    <div class="row mt-4">
        <div class="col-md-8 offset-md-2">
            <?php if ($result_recent_admin_messages->num_rows > 0) { ?>
                <?php while ($row_recent_admin_message = $result_recent_admin_messages->fetch_assoc()) { ?>
                    <a href="inbox_detail_admin.php?id=<?php echo $row_recent_admin_message['message_id']; ?>" class="text-decoration-none">
                        <div class="media mb-4">
                            <div class="message-body">
                                <img src="<?php echo $row_recent_admin_message['profile_pic']; ?>" class="mr-3 rounded-circle" alt="Profile Pic" style="width: 50px; height: 50px;">
                                <div class="bg-light rounded p-3 message-body-content">
                                    <h5 class="mt-0"><?php echo $row_recent_admin_message['sender_name']; ?></h5>
                                    <p class="mb-1"><?php echo $row_recent_admin_message['content']; ?></p>
                                    <small class="text-muted"><?php echo date("M j, Y, g:i a", strtotime($row_recent_admin_message['sent_at'])); ?></small>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php } ?>
            <?php } else { ?>
                <div class="alert alert-warning" role="alert">
                    No recent messages found
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php include_once("Footer.php"); ?>
