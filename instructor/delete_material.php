<?php
include_once("../DB_Files/db.php");

if(isset($_GET['material_id'])) {
    $material_id = $_GET['material_id'];

    // Delete material from the database
    $sql_delete_material = "DELETE FROM materials WHERE material_id = ?";
    $stmt_delete_material = $conn->prepare($sql_delete_material);
    $stmt_delete_material->bind_param("i", $material_id);
    if($stmt_delete_material->execute()) {
        // Redirect back to material list after successful deletion
        header("Location: material.php");
        exit();
    } else {
        // Handle deletion failure
        echo "Failed to delete material.";
    }
} else {
    echo "Material ID not provided.";
}
?>
