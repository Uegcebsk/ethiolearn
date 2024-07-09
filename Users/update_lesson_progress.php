<?php
include_once("../DB_Files/db.php");

// Retrieve data sent via POST
$data = json_decode(file_get_contents("php://input"));

if (!empty($data->lesson_id) && !empty($data->course_id) && !empty($data->student_id) && isset($data->progress) && isset($data->completed)) {
    $lesson_id = $data->lesson_id;
    $course_id = $data->course_id;
    $student_id = $data->student_id;
    $progress = $data->progress;
    $completed = $data->completed;

    // Check if there is already a progress record for this student, lesson, and course
    $check_existing_query = "SELECT progress, completed FROM lesson_progress WHERE lesson_id = ? AND course_id = ? AND student_id = ?";
    $stmt_check_existing = $conn->prepare($check_existing_query);
    $stmt_check_existing->bind_param("iii", $lesson_id, $course_id, $student_id);
    $stmt_check_existing->execute();
    $result_check_existing = $stmt_check_existing->get_result();

    if ($result_check_existing->num_rows > 0) {
        // There is an existing progress record
        $existing_data = $result_check_existing->fetch_assoc();
        $prev_progress = $existing_data['progress'];
        $prev_completed = $existing_data['completed'];

        // Check if the lesson is not already completed and the current progress is greater than the previous progress
        if ($completed == 0 && $progress > $prev_progress) {
            // Update progress only if the lesson is not already completed and the current progress is greater
            $update_query = "UPDATE lesson_progress SET progress = ? WHERE lesson_id = ? AND course_id = ? AND student_id = ?";
            $stmt_update = $conn->prepare($update_query);
            $stmt_update->bind_param("diii", $progress, $lesson_id, $course_id, $student_id);
            if ($stmt_update->execute()) {
                echo json_encode(array("message" => "Progress updated successfully"));
            } else {
                echo json_encode(array("error" => "Failed to update progress"));
            }
            $stmt_update->close();
        } else {
            // Progress doesn't need to be updated
            echo json_encode(array("message" => "No need to update progress"));
        }
    } else {
        // No existing progress record found, insert new record
        $insert_query = "INSERT INTO lesson_progress (lesson_id, course_id, student_id, progress, completed) VALUES (?, ?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($insert_query);
        $stmt_insert->bind_param("iiidi", $lesson_id, $course_id, $student_id, $progress, $completed);
        if ($stmt_insert->execute()) {
            echo json_encode(array("message" => "Progress inserted successfully"));
        } else {
            echo json_encode(array("error" => "Failed to insert progress"));
        }
        $stmt_insert->close();
    }

    $stmt_check_existing->close();
} else {
    echo json_encode(array("error" => "Incomplete data provided"));
}
?>
