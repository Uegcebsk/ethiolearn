<?php
include_once("../DB_Files/db.php");

// Change password process
if(isset($_GET['code'])) {
    $verificationCode = $_GET['code'];

    // Check if the verification code exists in the database
    $sql = "SELECT * FROM students WHERE verification_code='$verificationCode'";
    $result = $conn->query($sql);

    if($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $stu_email = $row['stu_email'];
        $oldPassword = $row['stu_pass'];

        if(isset($_POST['changePassword'])) {
            $newPassword = $_POST['newPassword'];
            $confirmPassword = $_POST['confirmPassword'];

            // Validate new password
            $errors = array();
            if(empty($newPassword)) {
                $errors[] = "New password is required.";
            }
            if(empty($confirmPassword)) {
                $errors[] = "Confirm password is required.";
            }
            if($newPassword !== $confirmPassword) {
                $errors[] = "Passwords do not match.";
            }
            if(password_verify($newPassword, $oldPassword)) {
                $errors[] = "New password must be different from old password.";
            }
            if(strlen($newPassword) < 8) {
                $errors[] = "New password must be at least 8 characters long.";
            }
            // Add more validation rules as needed

            // If no errors, proceed to update password
            if(empty($errors)) {
                // Encrypt the new password using bcrypt
                $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
                
                // Update the password in the database
                $updateSql = "UPDATE students SET stu_pass='$hashedPassword', verification_code=NULL WHERE stu_email='$stu_email'";
                
                if($conn->query($updateSql)) {
                    // Redirect to verify.php after successful password change
                    header("Location: verify.php?success=1");
                    exit;
                } else {
                    $passMsg = '<div class="alert alert-danger">Failed to update password.</div>';
                }
            } else {
                $passMsg = '<div class="alert alert-danger">' . implode("<br>", $errors) . '</div>';
            }
        }
    } else {
        $passMsg = '<div class="alert alert-danger">Invalid verification code.</div>';
    }
} else {
    $passMsg = '<div class="alert alert-danger">Verification code not found.</div>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <!-- Include your CSS stylesheets here -->
</head>
<body>

<div class="container">
    <h2>Change Password</h2>
    <?php if(isset($passMsg)) echo $passMsg; ?>
    <?php if(!isset($passMsg) || strpos($passMsg, "success") === false) { ?>
    <form method="POST">
        <div class="form-group">
            <label for="newPassword">New Password:</label>
            <input type="password" class="form-control" id="newPassword" name="newPassword" required>
        </div>
        <div class="form-group">
            <label for="confirmPassword">Confirm Password:</label>
            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
        </div>
        <button type="submit" class="btn btn-primary" name="changePassword">Change Password</button>
    </form>
    <?php } ?>
</div>

</body>
</html>
