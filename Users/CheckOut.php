<?php
session_start();
$cid = $_SESSION["course_id"];
include_once("../DB_Files/db.php");

if (!isset($_SESSION['stu_id'])) {
    header('Location:../index.php');
    exit; // Exit to prevent further execution
}

$stu_id = $_SESSION['stu_id']; // Fetch student ID from session
$stu_email = $_SESSION['stu_email'];

// Fetch course details from the database
$sql = "SELECT course_name, course_price FROM course WHERE course_id = $cid";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $course_name = $row["course_name"];
    $amount = $row["course_price"];
} else {
    // Handle error if course details are not found
    $course_name = "Course Name Not Found";
    $amount = 0; // Set a default amount
}

// Retrieve form inputs
if (isset($_POST['payment'])) {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];

    // Step 1: Initialize the Transaction
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.chapa.co/v1/transaction/initialize',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '{
            "amount": "' . $amount . '",
            "currency": "ETB",
            "email": "' . $email . '",
            "first_name": "' . $full_name . '",
            "last_name": "",
            "phone_number": "",
            "tx_ref": "chewatatest-' . uniqid() . '",
            "callback_url": "http://localhost/ethiolearn/Users/callback.php",
            "return_url": "http://localhost/ethiolearn/Users/success.php?course_id=' . $cid . ';stu_id=' . $stu_id . ';amount=' . $amount . '",
            "customization[title]": "Payment for ' . $course_name . '",
            "customization[description]": "Payment for ' . $course_name . '"
        }',
        
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer CHASECK_TEST-D6it1Zcq3qNVdXx79JR4S4llNO3F6v4q',
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $response_data = json_decode($response, true);

    if (isset($response_data['status']) && $response_data['status'] === 'success' && isset($response_data['data']['checkout_url'])) {
        // Redirect the user to the checkout URL
        header('Location: ' . $response_data['data']['checkout_url']);
        exit;
    }    
    else {
        // If initialization fails, handle the error (display message or redirect to error page)
        $msg = '<div class="alert">Payment initialization failed</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <!-- Include your CSS stylesheets and other necessary scripts -->
</head>
<body>
    <!-- Your checkout form -->
    <form method="POST" action="">
        <!-- Add form fields for user input -->
        <label for="full_name">Full Name:</label>
        <input type="text" id="full_name" name="full_name" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="course_name">Course Name:</label>
        <input type="text" id="course_name" name="course_name" value="<?php echo $course_name; ?>" readonly><br><br>
        <label for="amount">Amount:</label>
        <input type="text" id="amount" name="amount" value="<?php echo $amount; ?>" readonly><br><br>

        <button type="submit" name="payment">Proceed to Payment</button>
    </form>
</body>
</html>
