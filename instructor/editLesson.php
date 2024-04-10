<?php>
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<?php
include_once("Header copy.php");
include_once("../DB_Files/db.php");



if (isset($_REQUEST['reqUpdate'])) {
    if (($_REQUEST['lesson_id'] == "") || ($_REQUEST['lesson_name'] == "") || ($_REQUEST['course_id'] == "")) {
        $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2">All Fields Required</div>';
    } else {
        $lid = $_REQUEST['lesson_id'];
        $lname = $_REQUEST['lesson_name'];
        $cid = $_REQUEST['course_id'];
        $Llink = $_REQUEST['lesson_link'];
        $ldesc = $_REQUEST['lesson_description'];

        $sql = "UPDATE lesson SET lesson_id='$lid', lesson_name='$lname', lesson_link='$Llink', lesson_description='$ldesc' WHERE lesson_id='$lid'";

        if ($conn->query($sql) === TRUE) {
            $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2">Updated Successfully</div>';
        } else {
            $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2">Updated Failed</div>';
        }
    }
}

?>

<div class="container" style="padding:5%;">
<div class="col-sm-11 mt-5 jumbotron">
    <h3 class="text-center">Edit Lesson Details</h3>
    <?php
    if (isset($_REQUEST['view'])) {
        $sql = "SELECT * FROM lesson WHERE lesson_id={$_REQUEST['id']}";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
    }
    ?>
    <form action="" method="POST" enctype="multipart/form-data">
        <br>
        <?php if (isset($msg)) {
            echo $msg;
        } ?><br>
        <div class="form-group">
            <label for="lesson_id">Lesson ID</label>
            <input type="text" id="lesson_id" name="lesson_id" class="form-control" value="<?php if (isset($row['lesson_id'])) {
                echo $row['lesson_id'];
            } ?>" readonly>
        </div><br>
        <div class="form-group">
            <label for="lesson_name">Lesson Name</label>
            <input type="text" id="lesson_name" name="lesson_name" class="form-control" value="<?php if (isset($row['lesson_name'])) {
                echo $row['lesson_name'];
            } ?>">
        </div><br>
        <div class="form-group">
            <label for="upload_type">Upload Type</label>
            <select name="upload_type" id="upload_type" class="form-control">
                <option value="youtube" <?php if ($row['lesson_link'] && strpos($row['lesson_link'], 'youtube.com') !== false) echo 'selected'; ?>>YouTube Link</option>
                <option value="file" <?php if ($row['lesson_link'] && strpos($row['lesson_link'], 'youtube.com') === false) echo 'selected'; ?>>Upload File</option>
            </select>
        </div>
        <div class="form-group" id="youtube_link_input" style="<?php if ($row['lesson_link'] && strpos($row['lesson_link'], 'youtube.com') !== false) echo 'display:block;'; else echo 'display:none;'; ?>">
            <label for="lesson_link">Lesson YouTube ID</label>
            <input type="text" id="lesson_link" name="lesson_link" class="form-control" value="<?php if (isset($row['lesson_link'])) {
                echo $row['lesson_link'];
            } ?>">
        </div>
        <div class="form-group" id="file_upload_input" style="<?php if ($row['lesson_link'] && strpos($row['lesson_link'], 'youtube.com') === false) echo 'display:block;'; else echo 'display:none;'; ?>">
            <label for="lesson_file">Upload Video File</label>
            <input type="file" id="lesson_file" name="lesson_file" class="form-control-file">
        </div>
        <br>
        <div class="form-group">
            <label for="lesson_description">Lesson Description</label>
            <textarea id="lesson_description" name="lesson_description" class="form-control"><?php if (isset($row['lesson_description'])) {
                echo $row['lesson_description'];
            } ?></textarea>
        </div>
        <br>
        <div class="text-center">
            <button class="btn btn-danger" type="submit" name="reqUpdate">Update</button>
            <a href="Lesson.php" class="btn btn-secondary">Back</a>
        </div>
    </form>
</div>
        </div>
<script>
document.getElementById('upload_type').addEventListener('change', function() {
    var value = this.value;
    var linkInput = document.getElementById('youtube_link_input');
    var fileInput = document.getElementById('file_upload_input');
    if (value === 'youtube') {
        linkInput.style.display = 'block';
        fileInput.style.display = 'none';
    } else {
        linkInput.style.display = 'none';
        fileInput.style.display = 'block';
    }
});
</script>
<?php
include_once("Footer.php");
?>