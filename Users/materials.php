<?php
include_once("../DB_Files/db.php");
include_once("ProfileHeader.php");
// Validate and sanitize course_id
$course_id = isset($_GET['course_id']) ? intval($_GET['course_id']) : 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materials</title>
    <link rel="stylesheet" href="CSS/watchcourse.css">
    <style>
        /* Additional CSS styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 40px;
            border: 1px solid #888;
            width: 60%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-9 mt-5 m-auto">
            <p class="bg-dark text-white p-2">List of Materials</p>
            <?php
            $sql = "SELECT * FROM materials WHERE course_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $course_id);
            $stmt->execute();
            $result = $stmt->get_result();

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
                            <td class="text-dark fw-bolder"><?php echo htmlspecialchars($row['material_name']); ?></td>
                            <td class="text-dark fw-bolder"><?php echo htmlspecialchars($row['material_type']); ?></td>
                            <td>
                                <button class="btn btn-info mr-3 view-description" data-material-id="<?php echo $row['material_id']; ?>">View Description</button>
                                <a href="download_material.php?material_id=<?php echo $row['material_id']; ?>" class="btn btn-success">Download</a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            <?php } else {
                echo "<p class='text-dark p-2 fw-bolder'>Materials Not Found. </p>";
            } ?>
        </div>
    </div>
    <div style="text-align:center;" class="text-dark p-2 fw-bolder">
        <a href="MyCourse.php" class="btn btn-info mr-3">Back to My Course</a>
    </div>
</div>

<!-- Modal for displaying material description -->
<div id="descriptionModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Material Description</h2>
        <div id="descriptionContent"></div>
    </div>
</div>

<script>
    // Get the modal
    var modal = document.getElementById("descriptionModal");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on the button, open the modal
    var buttons = document.getElementsByClassName("view-description");
    Array.from(buttons).forEach(button => {
        button.addEventListener("click", function() {
            var materialId = this.getAttribute("data-material-id");
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("descriptionContent").innerHTML = this.responseText;
                    modal.style.display = "block";
                }
            };
            xhr.open("GET", "material_detail.php?material_id=" + materialId, true);
            xhr.send();
        });
    });

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    };

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
</script>

</body>
</html>
