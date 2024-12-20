<?php
session_start();

if (!isset($_SESSION['stu_email'])) {
    header("Location: login.php");
    exit();
}

include_once("ProfileHeader.php");
include_once("../DB_Files/db.php");

$stu_email = $_SESSION['stu_email'];
$sql = "SELECT * FROM students WHERE stu_email='$stu_email'";
$result = $conn->query($sql);
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $stuId = $row['stu_id'];
    $stuName = $row["stu_name"];
    $stuOcc = $row["stu_occ"];
    $stuImg = $row["stu_img"];
}

if (isset($_REQUEST['updateStuNameBtn'])) {
    if (empty($_REQUEST['stuName'])) {
        $passmsg = '<div class="alert alert-warning col-sm-6 mx-auto mt-2" role="alert">All Fields Required</div>';
    } else {
        $stuName = $_REQUEST["stuName"];
        $stuOcc = $_REQUEST["stuOcc"];
        $stu_image = $_FILES['stuImg']['name'];
        $stu_image_temp = $_FILES['stuImg']['tmp_name'];
        $img_folder = '../Images/Student/' . $stu_image;
        move_uploaded_file($stu_image_temp, $img_folder);

        $sql = "UPDATE students SET stu_name='$stuName', stu_occ='$stuOcc', stu_img='$img_folder' WHERE stu_email='$stu_email'";
        if ($conn->query($sql) === TRUE) {
            $passmsg = '<div class="alert alert-success col-sm-6 mx-auto mt-2" role="alert">Updated Successfully</div>';
        } else {
            $passmsg = '<div class="alert alert-warning col-sm-6 mx-auto mt-2" role="alert">Update Failed</div>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <style>
        small {
            font-size: .9rem;
        }
        .container {
            padding: 10%;
        }
    </style>
    <script>
    window.addEventListener('beforeunload', function() {
        sessionStorage.setItem('page_open', 'false');
    });

    document.addEventListener('DOMContentLoaded', function() {
        if (sessionStorage.getItem('page_open') === 'true') {
            alert('This page is already open in another tab.');
            window.location.href = 'anotherpage.php'; // Redirect to another page
        } else {
            sessionStorage.setItem('page_open', 'true');
        }
    });
    </script>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12 mt-4">
                <p class="bg-dark text-white p-2 fw-bolder">Public Profile</p>
                <form method="POST" enctype="multipart/form-data">
                    <?php if (isset($passmsg)) {
                        echo $passmsg;
                    } ?>
                    <div class="form-group">
                        <label class="text-dark" for="stuId">Student ID</label>
                        <input type="text" id="stuId" class="form-control" name="stuId" value="<?php if (isset($stuId)) { echo $stuId; } ?>" readonly>
                    </div>
                    <br>
                    <div class="form-group">
                        <label class="text-dark" for="stuEmail">Student Email</label>
                        <input type="email" id="stuEmail" class="form-control" value="<?php echo $stu_email ?>" readonly>
                    </div>
                    <br>
                    <div class="form-group">
                        <label class="text-dark" for="stuName">Student Name</label>
                        <input type="text" id="stuName" name="stuName" class="form-control" value="<?php if (isset($stuName)) { echo $stuName; } ?>">
                    </div>
                    <br>
                    <div class="form-group">
                        <label class="text-dark" for="stuOcc">Student Occupation</label>
                        <input type="text" id="stuOcc" name="stuOcc" class="form-control" value="<?php if (isset($stuOcc)) { echo $stuOcc; } ?>">
                    </div>
                    <br>
                    <div class="form-group">
                        <label class="text-dark" for="stuImg">Upload Image</label>
                        <input type="file" class="form-control-file" id="stuImg" name="stuImg">
                    </div>
                    <br>
                    <button type="submit" name="updateStuNameBtn" class="btn btn-danger">Update</button>
                    <br><br><br>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
