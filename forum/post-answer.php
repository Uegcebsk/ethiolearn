<?php
include_once("../DB_Files/db.php");
include_once("../Inc/Header.php");

$A_body = $_POST["A_body"];
$A_stu_id = $_SESSION['stu_id'];
$qid = $_SESSION['qid'];
$likes = 0;

if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(!empty($A_body) && $A_body!='Enter Answer Body'){
        // Prepare an insert statement
        $sql = "INSERT INTO Answers (Q_id, A_stu_id, A_body, likes) VALUES (?,?,?,?)";
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $qid, $A_stu_id, $A_body, $likes);
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                echo ("Answer successfully posted to forum");

            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    else {
        echo "Please fill up Answer body.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<body>
</body>
</html>