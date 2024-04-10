<?php
include_once("../DB_Files/db.php");

// Check if the request method is POST (for updating progress) or GET (for retrieving progress)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Update video progress
    $data = json_decode(file_get_contents("php://input"), true);
    if (isset($data['lesson_id']) && isset($data['progress'])) {
        // Update video progress in the database
        $lesson_id = $data['lesson_id'];
        $progress = $data['progress'];

        // Implement database update code here
         $sql = "UPDATE lesson SET video_progress = ? WHERE lesson_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $progress, $lesson_id);
        /$stmt->execute();
        $stmt->close();
        
        // Send a success response
        http_response_code(200);
        echo json_encode(array("message" => "Video progress updated successfully."));
    } else {
        // Send a bad request response if required data is missing
        http_response_code(400);
        echo json_encode(array("message" => "Missing required data."));
    }
} elseif ($_SERVER["REQUEST_METHOD"] === "GET") {
    // Retrieve video progress
    if (isset($_GET['lesson_id'])) {
        // Retrieve video progress from the database
        $lesson_id = $_GET['lesson_id'];

        // Implement database retrieval code here
        $sql = "SELECT video_progress FROM lesson WHERE lesson_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $lesson_id);
         $stmt->execute();
        $result = $stmt->get_result();
         $row = $result->fetch_assoc();
        $stmt->close();

        // Simulate retrieval (replace with actual retrieval from database)
        $progress = rand(0, 100); // Simulating progress as a random number between 0 and 100

        // Send the retrieved progress as JSON response
        http_response_code(200);
        echo json_encode(array("progress" => $progress));
    } else {
        // Send a bad request response if lesson_id is missing
        http_response_code(400);
        echo json_encode(array("message" => "Missing lesson_id."));
    }
} else {
    // Send a method not allowed response if the request method is neither POST nor GET
    http_response_code(405);
    echo json_encode(array("message" => "Method not allowed."));
}
?>
