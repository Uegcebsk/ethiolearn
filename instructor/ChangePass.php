<?php
session_start();
include("../DB_Files/db.php");
$errors = [];

// Function to update password
function updatePassword($conn, $l_id, $newPassword) {
    $hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);
    $sql = "UPDATE lectures SET l_password = ?, password_changed = 1 WHERE l_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $hashed_password, $l_id);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

// Handle password change
if (isset($_POST['change_password'])) {
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Password validation
    if (empty($newPassword)) {
        $errors['NewPassword'] = "New Password is Required.";
    } elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/", $newPassword)) {
        $errors['NewPassword'] = "Password must be at least 6 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
    }

    if (empty($confirmPassword)) {
        $errors['ConfirmPassword'] = "Confirm Password is Required.";
    }

    if ($newPassword != $confirmPassword) {
        $errors[] = "New Password and Confirm Password do not match.";
    }

    if (empty($errors)) {
        if (updatePassword($conn, $_SESSION['l_id'], $newPassword)) {
            header("Location: dashboard.php");
            exit;
        } else {
            $errors[] = "Failed to update password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="/ethiolearn/Admin/CSS/Index.css">
</head>

<style>
    .alert {
        color: red;
        font-size: 15px;
        text-align: center;
        font-weight: 600;
    }
</style>

<body>
    <div class="login">
        <h1>Change Password</h1>
        <br>
        <?php
        if (!empty($errors)) {
            foreach ($errors as $error) {
        ?>
                <div class="alert"><?php echo $error; ?></div>
        <?php
            }
        }
        ?>
        <br><br>
        <form method="post" action="">
            <input type="password" name="new_password" placeholder="New Password" />
            <?php
            if (isset($errors['NewPassword'])) {
                echo "<div class='validationError'>" . $errors['NewPassword'] . "</div>";
            }
            ?>
            <br>
            <input type="password" name="confirm_password" placeholder="Confirm Password" />
            <?php
            if (isset($errors['ConfirmPassword'])) {
                echo "<div class='validationError'>" . $errors['ConfirmPassword'] . "</div>";
            }
            ?>
            <br><br>
            <button type="submit" name="change_password" class="btn btn-primary btn-block btn-large">Change Password</button>
        </form>
    </div>
</body>

</html>
