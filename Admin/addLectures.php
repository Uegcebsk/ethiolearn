<?php
include_once("Header.php");
include_once("../DB_Files/db.php");

$l_name = '';
$l_des = '';
$l_email = '';
$l_password = '';
$msg = '';

if (isset($_POST['lecSubmitBtn'])) {
    $l_name = $_POST['lec_name'];
    $l_des = $_POST['lec_design'];
    $l_email = $_POST['l_email'];
    $l_password = $_POST['l_password'];

    if (empty($l_name) || empty($l_des) || empty($l_email) || empty($l_password)) {
        $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2">All Fields Required</div>';
    } else {
        $lec_link = $_FILES['lec_link']['name'];
        $lec_link_temp = $_FILES['lec_link']['tmp_name'];
        $link_folder = '../Images/Lectures/' . $lec_link;
        move_uploaded_file($lec_link_temp, $link_folder);

        // Hash the password before storing it
        $hashed_password = password_hash($l_password, PASSWORD_DEFAULT);

        // Use prepared statements to prevent SQL injection
        $sql = "INSERT INTO lectures (l_name, l_design, l_img, l_email, l_password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $l_name, $l_des, $link_folder, $l_email, $hashed_password);
        if ($stmt->execute()) {
            $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2">Lecture Added Successfully</div>';
            echo "<script>setTimeout(()=>{window.location.href='Lectures.php';},300);</script>";
        } else {
            $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2">Lecture Added Failed</div>';
        }
        $stmt->close();
    }
}
?>

<div class="col-sm-6 mt-5 jumbotron">
    <h3 class="text-center">Add Lectures</h3>
    <form action="" method="POST" enctype="multipart/form-data">
        <br>
        <?php if (!empty($msg)) echo $msg; ?><br>
        <div class="form-group">
            <label for="lec_name">Lecture Name</label>
            <input type="text" id="lec_name" name="lec_name" class="form-control" value="<?php echo htmlspecialchars($l_name); ?>">
        </div><br>
        <div class="form-group">
            <label for="lec_design">Lecture Designation</label>
            <input type="text" id="lec_design" name="lec_design" class="form-control" value="<?php echo htmlspecialchars($l_des); ?>">
        </div>
        <div class="form-group">
            <label for="l_email">Lecture Email</label>
            <input type="email" id="l_email" name="l_email" class="form-control" value="<?php echo htmlspecialchars($l_email); ?>">
        </div>
        <br>
        <div class="form-group">
            <label for="l_password">Lecture Password</label>
            <input type="password" id="l_password" name="l_password" class="form-control" value="<?php echo htmlspecialchars($l_password); ?>">
        </div>
        <br>
        <div class="form-group">
            <label for="lec_link">Lecture Image</label>
            <input type="file" id="lec_link" name="lec_link" class="form-control-file">
        </div>
        <br>
        <div class="text-center">
            <button class="btn btn-danger" type="submit" id="lecSubmitBtn" name="lecSubmitBtn">Submit</button>
            <a href="Lectures.php" class="btn btn-secondary">Close</a>
        </div>
    </form>
</div>
