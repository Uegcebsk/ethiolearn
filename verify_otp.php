<?php
include("DB_Files/db.php");

$email = '';
$otp = '';
$error_msg = array();

if (isset($_GET['email'])) {
    $email = trim($_GET['email']);
}

if (isset($_POST['verify'])) {
    $email = trim($_POST['email']);
    $otp = trim($_POST['otp']);

    // Check if OTP is correct
    if (empty($otp)) {
        $error_msg['OTP'] = "OTP is required";
    } else {
        $stmt = $conn->prepare("SELECT otp, otp_expiry FROM students WHERE stu_email=? AND email_verified=0");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $db_otp = $row['otp'];
            $otp_expiry = $row['otp_expiry'];

            if ($otp === $db_otp) {
                if (strtotime($otp_expiry) > time()) {
                    // OTP is correct and not expired
                    $stmt = $conn->prepare("UPDATE students SET email_verified=1 WHERE stu_email=?");
                    $stmt->bind_param("s", $email);
                    if ($stmt->execute()) {
                        $success = "Email verified successfully! Redirecting to login page...";
                        echo '<script>
                                setTimeout(function(){
                                    window.location.href = "login.php";
                                }, 2000);
                              </script>';
                    } else {
                        $error_msg['Server'] = "Server error: Unable to verify email.";
                    }
                } else {
                    $error_msg['OTP'] = "OTP has expired. Please request a new one.";
                }
            } else {
                $error_msg['OTP'] = "Invalid OTP.";
            }
        } else {
            $error_msg['Email'] = "No unverified account found for this email.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <link rel="stylesheet" href="/ethiolearn/CSS/forgot.css";>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="container__form_containerverify">
                <form action="verify_otp.php" method="POST" class="form" id="verify">
                    <h2 class="form__title">Verify OTP</h2>
                    <?php
                    if (!empty($error_msg)) {
                        foreach ($error_msg as $key => $value) {
                            ?>
                            <div class="alert"><?php echo $value; ?></div>
                        <?php
                        }
                    }
                    if (isset($success)) {
                        ?>
                        <div class="success"><?php echo $success; ?></div>
                    <?php
                    }
                    ?>
                    <div class="form__group field">
                        <input type="hidden" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" />
                        <input type="text" id="otp" name="otp" placeholder="Enter OTP" class="form__field" value="<?php echo htmlspecialchars($otp); ?>" />
                        <label for="otp" class="form__label"></label>
                    </div>
                    <button name="verify" type="submit" class="cta">
                        <span>Verify</span>
                        <svg width="13px" height="10px" viewBox="0 0 13 10">
                            <path d="M1,5 L11,5"></path>
                            <polyline points="8 1 12 5 8 9"></polyline>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <script src="js/Custom.js"></script>
    <script>
        const signInBtn = document.getElementById("signIn");
        const signUpBtn = document.getElementById("signUp");
        const container = document.querySelector(".container");

        signInBtn.addEventListener("click", () => {
            window.location.href = 'login.php';
        });

        signUpBtn.addEventListener("click", () => {
            container.classList.add("right-panel-active");
        });
    </script>
</body>
</html>
