<?php
include_once("../DB_Files/db.php");

// Validate and sanitize material_id
$material_id = isset($_GET['material_id']) ? intval($_GET['material_id']) : 0;

// Retrieve the material details from the database based on the material ID
$sql_select_material = "SELECT * FROM materials WHERE material_id = ?";
$stmt_select_material = $conn->prepare($sql_select_material);
$stmt_select_material->bind_param("i", $material_id);
$stmt_select_material->execute();
$result_select_material = $stmt_select_material->get_result();

if($result_select_material->num_rows > 0) {
    $material = $result_select_material->fetch_assoc();

    // File path
    $file_path = $material['material_url'];

    // Check if file exists
    if (file_exists($file_path)) {
        // Set headers for download
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
        header('Content-Length: ' . filesize($file_path));

        // Clear system output buffer
        flush();

        // Read the file and send it to the output buffer
        readfile($file_path);
        exit;
    } else {
        // File not found
        echo 'File not found at: ' . $file_path;
    }
} else {
    // Material not found
    echo 'Material not found.';
}
?>
