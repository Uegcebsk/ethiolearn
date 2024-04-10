<?php
session_start();
include("../DB_Files/db.php");
$errors = [];

if (isset($_POST['login'])) {
    $sigInEmail = $_POST['email2'];
    $signInPassword = $_POST['password2'];

    if (empty($sigInEmail)) {
        $errors['Email2'] = "Email Address is Required.";
    }

    if (empty($signInPassword)) {
        $errors['Password2'] = "Password is Required.";
    }

    if (empty($errors)) {
        // Use prepared statements to prevent SQL injection
        $sql = "SELECT * FROM lectures WHERE l_email=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $sigInEmail);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            // Verify password
            if (password_verify($signInPassword, $user['l_password'])) {
                $_SESSION['l_id'] = $user['l_id']; // Assuming 'l_id' is the instructor's ID column
                $_SESSION['l_email'] = $user['l_email'];
                header("Location: dashboard.php");
                exit;
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
    <link rel="stylesheet" href="/ethiolearn/Admin/CSS/Index.css">
    <script language="javascript" type="text/javascript">
        window.history.forward();
    </script>
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
        <h1>Instructor Login</h1>
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
            <input type="email" name="email2" class="form__field" placeholder="Email" value="<?php echo isset($_POST['email2']) ? htmlspecialchars($_POST['email2']) : ''; ?>" />
            <?php
            if (isset($errors['Email2'])) {
                echo "<div class='validationError'>" . $errors['Email2'] . "</div>";
            }
            ?>
            <br>
            <input type="password" name="password2" placeholder="Password" />
            <?php
            if (isset($errors['Password2'])) {
                echo "<div class='validationError'>" . $errors['Password2'] . "</div>";
            }
            ?>
            <br><br>
            <button type="submit" name="login" class="btn btn-primary btn-block btn-large">Log In</button>
        </form>
    </div>
</body>

</html>
