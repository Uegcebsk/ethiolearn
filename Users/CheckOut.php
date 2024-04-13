<?php
session_start();
$cid = $_SESSION["course_id"];
include_once("../DB_Files/db.php");

if (!isset($_SESSION['stu_id'])) {
    header('Location:../index.php');
    exit;
}

$stu_email = $_SESSION['stu_email'];
$sql = "SELECT * FROM students WHERE stu_email='$stu_email'";
$result = $conn->query($sql);
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $stuId = $row['stu_id'];
    $stuName = $row["stu_name"];
}

date_default_timezone_set('Asia/Kolkata');
$date = date('Y-m-d');

if (isset($_POST['free_course'])) {
    // Retrieve form inputs
    $full_name = $_POST['name'];
    $email = $_POST['email'];
    $amount = $_POST['price'];
    $course_id = $cid;
    $date = $_POST['date'];
    $course_name = $_POST["course_name"];
    
    // Insert order details into the database
    $order_id = uniqid();
    $sql = "INSERT INTO courseorder(order_id, stu_name, stu_email, course_id, course_name, amount, date) 
            VALUES ('$order_id','$full_name','$email','$course_id','$course_name','$amount','$date')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to MyCourses page after successful insertion
        header('Location: MyCourse.php');
        exit;
    } else {
        $msg = '<div class="alert">Payment Failed</div>';
    }
}

// Retrieve form inputs
if (isset($_POST['payment'])) {
    $full_name = $_POST['name'];
    $email = $_POST['email'];
    $amount = $_POST['price'];
    $course_name = $_POST['course_name'];
    $stu_id = $stuId; // Add this line to ensure $stu_id is initialized

    // Step 1: Initialize the Transaction
    $curl = curl_init();

   // Truncate title to a maximum of 16 characters
$title = substr("Payment for " . $course_name, 0, 16);

// Construct request data with truncated title
$request_data = json_encode(array(
    "amount" => $amount,
    "currency" => "ETB",
    "email" => $email,
    "first_name" => $full_name,
    "last_name" => "",
    "phone_number" => "",
    "tx_ref" => "chewatatest-" . uniqid(),
    "callback_url" => "http://localhost/ethiolearn/Users/sucess.php",
    "return_url" => "http://localhost/ethiolearn/Users/success.php",
    "customization" => array(
        "title" => $title, // Use truncated title
        "description" => "Payment for " . $course_name
    )
));

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.chapa.co/v1/transaction/initialize',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $request_data,
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer CHASECK_TEST-D6it1Zcq3qNVdXx79JR4S4llNO3F6v4q',
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        // If cURL fails, handle the error
        $msg = '<div class="alert">cURL Error #:' . $err . '</div>';
    } else {
        $response_data = json_decode($response, true);

        if (isset($response_data['status']) && $response_data['status'] === 'success' && isset($response_data['data']['checkout_url'])) {
            // Store payment details in the session
            $_SESSION['payment_details'] = array(
                'tx_ref' => $response_data['data']['tx_ref'],
                'amount' => $amount,
                'course_id' => $cid,
                'stu_id' => $stu_id
            );
            // Redirect to the Chapa hosted checkout page
            header('Location: ' . $response_data['data']['checkout_url']);
            exit;
        } else {
            // If initialization fails, handle the error (display message or redirect to error page)
            $msg = '<div class="alert">Payment initialization failed</div>';
            // Add debugging statements to understand the response from Chapa API
            echo '<pre>';
            print_r($response_data); // This will print the response from Chapa API for debugging
            echo '</pre>';
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
    <title>ethio learn-Checkout</title>
    <link rel="stylesheet" href="CSS/Checkout.css">
    <style>
          .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #4caf50;
            color: white;
            cursor: pointer;
        }

        .btn.cancel {
            background-color: #f44336;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .btn.cancel:hover {
            background-color: #d32f2f;
        }
    </style>
</head>

<body onkeydown="return (event.keyCode != 116)">
    <div class="container">
        <?php
        if (isset($_SESSION['course_id'])) {
            $sql = "SELECT * FROM course WHERE course_id='$cid'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
        }
        ?>
        <form action="" method="POST">
            <?php if (isset($msg)) {
                echo $msg;
            } ?><br>
            <div class="row">
                <div class="col">
                    <br>
                    <h3 class="title">billing details</h3>
                    <div class="inputBox">
                        <span>Order ID :</span>
                        <input name="order_id" type="text" readonly value="<?php echo uniqid(); ?>">
                    </div>
                    <div class="inputBox">
                        <span>full name :</span>
                        <input name="name" type="text" readonly value="<?php if (isset($stuName)) {
                                                                            echo $stuName;
                                                                        } ?>">
                    </div>
                    <div class="inputBox">
                        <span>email :</span>
                        <input name="email" type="email" readonly value="<?php echo $stu_email ?>">
                    </div>
                    <div class="inputBox">
                        <span>Course Name :</span>
                        <input type="text" name="course_name" readonly value="<?php echo $row['course_name'] ?>">
                    </div>
                    <div class="inputBox">
                        <span>Amount :</span>
                        <input type="text" name="price" readonly value="<?php echo $row['course_price'] ?>">
                    </div>
                    <div class="inputBox">
                        <input type="hidden" name="date" readonly value="<?php echo $date; ?>">
                    </div>
                </div>
            </div>
            <?php if ($row['course_price'] == 0): ?>
                <button type="submit" name="free_course" class="btn">Process</button>
            <?php else: ?>
                <button type="submit" name="payment" class="btn">Proceed to Payment</button>
            <?php endif; ?>
            <button type="button" onclick="window.location.href='../Course.php'" class="btn cancel">Cancel</button>
        </form>
    </div>
</body>
</html>
