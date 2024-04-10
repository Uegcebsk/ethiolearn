<?php
include_once("../DB_Files/db.php");
include_once("Header copy.php");

// Initialize variables
$errorMessage = "";
$successMessage = "";

if(isset($_GET['material_id'])) {
    $material_id = $_GET['material_id'];

    // Fetch material details from the database
    $sql_select_material = "SELECT * FROM materials WHERE material_id = ?";
    $stmt_select_material = $conn->prepare($sql_select_material);
    $stmt_select_material->bind_param("i", $material_id);
    $stmt_select_material->execute();
    $result_select_material = $stmt_select_material->get_result();

    if($result_select_material->num_rows > 0) {
        $material = $result_select_material->fetch_assoc();

        // Process editing of material (update database)
        if(isset($_POST['update_material'])) {
            $new_material_name = $_POST['material_name'];
            $new_material_type = $_POST['material_type'];
            $new_material_description = $_POST['material_description'];
            
            // Check if a new file is uploaded
            if ($_FILES["material_file"]["error"] === UPLOAD_ERR_OK) {
                $file = $_FILES["material_file"];
                // Use fileinfo extension to determine MIME type
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime_type = finfo_file($finfo, $file['tmp_name']);
                finfo_close($finfo);
    
                // Map MIME type to material type
                $allowedTypes = [
                    'Document' => ['application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
                    'Presentation' => ['application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation'],
                    'PDF' => 'application/pdf'
                ];
    
                // Check if the MIME type matches the selected material type
                if (!isset($allowedTypes[$new_material_type]) || !in_array($mime_type, (array) $allowedTypes[$new_material_type])) {
                    $errorMessage = "Invalid file type selected. Please choose a {$new_material_type} file.";
                } else {
                    $material_url = "material/" . $file["name"];
    
                    // Move uploaded file to the uploads directory
                    if (move_uploaded_file($file["tmp_name"], $material_url)) {
                        // Update material with file in the database
                        $sql_update_material = "UPDATE materials SET material_name = ?, material_type = ?, material_desc = ?, material_url = ? WHERE material_id = ?";
                        $stmt_update_material = $conn->prepare($sql_update_material);
                        $stmt_update_material->bind_param("ssssi", $new_material_name, $new_material_type, $new_material_description, $material_url, $material_id);
                        if ($stmt_update_material->execute()) {
                            // Redirect back to material list after successful update
                            header("Location: material_list.php");
                            exit();
                        } else {
                            // Handle update failure
                            $errorMessage = "Failed to update material.";
                        }
                    } else {
                        $errorMessage = "Failed to move the uploaded file.";
                    }
                }
            } else {
                // Update material without file in the database
                $sql_update_material = "UPDATE materials SET material_name = ?, material_type = ?, material_desc = ? WHERE material_id = ?";
                $stmt_update_material = $conn->prepare($sql_update_material);
                $stmt_update_material->bind_param("sssi", $new_material_name, $new_material_type, $new_material_description, $material_id);
                if ($stmt_update_material->execute()) {
                    // Redirect back to material list after successful update
                    header("Location: material.php");
                    exit();
                } else {
                    // Handle update failure
                    $errorMessage = "Failed to update material.";
                }
            }
        }
    } else {
        $errorMessage = "Material not found.";
    }
} else {
    $errorMessage = "Material ID not provided.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Material</title>
    <link rel="stylesheet" href="cssmaterial_add.css">
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 600px;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h2 {
    text-align: center;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

select,
input[type="file"],
textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

button {
    display: block;
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #0056b3;
}

.error {
    color: #dc3545;
    font-size: 14px;
    margin-top: 5px;
    display: <?php echo !empty($errorMessage) ? 'block' : 'none'; ?>;
}

.success {
    color: #28a745;
    font-size: 14px;
    margin-top: 5px;
    display: <?php echo !empty($successMessage) ? 'block' : 'none'; ?>;
}

    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Material</h2>
        <form action="<?php echo $_SERVER['PHP_SELF'] . "?material_id=" . $material_id; ?>" method="POST" enctype="multipart/form-data"> <!-- Update form action -->
            <label for="material_name">Material Name:</label>
            <input type="text" name="material_name" id="material_name" value="<?php echo $material['material_name']; ?>">
            
            <label for="material_type">Material Type:</label>
            <select name="material_type" id="material_type">
                <option value="Document" <?php if($material['material_type'] == 'Document') echo 'selected'; ?>>Document</option>
                <option value="Presentation" <?php if($material['material_type'] == 'Presentation') echo 'selected'; ?>>Presentation</option>
                <option value="PDF" <?php if($material['material_type'] == 'PDF') echo 'selected'; ?>>PDF</option>
                <!-- Add more options if needed -->
            </select>
            
            <label for="material_description">Material Description:</label>
            <textarea name="material_description" id="material_description" rows="5"><?php echo $material['material_desc']; ?></textarea>
            
            <label for="material_file">Choose File:</label>
            <input type="file" name="material_file" id="material_file">
            <div class="error"><?php echo $errorMessage; ?></div>
            <button type="submit" name="update_material">Update</button>
        </form>
    </div>
</body>
</html>
