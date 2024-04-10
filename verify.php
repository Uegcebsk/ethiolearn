<?php
include("DB_Files/db.php");

if (isset($_GET['code'])) {
    $verification_code = $_GET['code'];

    // Check if the verification code exists in the database
    $query = "SELECT * FROM students WHERE verification_code = '$verification_code' AND email_verified = 0";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $email = $row['stu_email'];

        // Update the user's account status to active
        $update_query = "UPDATE students SET email_verified = 1, verification_code = NULL WHERE stu_email = '$email'";
        if (mysqli_query($conn, $update_query)) {
            echo "Email verification successful. You can now login.";
            // Redirect to sign.php after 3 seconds
            header("refresh:3; url=signinDb.php");
            exit;
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    } else {
        echo "Invalid verification code or email already verified.";
    }
} else {
    echo "Verification code not provided.";
}
?>
