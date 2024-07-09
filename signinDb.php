<?php

session_start();
include("DB_Files/db.php");
$errors=[];
// Use prepared statements to prevent SQL injection
if(isset($_POST['login'])){
    $sigInEmail=$_POST['email2'];
    if(empty($sigInEmail)){
        $error_msg['Email2'] = "Email Address is Required";
    }
    
    $signInPassword=$_POST['password2'];
    if(empty($signInPassword)){
        $error_msg['Password2'] = "Password is Required";
    }
    

    if($sigInEmail && $signInPassword){
        $sql="SELECT * FROM students WHERE stu_email=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $sigInEmail);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){
            $user = $result->fetch_assoc();
            if($user['email_verified'] == 1){
                // Email is verified, proceed with login
                $hash = $user['stu_pass'];
                if(password_verify($signInPassword, $hash)){
                    // Set online status to 'online' when logging in
                    $online_status = 'online';
                    $sql_update_status = "UPDATE students SET online_status = ? WHERE stu_id = ?";
                    $stmt_update_status = $conn->prepare($sql_update_status);
                    $stmt_update_status->bind_param("si", $online_status, $user['stu_id']);
                    $stmt_update_status->execute();
                    
                    $_SESSION['stu_id']=$user['stu_id'];
                    $_SESSION['stu_email']=$user['stu_email'];
                    header("Location:index.php");
                    exit;
                    //success login
                }else{
                    $errors[]="Incorrect Password";
                }
            }else{
                $errors[]="Please verify your email to sign in";
            }
        }else{
            $errors[]="User not found";
        }
    }
}

include("Login.php");
?>
