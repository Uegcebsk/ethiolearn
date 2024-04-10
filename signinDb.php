<?php

session_start();
include("DB_Files/db.php");
$errors=[];


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
        $sql="SELECT * FROM students WHERE stu_email='".$sigInEmail."'";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            $user = $result->fetch_assoc();
            if($user['email_verified'] == 1){
                // Email is verified, proceed with login
                $hash = $user['stu_pass'];
                if(password_verify($signInPassword, $hash)){
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

include("Login&SignIn.php");
?>
