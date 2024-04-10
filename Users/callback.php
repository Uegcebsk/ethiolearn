<?php
session_start();

// Check if transaction reference is received
if (isset($_GET['tx_ref'])) {
    $tx_ref = $_GET['tx_ref'];
} else {
    echo "Transaction reference not provided<br>";
    exit;
}

// Initialize curl for payment verification
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.chapa.co/v1/transaction/verify/' . $tx_ref,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer CHASECK_TEST-D6it1Zcq3qNVdXx79JR4S4llNO3F6v4q'
    ),
));

// Execute curl request for payment verification
$response = curl_exec($curl);

// Check for curl errors
if ($response === false) {
    echo 'Curl error: ' . curl_error($curl);
    exit;
}

curl_close($curl);

// Decode response
$response_data = json_decode($response, true);

// Check if payment verification is successful
if (isset($response_data['status']) && $response_data['status'] === 'success') {
    // Include database connection
    include_once("../DB_Files/db.php");

    // Retrieve course ID from session
    $course_id = $_SESSION["course_id"];
    $amount = $response_data['data']['amount'];
    $date = date('Y-m-d');

    // Construct insertion query
    $sql = "INSERT INTO courseorder (order_id, stu_id, course_id, amount, date, stu_name, stu_email, course_name) 
            VALUES ('$tx_ref', '$stu_id', '$course_id', '$amount', '$date', '$stu_name', '$stu_email', 
            (SELECT course_name FROM course WHERE course_id = $course_id))";

    // Execute insertion query
    if ($conn->query($sql) === TRUE) {
        // Redirect to success page with order ID and amount
        header('Location: success.php?order_id=' . $tx_ref . '&amount=' . $amount);
        exit;
    } else {
        echo 'Error inserting payment details into database: ' . $conn->error;
    }
} else {
    echo 'Payment verification failed';
}
?>
