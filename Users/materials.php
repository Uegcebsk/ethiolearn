<?php
session_start();
include_once("ProfileHeader.php");
include_once("../DB_Files/db.php");
// Check if the "View Description" button is clicked
if(isset($_POST['view_description'])) {
    // Retrieve the material ID from the form
    $material_id = $_POST['material_id'];
    
    // Retrieve the material details from the database based on the material ID
    $sql_select_material = "SELECT * FROM materials WHERE material_id = ?";
    $stmt_select_material = $conn->prepare($sql_select_material);
    $stmt_select_material->bind_param("i", $material_id);
    $stmt_select_material->execute();
    $result_select_material = $stmt_select_material->get_result();
    
    if($result_select_material->num_rows > 0) {
        $material = $result_select_material->fetch_assoc();
        // Display the material description
        echo '<div class="material-description">';
        echo '<h3>Material Description</h3>';
        echo '<p>' . $material['material_desc'] . '</p>';
        echo '</div>';
    } else {
        echo '<p>Material not found.</p>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materials</title>
    <link rel="stylesheet" href="CSS/watchcourse.css">
    <style>
        /* Additional CSS styles for responsiveness and appearance */
        .material-description {
            padding: 50px;
            background-color: #f8f9fa;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 20px;
        }
        .material-description h3 {
            color: #333;
            font-size: 20px;
            margin-bottom: 10px;
        }
        .material-description p {
            color: #666;
            font-size: 16px;
            line-height: 1.6;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
    <div class="col-sm-9 mt-5 m-auto">
        <p class="bg-dark text-white p-2">List of Materials</p>
        <?php
        if (isset($_GET['course_id'])) {
            $course_id = $_GET['course_id'];
            $sql = "SELECT * FROM materials WHERE course_id='$course_id'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                ?>
                <table class="table">
                    <thead>
                    <tr>
                        <th class="text-dark fw-bolder" scope="col">Material Name</th>
                        <th class="text-dark fw-bolder" scope="col">Material Type</th>
                        <th class="text-dark fw-bolder" scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td class="text-dark fw-bolder"><?php echo $row['material_name']; ?></td>
                            <td class="text-dark fw-bolder"><?php echo $row['material_type']; ?></td>
                            <td>
    <td>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="d-inline">
        <input type="hidden" name="material_id" value="<?php echo $row['material_id']; ?>">
        <button type="submit" class="btn btn-info mr-3" name="view_description" value="View Description">View Description</button>
        <?php
        // Construct the file path without the duplicated "material" directory
        $file_path = "../instructor/material/" . $row['material_url'];
        if (file_exists($file_path)) {
            // If the file exists, display the download link
            echo '<a href="' . $file_path . '" download="' . $row['material_name'] . '" class="btn btn-success">Download</a>';
        } else {
            // If the file does not exist, display an error message
            echo '<span class="text-danger">File not found</span>';
        }
        ?>
    </form>
</td>


                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            <?php } else {
                echo "<p class='text-dark p-2 fw-bolder'>Materials Not Found. </p>";
            }
        } ?>
    </div>
    <div style="align:center;" class="text-dark p-2 fw-bolder">
        <a href="MyCourse.php" class="btn btn-info mr-3">Back to My Course</a>
    </div>
</div>

</body>
</html>
