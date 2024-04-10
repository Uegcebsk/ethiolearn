<?php
// update_video_progress.php

// Assuming you have a database connection established
// Include database connection code here if not already included

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get data from the request body
    $data = json_decode(file_get_contents("php://input"), true);

    // Check if required data is present
    if (isset($data['lesson_id']) && isset($data['progress'])) {
        // Extract lesson ID and progress from the request data
        $lesson_id = $data['lesson_id'];
        $progress = $data['progress'];

        // Update the video progress in the database
        $sql = "UPDATE lesson SET video_progress = ? WHERE lesson_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $progress, $lesson_id);
        $stmt->execute();
        $stmt->close();

        // Send a success response
        http_response_code(200);
        echo json_encode(array("message" => "Video progress updated successfully."));
    } else {
        // Send a bad request response if required data is missing
        http_response_code(400);
        echo json_encode(array("message" => "Missing required data."));
    }
} else {
    // Send a method not allowed response if the request method is not POST
    http_response_code(405);
    echo json_encode(array("message" => "Method not allowed."));
}
?>
