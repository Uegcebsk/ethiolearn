<?php
session_start();
include_once("../../../DB_Files/db.php");

// Check if the exam category is set in the session
if (isset($_SESSION["exam_category"])) {
    // Get the selected exam category
    $selected_category = $_SESSION["exam_category"];
    
    // Fetch the remaining time from the exam_category table for the selected category
    $sql = "SELECT exam_time FROM exam_category WHERE exam_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $selected_category);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $time_remaining = $row['exam_time'];
        // Display the time remaining
        echo $time_remaining;
    } else {
        // Handle the case when no exam categories are found
        echo "00:00:00"; // Assuming default time is 00:00:00
    }
} else {
    // Handle the case when exam category is not set in session
    echo "00:00:00"; // Assuming default time is 00:00:00
}
?>
