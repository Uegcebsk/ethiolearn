<?php
include("../DB_Files/db.php");

$token = htmlspecialchars(trim($_GET['token'] ?? ''));
$password = '';
$cpassword = '';
$error_msg = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password = $_POST['password'];
    $cpassword = $_POST['c_password'];

    // Password Validation
    if (empty($password)) {
        $error_msg['Password'] = "Password is required";
    } else if (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/', $password)) {
        $error_msg['Password'] = "Password must be 8-12 characters long, include at least one letter and one number.";
    }

    // Confirm Password Validation
    if (empty($cpassword)) {
        $error_msg['C_password'] = "Confirm Password is required";
    } else if ($password !== $cpassword) {
        $error_msg['C_password'] = "Passwords do not match";
    }

    if (empty($error_msg)) {
        // Verify the token and expiry
        $stmt = $conn->prepare("SELECT reset_token, reset_expiry FROM lectures WHERE reset_token=?");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $current_time = new DateTime();
            $expiry_time = new DateTime($row['reset_expiry']);

            if ($expiry_time > $current_time) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE lectures SET l_password=?, reset_token=NULL, reset_expiry=NULL WHERE reset_token=?");
                $stmt->bind_param("ss", $hashed_password, $token);

                if ($stmt->execute()) {
                    header("Location: index.php");
                    exit();
                } else {
                    $error_msg['Server'] = "Server error: Unable to reset password.";
                }
            } else {
                $error_msg['Token'] = "Invalid or expired token.";
            }
        } else {
            $error_msg['Token'] = "Invalid or expired token.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Instructor Password</title>
    <link rel="stylesheet" href="/ethiolearn/CSS/forgot.css">
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="container__form container--reset">
                <form action="reset_password.php?token=<?php echo htmlspecialchars($token); ?>" method="POST" class="form" id="reset">
                    <h2 class="form__title">Reset Password</h2>
                    <?php
                    if (!empty($error_msg)) {
                        foreach ($error_msg as $key => $value) {
                            echo "<div class='alert'>$value</div>";
                        }
                    }
                    ?>
                    <div class="form__group field">
                        <input type="password" id="password" name="password" placeholder="New Password" class="form__field" value="<?php echo htmlspecialchars($password); ?>" autocomplete="new-password" />
                        <label for="password" class="form__label"></label>
                    </div>
                    <div class="form__group field">
                        <input type="password" id="c_password" name="c_password" placeholder="Confirm Password" class="form__field" value="<?php echo htmlspecialchars($cpassword); ?>" autocomplete="new-password" />
                        <label for="c_password" class="form__label"></label>
                    </div>
                    <button name="reset_password" type="submit" class="cta">
                        <span>Reset Password</span>
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
</body>
</html>
