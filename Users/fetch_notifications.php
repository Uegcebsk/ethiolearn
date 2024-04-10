<?php
include_once("../DB_Files/db.php");

// Retrieve the logged-in student's notifications from the database
$stu_id = $_SESSION['stu_id'];

$sql = "SELECT * FROM notifications WHERE stu_id = ? AND is_read = 0 ORDER BY notification_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $stu_id);
$stmt->execute();
$result = $stmt->get_result();

$newNotifications = [];
while ($row = $result->fetch_assoc()) {
    $newNotifications[] = $row;
}

echo json_encode($newNotifications);
?>
