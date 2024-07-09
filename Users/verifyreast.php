<?php
include_once("../DB_Files/db.php");
include_once("ProfileHeader.php");
include_once("../vendor/autoload.php"); // Adjust the path as per your project structure

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Function to generate a random verification code
function generateVerificationCode($length = 20) {
    return bin2hex(random_bytes($length));
}

// Function to send email with PHPMailer
function sendEmail($to, $verificationCode) {
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'desudes0621@gmail.com'; // SMTP account username
        $mail->Password   = 'dgizjzzckmeueqsv';    // SMTP account password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587; // SMTP port

        //Recipients
        $mail->setFrom('desudes0621@gmail.com', 'ethio learn');
        $mail->addAddress($to); // Add a recipient
        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Reset Password';
        $mail->Body    = 'Click the following link to reset your password: <a href="http://localhost/ethiolearn/Users/ChangePass.php?code=' . $verificationCode . '">Reset Password</a>';

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// Reset password process
if (isset($_POST['resetPassword'])) {
    $email = $_POST['email'];
    $verificationCode = generateVerificationCode();

    // Update verification code in the database
    $sql = "UPDATE students SET verification_code='$verificationCode' WHERE stu_email='$email'";
    if ($conn->query($sql) === TRUE) {
        // Send email with verification code
        if (sendEmail($email, $verificationCode)) {
            $resetMsg = '<div class="alert alert-success">Password reset link has been sent to your email.</div>';
        } else {
            $resetMsg = '<div class="alert alert-danger">Failed to send password reset email.</div>';
        }
    } else {
        $resetMsg = '<div class="alert alert-danger">Error updating verification code.</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <style>
        .container{
            padding:6%;
        }
        </style>
</head>
<body>

<div class="container" style="padding-left=5%;">
    <h2>Password Reset</h2>
    <?php if(isset($resetMsg)) echo $resetMsg; ?>
    <form method="POST">
        <div class="form-group">
            <label for="email">Email address:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <button type="submit" class="btn btn-primary" name="resetPassword">Reset Password</button>
    </form>
</div>
</div>
</body>
</html>
