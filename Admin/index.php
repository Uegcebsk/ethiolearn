<?php
session_start();
include("../DB_Files/db.php");

$errors = [];

if (isset($_POST['login'])) {
    $sigInEmail = $_POST['email2'];
    $signInPassword = $_POST['password2'];

    // Validate input
    if (empty($sigInEmail)) {
        $errors[] = "Email Address is Required.";
    }

    if (empty($signInPassword)) {
        $errors[] = "Password is Required.";
    }

    if (empty($errors)) {
        // Use prepared statement to fetch user details
        $sql = "SELECT id, email, password FROM admin WHERE email=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $sigInEmail);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            // Verify hashed password
            if (password_verify($signInPassword, $user['password'])) {
                // Password correct, set session variables
                $_SESSION['id'] = $user['id'];
                $_SESSION['email'] = $user['email'];

                // Update online status
                $online_status = 'online';
                $sql_update_status = "UPDATE admin SET online_status = ? WHERE id = ?";
                $stmt_update_status = $conn->prepare($sql_update_status);
                $stmt_update_status->bind_param("si", $online_status, $_SESSION['id']);
                $stmt_update_status->execute();

                // Redirect to dashboard
                header("Location: Dashboard.php");
                exit;
            } else {
                $errors[] = "Incorrect Email or Password.";
            }
        } else {
            $errors[] = "Incorrect Email or Password.";
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
    <title>Admin Area</title>
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

        .cta-instructor {
            display: inline-block;
            padding: 5px 10px;
            margin: 40%;
            font-size: 14px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            outline: none;
            color: #fff;
            background-color: #FFA500; /* Orange color */
            border: none;
            border-radius: 5px;
            box-shadow: 0 4px #999;
            height: 50px;
            width: 100%;
        }

        .cta-instructor:hover {
            background-color: #e69500; /* Darker orange */
        }

        .cta-instructor:active {
            background-color: #e69500;
            box-shadow: 0 2px #666;
            transform: translateY(2px);
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
           
        }

        .overlay {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container">
            <div class="container__form container--signin">
                <form action="index.php" method="POST" class="form" id="login">
                    <h2 class="form__title">Admin Login</h2>
                    <?php
                    if (!empty($errors)) {
                        foreach ($errors as $key => $value) {
                            echo "<div class='alert'>{$value}</div>";
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
                        <svg width="87%;" height="10px" viewBox="0 0 13 10">
                            <path d="M1,5 L11,5"></path>
                            <polyline points="8 1 12 5 8 9"></polyline>
                        </svg>
                    </button>
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
                    <button class="cta-instructor" id="InstructorLogin">
                        <span>Instructor Login</span>
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
        const instructorLoginBtn = document.getElementById("InstructorLogin");
        const container = document.querySelector(".container");

        signInBtn.addEventListener("click", () => {
            container.classList.remove("right-panel-active");
        });

        instructorLoginBtn.addEventListener("click", () => {
            window.location.href = '/ethiolearn/instructor/index.php';
        });
    </script>
</body>

</html>
