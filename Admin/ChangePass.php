<?php
include_once("../DB_Files/db.php");
include_once("Header.php");

$email = $_SESSION['email'];
if (isset($_POST['updatePass'])) {
    if ($_POST['admin_pass'] == "") {
        $passmsg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert">All Fields Required</div>';
    } else {
        // Validate and sanitize input
        $new_password = $_POST['admin_pass'];

        // Hash the new password securely
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Prepare and execute SQL query
        $sql = "UPDATE admin SET password=? WHERE email=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $hashed_password, $email);

        if ($stmt->execute()) {
            $passmsg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert">Password Updated Successfully</div>';
        } else {
            $passmsg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert">Failed to Update Password</div>';
        }
    }
}
?>
<div class="container" style="padding: 7%;">
    <div class="col-sm-12 mt-5">
        <p class="bg-dark text-white p-2">Change Password</p>
        <div class="row">
            <div class="col-sm-6">
                <form method="POST" enctype="multipart/form-data" class="mx-5 mt-5">
                    <?php if (isset($passmsg)) { echo $passmsg; } ?>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" id="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" readonly>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="admin_pass">New Password</label>
                        <input type="password" id="admin_pass" name="admin_pass" class="form-control">
                    </div>
                    <br>
                    <button type="submit" name="updatePass" class="btn btn-primary">Update</button>
                    <br><br><br>
                </form>
            </div>
        </div>
    </div>
</div>
