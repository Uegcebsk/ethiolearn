<?php
include_once("../DB_Files/db.php");

// Validate and sanitize material_id
$material_id = isset($_GET['material_id']) ? intval($_GET['material_id']) : 0;

// Retrieve the material details from the database based on the material ID
$sql_select_material = "SELECT material_desc FROM materials WHERE material_id = ?";
$stmt_select_material = $conn->prepare($sql_select_material);
$stmt_select_material->bind_param("i", $material_id);
$stmt_select_material->execute();
$result_select_material = $stmt_select_material->get_result();

if($result_select_material->num_rows > 0) {
    $material = $result_select_material->fetch_assoc();
    echo '<p>' . htmlspecialchars($material['material_desc']) . '</p>';
} else {
    echo '<p>Material not found.</p>';
}
?>
