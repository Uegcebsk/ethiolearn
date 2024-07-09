<?php
include("../DB_Files/db.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';

$email = '';
$error_msg = array();
$success = '';

if (isset($_POST['reset'])) {
    $email = trim($_POST['email']);

    // Email Validation
    if (empty($email)) {
        $error_msg['Email'] = "Email is required";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_msg['Email'] = "Invalid email address";
    } else {
        // Check if email exists in the database
        $stmt = $conn->prepare("SELECT * FROM lectures WHERE l_email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Generate a unique reset token and expiry time
            $reset_token = bin2hex(random_bytes(16));
            $reset_expiry = date("Y-m-d H:i:s", strtotime('+1 hour'));

            // Store the reset token and expiry in the database
            $stmt = $conn->prepare("UPDATE lectures SET reset_token=?, reset_expiry=? WHERE l_email=?");
            $stmt->bind_param("sss", $reset_token, $reset_expiry, $email);
            if ($stmt->execute()) {
                // Send the reset email
                $mail = new PHPMailer(true);

                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'desudes0621@gmail.com';
                    $mail->Password = 'dgizjzzckmeueqsv';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;

                    $mail->setFrom('desudes0621@gmail.com', 'Ethio Learn');
                    $mail->addAddress($email);

                    $mail->isHTML(true);
                    $mail->Subject = 'Password Reset Request';
                    $mail->Body = '<p>Hi,</p>' .
                        '<p>We received a request to reset your password. Click the link below to reset it:</p>' .
                        '<p><a href="http://localhost/ethiolearn/instructor/reset_password.php?token=' . $reset_token . '">Reset Password</a></p>' .
                        '<p>If you did not request a password reset, please ignore this email.</p>' .
                        '<p>Best regards,<br>Ethio Learn Team</p>';

                    $mail->send();
                    $success = "Password reset email sent! Check your inbox.";
                } catch (Exception $e) {
                    $error_msg['Mailer'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } else {
                $error_msg['Server'] = "Server error: Unable to request password reset.";
            }
        } else {
            $error_msg['Email'] = "No account found with that email.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Instructor Password</title>
    <link rel="stylesheet" href="/ethiolearn/CSS/forgot.css">
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="container__form container--forgot">
                <form action="forgot_password.php" method="POST" class="form" id="forgot">
                    <h2 class="form__title">Forgot Password</h2>
                    <?php
                    if (!empty($error_msg)) {
                        foreach ($error_msg as $key => $value) {
                            echo "<div class='alert'>$value</div>";
                        }
                    }
                    if (!empty($success)) {
                        echo "<div class='success'>$success</div>";
                    }
                    ?>
                    <div class="form__group field">
                        <input type="email" id="email" name="email" placeholder="Email Address" class="form__field" value="<?php echo htmlspecialchars($email); ?>" autocomplete="email" />
                        <label for="email" class="form__label"></label>
                    </div>
                    <button name="reset" type="submit" class="cta">
                        <span>Reset Password</span>
                        <svg width="13px" height="10px" viewBox="0 0 13 10">
                            <path d="M1,5 L11,5"></path>
                            <polyline points="8 1 12 5 8 9"></polyline>
                        </svg>
                    </button>
                    <div id='google_translate_element'></div>
                </form>
            </div>
        </div>
    </div>
    <script src="js/Custom.js"></script>
</body>
</html>
