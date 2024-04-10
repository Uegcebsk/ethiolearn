<?php
include_once("Header copy.php");
include_once("../DB_Files/db.php");

// Function to display success or error messages
function displayMessage($msg, $type = 'success')
{
    return '<div class="alert alert-' . $type . ' col-sm-6 ml-5 mt-2 m-2">' . $msg . '</div>';
}

// Function to fetch course options for the select dropdown
function fetchExamCategories($instructorId)
{
    global $conn;
    $sql = "SELECT * FROM exam_category WHERE lec_id='$instructorId'";
    $result = $conn->query($sql);
    $options = '<option value="" selected disabled hidden>--Select Exam Category--</option>';
    while ($row = $result->fetch_assoc()) {
        $options .= '<option value="' . $row['id'] . '">' . $row['exam_name'] . '</option>';
    }
    return $options;
}

// Handling form submission to update exam category
if (isset($_POST['reqUpdate'])) {
    if (empty($_POST['id']) || empty($_POST['name']) || empty($_POST['time'])) {
        $msg = displayMessage('All Fields Required', 'warning');
    } else {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $time = $_POST['time'];
        
        $sql = "UPDATE exam_category SET exam_name='$name', exam_time='$time' WHERE id='$id'";

        if ($conn->query($sql) === TRUE) {
            $msg = displayMessage('Category Updated Successfully');
            echo '<meta http-equiv="refresh" content="3;"/>';
        } else {
            $msg = displayMessage('Category Update Failed', 'warning');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Exam Category</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>
<body>
<div class="container" style="padding:5%;">
    <div class="col-sm-11 mt-5 jumbotron">
        <h3 class="text-center">Edit Exam Category</h3>
        <?php
        if (isset($_REQUEST['view'])) {
            $sql = "SELECT * FROM exam_category WHERE id={$_REQUEST['id']}";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
        }
        ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <br>
            <?php if (isset($msg)) {
                echo $msg;
            } ?><br>
            <div class="form-group">
                <label for="id">Exam Category ID</label>
                <input type="text" id="id" name="id" class="form-control" value="<?php echo isset($row['id']) ? $row['id'] : ''; ?>" readonly>
            </div><br>
            <div class="form-group">
                <label for="name">Exam Category Name</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo isset($row['exam_name']) ? $row['exam_name'] : ''; ?>">
            </div><br>
            <div class="form-group">
                <label for="time">Exam Category Time (in minutes)</label>
                <input type="text" id="time" name="time" class="form-control" value="<?php echo isset($row['exam_time']) ? $row['exam_time'] : ''; ?>"> 
            </div><br>
            <div class="text-center">
                <button class="btn btn-primary" type="submit" name="reqUpdate">Update</button>
                <a href="exam_catagories.php" class="btn btn-secondary">back</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>

<?php
include_once("Footer.php");
?>
