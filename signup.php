<?php
include("DB_Files/db.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$fname = '';
$email = ''; 
$password = '';
$cpassword = '';
$error_msg = array();

if (isset($_POST['signup'])) {
    $fname = trim($_POST['name']);
    $email = trim($_POST['email']); 
    $password = $_POST['password'];
    $cpassword = $_POST['c_password'];

    // Name Validation
    if (empty($fname)) {
        $error_msg['Name'] = "Full Name is Required";
    } else if (!preg_match("/^[a-zA-Z]+(?:\s[a-zA-Z]+)+$/", $fname)) {
        $error_msg['Name'] = "Full Name must contain at least two words with letters only";
    } else if (strlen($fname) < 5) {
        $error_msg['Name'] = "Name Must be Minimum 5 Characters";
    }

    // Email Validation
    if (empty($email)) {
        $error_msg['Email'] = "Email is Required";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_msg['Email'] = "Invalid Email Address";
    }

    // Password Validation
    if (empty($password)) {
        $error_msg['Password'] = "Password is Required";
    } else if (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/', $password)) {
        $error_msg['Password'] = "Password must be 8-12 characters long, include at least one letter and one number.";
    }

    // Confirm Password Validation
    if (empty($cpassword)) {
        $error_msg['C_password'] = "Confirm Password is Required";
    } else if ($password !== $cpassword) {
        $error_msg['C_password1'] = "Password Does not Match";
    }

    // Signup Code
    if (empty($error_msg)) {
        $stmt = $conn->prepare("SELECT * FROM students WHERE stu_email=?");
        $stmt->bind_param("s", $email); // Changed variable name from $mail to $email
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $error_msg['Email'] = "Email Already Taken";
        } else {
            $otp = rand(100000, 999999);
            $otp_expiry = date("Y-m-d H:i:s", strtotime('+1 hour')); // OTP expires in 1 hour
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO students (stu_name, stu_email, stu_pass, otp, otp_expiry, email_verified) VALUES (?, ?, ?, ?, ?, 0)");
            $stmt->bind_param("sssss", $fname, $email, $hashed_password, $otp, $otp_expiry); // Changed variable name from $mail to $email

            if ($stmt->execute()) {
                // Send OTP Email
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
                    $mail->addAddress($email, $fname); // Changed variable name from $mail to $email

                    $mail->isHTML(true);
                    $mail->Subject = 'Email Verification';
                    $mail->Body = '<p>Hi ' . $fname . ',</p>' .
                        '<p>Thank you for signing up with Ethio Learn. Please use the following OTP to verify your email:</p>' .
                        '<p><strong>' . $otp . '</strong></p>' .
                        '<p>Best regards,<br>Ethio Learn Team</p>' .
                        '<p><img src="http://localhost/ethiolearn/Img/des2.jpg" alt="Ethio Learn Logo"></p>';

                    $mail->send();
                    // Redirect to OTP Verification Page
                    header("Location: verify_otp.php?email=" . urlencode($email)); // Changed variable name from $mail to $email
                    exit();
                } catch (Exception $e) {
                    $error_msg['Mailer'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } else {
                $error_msg['Server'] = "Server Error: Unable to register.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/login.css">
    <script src="/ethiolearn/js/jquery-3.3.1.min.js"></script>
    <title>Sign Up</title>
    <script language="javascript" type="text/javascript">
        window.history.forward();
    </script>
    <style>
        .goog-logo-link,.goog-te-gadget span{
            display:none !important;
        }

        .goog-te-gadget{
            color:transparent!important;
            font-size :0;
        }

        .goog-te-banner-frame{
            display:none !important;
        }

        .goog-te-gadget img{
            display:none !important;
        }

        body > .skiptranslate {
            display: none;
        }

        body {
            top: 0px !important;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container right-panel-active">
            <!-- Sign Up -->
            <div class="container__form container--signup">
                <form action="signup.php" method="POST" class="form" id="register">
                    <h2 class="form__title">Sign Up</h2>
                    
                    <div class="form__group field">
                        <input type="text" id="name" name="name" placeholder="Full Name" class="form__field" value="<?php echo htmlspecialchars($fname); ?>" autocomplete="off" />
                        <label for="name" class="form__label">Full Name</label>
                    </div>
                    <?php
                    if (isset($error_msg['Name'])) {
                        echo "<div class='validationError'>" . $error_msg['Name'] . "</div>";
                    }
                    ?>
                    <div class="form__group field">
                        <input type="email" id="email" name="email" placeholder="Email Address" class="form__field" value="<?php echo htmlspecialchars($email); ?>" autocomplete="off" />
                        <label for="email" class="form__label">Email Address</label>
                    </div>
                    <small class="error_email validationError"></small>
                    <?php
                    if (isset($error_msg['Email'])) {
                        echo "<div class='validationError'>" . $error_msg['Email'] . "</div>";
                    }
                    ?>
                    <div class="form__group field">
                        <input type="password" id="password" name="password" placeholder="Password" class="form__field" value="<?php echo htmlspecialchars($password); ?>" autocomplete="off" />
                        <label for="password" class="form__label">Password</label>
                    </div>
                    <?php
                    if (isset($error_msg['Password'])) {
                        echo "<div class='validationError'>" . $error_msg['Password'] . "</div>";
                    }
                    if (isset($error_msg['C_password1'])) {
                        echo "<div class='validationError'>" . $error_msg['C_password1'] . "</div>";
                    }
                    ?>
                    <div class="form__group field">
                        <input type="password" id="c_password" name="c_password" placeholder="Confirm Password" class="form__field" value="<?php echo htmlspecialchars($cpassword); ?>" autocomplete="off" />
                        <label for="c_password" class="form__label">Confirm Password</label>
                    </div>
                    <?php
                    if (isset($error_msg['C_password'])) {
                        echo "<div class='validationError'>" . $error_msg['C_password'] . "</div>";
                    }
                    ?>
                    <br><br>
                    <button name="signup" type="submit" class="cta">
                        <span>Sign Up</span>
                        <svg width="13px" height="10px" viewBox="0 0 13 10">
                            <path d="M1,5 L11,5"></path>
                            <polyline points="8 1 12 5 8 9"></polyline>
                        </svg>
                    </button>
                    <div id='google_translate_element'></div>
                </form>
            </div>
            <div class="container__overlay">
                <div class="overlay">
                    <button class="cta cssbtn" id="signIn">
                        <span>Sign In</span>
                        <svg width="13px" height="10px" viewBox="0 0 13 10">
                            <path d="M1,5 L11,5"></path>
                            <polyline points="8 1 12 5 8 9"></polyline>
                        </svg>
                    </button>
                    <button class="cta cssbtn1" id="signUp">
                        <span>Sign Up</span>
                        <svg width="13px" height="10px" viewBox="0 0 13 10">
                            <path d="M1,5 L11,5"></path>
                            <polyline points="8 1 12 5 8 9"></polyline>
                        </svg>
                    </button>
                </div>
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
