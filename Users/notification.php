<?php
include_once("ProfileHeader.php");
include_once("../DB_Files/db.php");

// Check if the user is logged in
if (!isset($_SESSION['stu_id'])) {
    // Redirect to the login page if not logged in
    header("Location: Login&SignIn.php");
    exit();
}

// Function to fetch new notifications
function fetchNewNotifications($conn) {
    if (!isset($_SESSION['stu_id'])) {
        return [];
    }

    $stu_id = $_SESSION['stu_id'];
    $newNotifications = [];

    $sql = "SELECT * FROM notifications WHERE stu_id = ? AND is_read = 0 ORDER BY notification_date DESC";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $stu_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Count the number of unread notifications
        $unreadCount = $result->num_rows;

        // Set the notification count in session
        $_SESSION['notification_count'] = $unreadCount;

        while ($row = $result->fetch_assoc()) {
            $newNotifications[] = $row;
        }

        $stmt->close();
    }

    return $newNotifications;
}

// Call fetchNewNotifications() with the $conn variable
fetchNewNotifications($conn);

// Retrieve the logged-in student's notifications from the database
$notifications = [];
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 10; // Number of notifications per page
$offset = ($page - 1) * $limit;

$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM notifications WHERE stu_id = ? ORDER BY notification_date DESC LIMIT ?, ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("iii", $_SESSION['stu_id'], $offset, $limit);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $notifications[] = $row;
    }

    $stmt->close();
}

// Total number of notifications (for pagination)
$total_rows_sql = "SELECT FOUND_ROWS() as total";
$total_rows_result = $conn->query($total_rows_sql);
$total_rows = $total_rows_result->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $limit);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Notifications</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="CSS/notification.css">
</head>
<body>
<div class="container">
    <h2>Your Notifications</h2>
    <!-- Icon with badge -->
    <div class="notification-icon">
        <img src="Img/notification.png" alt="Notifications">
        <!-- Badge for displaying notification count -->
        <span class="badge"><?php echo $_SESSION['notification_count']; ?></span>
    </div>
    <div class="notification-container">
        <?php
        if (!empty($notifications)) {
            foreach ($notifications as $notification) {
                $notificationId = $notification['notification_id'];
                $notificationMessage = $notification['notification_message'];
                $notificationDate = date("M d, Y H:i:s", strtotime($notification['notification_date']));
                $isReadClass = $notification['is_read'] ? 'read' : 'unread';
                $disabled = $notification['is_read'] ? 'disabled' : ''; // Disable button for read notifications
        ?>
                <div class="notification <?php echo $isReadClass; ?>" data-notification-id="<?php echo $notificationId; ?>">
                    <div class="notification-content">
                        <h5><?php echo $notificationMessage; ?></h5>
                        <p class="notification-date"><?php echo $notificationDate; ?></p>
                    </div>
                    <div class="notification-actions">
                        <button class="btn btn-mark-read" <?php echo $disabled; ?> data-notification-id="<?php echo $notificationId; ?>">Mark as Read</button>
                    </div>
                </div>
        <?php
            }
        } else {
            // No notifications found
            echo '<p>No notifications found.</p>';
        }
        ?>
    </div>
    <!-- Pagination -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <?php
            for ($i = 1; $i <= $total_pages; $i++) {
                $activeClass = ($i == $page) ? 'active' : '';
                echo '<li class="page-item ' . $activeClass . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
            }
            ?>
        </ul>
    </nav>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    // AJAX for marking notification as read
    $(document).on("click", ".btn-mark-read", function() {
        var notification = $(this).closest(".notification");
        var notificationId = notification.data("notification-id");

        $.ajax({
            url: "mark_notification.php",
            type: "POST",
            data: { notification_id: notificationId },
            success: function(response) {
                notification.removeClass("unread").addClass("read");
                $(".btn-mark-read", notification).prop("disabled", true); // Disable button after marking as read
                // Update notification count in badge
                var unreadCount = $('.notification.unread').length - 1; // Decrease count by 1
                if (unreadCount < 0) {
                    unreadCount = 0; // Set count to 0 if it goes negative
                }
                $('.notification-icon .badge').text(unreadCount);
                // Update session variable with new count
                <?php $_SESSION['notification_count'] = '<script>document.write(unreadCount)</script>'; ?>;
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
});

</script>
</body>
</html>
