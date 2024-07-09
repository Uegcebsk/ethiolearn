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

// Handle login
if (isset($_POST['login'])) {
    $signInEmail = $_POST['email2'];
    $signInPassword = $_POST['password2'];

    if (empty($signInEmail)) {
        $errors['Email2'] = "Email Address is Required.";
    }

    if (empty($signInPassword)) {
        $errors['Password2'] = "Password is Required.";
    }

    if (empty($errors)) {
        $sql = "SELECT * FROM lectures WHERE l_email=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $signInEmail);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($signInPassword, $user['l_password'])) {
                $_SESSION['l_id'] = $user['l_id'];
                $_SESSION['l_email'] = $user['l_email'];

                $online_status = 'online';
                $sql_update_status = "UPDATE lectures SET online_status = ? WHERE l_id = ?";
                $stmt_update_status = $conn->prepare($sql_update_status);
                $stmt_update_status->bind_param("si", $online_status, $_SESSION['l_id']);
                $stmt_update_status->execute();

                if ($user['password_changed'] == 0) {
                    header("Location: changepass.php");
                    exit;
                } else {
                    header("Location: dashboard.php");
                    exit;
                }
            } else {
                $errors[] = "Incorrect email or password.";
            }
        } else {
            $errors[] = "Incorrect email or password.";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Area</title>
    <link rel="stylesheet" href="/ethiolearn/CSS/login.css">
    <script language="javascript" type="text/javascript">
        window.history.forward();
    </script>
    <style>
        .alert {
            color: red;
            font-size: 15px;
            text-align: center;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container">
            <div class="container__form container--signin">
                <form action="index.php" method="POST" class="form" id="login">
                    <h2 class="form__title">Instructor Login</h2>
                    <?php
                    if (!empty($errors)) {
                        foreach ($errors as $error) {
                            echo "<div class='alert'>{$error}</div>";
                        }
                    }
                    ?>
                    <div class="form__group field">
                        <input type="email" name="email2" placeholder="Email" class="form__field" value="<?php echo isset($_POST['email2']) ? htmlspecialchars($_POST['email2']) : ''; ?>" />
                        <label for="email2" class="form__label">Email</label>
                    </div>
                    <?php if (isset($errors['Email2'])) echo "<div class='validationError'>{$errors['Email2']}</div>"; ?>
                    <div class="form__group field">
                        <input type="password" name="password2" placeholder="Password" class="form__field" />
                        <label for="password2" class="form__label">Password</label>
                    </div>
                    <?php if (isset($errors['Password2'])) echo "<div class='validationError'>{$errors['Password2']}</div>"; ?>
                    <button type="submit" name="login" class="cta">
                        <span>Log In</span>
                        <svg width="13px" height="10px" viewBox="0 0 13 10">
                            <path d="M1,5 L11,5"></path>
                            <polyline points="8 1 12 5 8 9"></polyline>
                        </svg>
                    </button>
                    <a href="forgot_password.php" class="link">Forgot your password?</a>

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
                        <span>Admin login</span>
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
            container.classList.remove("right-panel-active");
        });

        signUpBtn.addEventListener("click", () => {
            window.location.href = '/ethiolearn/Admin/index.php';
        });
    </script>
</body>

</html>
