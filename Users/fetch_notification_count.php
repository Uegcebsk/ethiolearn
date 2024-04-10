<?php
include_once("../DB_Files/db.php");

// Check if the user is logged in
if (!isset($_SESSION['stu_id'])) {
    // Redirect to the login page if not logged in
    header("Location: Login&SignIn.php");
    exit();
}

// Function to fetch new notifications count
function fetchNewNotificationsCount($conn) {
    if (!isset($_SESSION['stu_id'])) {
        return 0; // Return 0 if user is not logged in
    }

    $stu_id = $_SESSION['stu_id'];

    $sql = "SELECT COUNT(*) as count FROM notifications WHERE stu_id = ? AND is_read = 0";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $stu_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $count = $row['count'];

        $stmt->close();

        return $count;
    }

    return 0; // Return 0 if there's an error in database operation
}

// Call fetchNewNotificationsCount() with the $conn variable
$notificationCount = fetchNewNotificationsCount($conn);

// Output the notification count
echo $notificationCount;
?>
