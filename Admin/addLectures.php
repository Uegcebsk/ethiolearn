<?php
include_once("Header.php");
include_once("../DB_Files/db.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Adjust the path to autoload.php

$msg = '';

if (isset($_POST['lecSubmitBtn'])) {
    $l_name = $_POST['lec_name'];
    $l_des = $_POST['lec_design'];
    $l_email = $_POST['l_email'];
    $l_password = $_POST['l_password'];

    // Email validation
    if (!filter_var($l_email, FILTER_VALIDATE_EMAIL)) {
        $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2">Invalid Email Address</div>';
    } else {
        // Check if email is already used
        $email_query = "SELECT * FROM lectures WHERE l_email='$l_email'";
        $email_query_run = mysqli_query($conn, $email_query);
        if (mysqli_num_rows($email_query_run) > 0) {
            $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2">Email Already Taken</div>';
        } else {
            $lec_link = $_FILES['lec_link']['name'];
            $lec_link_temp = $_FILES['lec_link']['tmp_name'];
            $link_folder = '../Images/Lectures/' . $lec_link;
            move_uploaded_file($lec_link_temp, $link_folder);

            // Hash the password before storing it
            $hashed_password = password_hash($l_password, PASSWORD_DEFAULT);

            // Use prepared statements to prevent SQL injection
            $sql = "INSERT INTO lectures (l_name, l_design, l_img, l_email, l_password) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $l_name, $l_des, $link_folder, $l_email, $hashed_password);
            if ($stmt->execute()) {
                // Send login credentials via email
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
                    $mail->addAddress($l_email, $l_name); // Add a recipient

                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = 'Your Login Credentials for Our E-Learning Platform';
                    $mail->Body    = '<p>Hi ' . $l_name . ',</p>' .
                                     '<p>You have been added as an instructor to our e-learning platform.</p>' .
                                     '<p>Your login credentials are:</p>' .
                                     '<p>Username: ' . $l_email . '</p>' .
                                     '<p>Password: ' . $l_password . '</p>' .
                                     '<p>Please use the provided credentials to log in to the platform at <a href="http://localhost/ethiolearn/instructor/index.php">Platform URL</a>.</p>' .
                                     '<p>Upon logging in for the first time, you will be prompted to change your password.</p>' .
                                     '<p>If you have any questions or need assistance, please contact us at desudes0621@gmail.com.</p>' .
                                     '<p>Best regards,<br>Your Organization</p>';

                    $mail->send();
                    
                    $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2">Lecture Added Successfully. Verification email sent. Check your email to verify.</div>';
                } catch (Exception $e) {
                    $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2">Lecture Added Successfully, but failed to send verification email.</div>';
                }

            } else {
                $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2">Lecture Added Failed</div>';
            }
            $stmt->close();
        }
    }
}
?>

<div class="container" style="padding:5%;">
    <div class="col-sm-12 mt-5 jumbotron">
        <h3 class="text-center">Add Lectures</h3>
        <form action="" method="POST" enctype="multipart/form-data">
            <br>
            <?php if (!empty($msg)) echo $msg; ?><br>
            <div class="form-group">
                <label for="lec_name">Lecture Name</label>
                <input type="text" id="lec_name" name="lec_name" class="form-control">
            </div><br>
            <div class="form-group">
                <label for="lec_design">Lecture Designation</label>
                <input type="text" id="lec_design" name="lec_design" class="form-control">
            </div>
            <div class="form-group">
                <label for="l_email">Lecture Email</label>
                <input type="email" id="l_email" name="l_email" class="form-control">
            </div>
            <br>
            <div class="form-group">
                <label for="l_password">Lecture Password</label>
                <input type="password" id="l_password" name="l_password" class="form-control">
            </div>
            <br>
            <div class="form-group">
                <label for="lec_link">Lecture Image</label>
                <input type="file" id="lec_link" name="lec_link" class="form-control-file">
            </div>
            <br>
            <div class="text-center">
                <button class="btn btn-danger" type="submit" id="lecSubmitBtn" name="lecSubmitBtn">Submit</button>
                <a href="Lectures.php" class="btn btn-secondary">Close</a>
            </div>
        </form>
    </div>
</div>
