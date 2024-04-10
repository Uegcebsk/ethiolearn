<?php
session_start();
include_once("../DB_Files/db.php");

if (!isset($_SESSION['stu_id'])) {
    header('Location:../index.php');
}

// Include fetch_notification_count.php to get the notification count
include_once("fetch_notification_count.php");

$stu_email = $_SESSION['stu_email'];
if (isset($stu_email)) {
    $sql = "SELECT stu_img FROM students WHERE stu_email='$stu_email'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $stu_img = $row['stu_img'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Ethio Learn</title>
    <link rel="stylesheet" href="/ethiolearn/instructor/style.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.6/css/unicons.css">
     <!-- Bootstrap  -->
     <link rel="stylesheet" href="/ethiolearn/bootstrap/css/bootstrap.min.css">
     <style>
         .notification-icon {
            position: relative;
            display: inline-block;
        }
        .notification-icon .badge {
            position: absolute;
            top: -8px;
            right: -8px;
            padding: 5px 8px;
            border-radius: 50%;
            background-color: #dc3545;
            color: #fff;
            font-size: 0.8rem;
        }
        .notification-text {
            margin-top: 5px;
            font-size: 0.8rem;
            color: #6c757d;
        }
        </style>
   
</head>
<body>
   <input type="checkbox" id="menu-toggle">
    <div class="sidebar">
        <div class="side-header">
           
        </div>
        <div class="side-content">
            <div class="side-menu">
                <ul>
                <li class="nav-item mb-3">
                    <img src="<?php echo $stu_img ?>" alt="" class="img-thumbnail rounded-circle" style="margin-left: 10px; height:150px; width:150px;">
                </li>
                <li class="nav-item">
                    <a href="Profile.php" class="nav-link">
                        <i class="uil uil-user-square"></i> Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a href="MyCourse.php" class="nav-link">
                        <i class="uil uil-book"></i> My Courses
                    </a>
                </li>
                <li class="nav-item">
                    <a href="EnrollQuiz.php" class="nav-link">
                        <i class="uil uil-clipboard-alt"></i> Take a Quiz
                    </a>
                </li>
                <li class="nav-item">
                    <a href="Feedback.php" class="nav-link">
                        <i class="uil uil-feedback"></i> Feedback
                    </a>
                </li>
                <li class="nav-item">
                    <a href="getCertificate.php" class="nav-link">
                        <i class="uil uil-award"></i> Get Certificate
                    </a>
                </li>
                <li class="nav-item">
                    <a href="verifyreast.php" class="nav-link">
                        <i class="uil uil-key-skeleton-alt"></i> Change Password
                    </a>
                </li>
                <li class="nav-item">
                    <a href="notification.php" class="nav-link">
                        <i class="uil uil-sign-out-alt"></i> Notification
                    </a>
                </li>
                <li class="nav-item">
                    <a href="Logout.php" class="nav-link">
                        <i class="uil uil-sign-out-alt"></i> Log Out
                    </a>
                </li>
                    
                </ul>
            </div>
        </div>
    </div>
</div>
    
    <div class="main-content">
        
        <header>
            <div class="header-content">
                <label for="menu-toggle">
                    <span class="las la-bars"></span>
                </label>
                <a class="navbar-brand" href="/ethiolearn/index.php">Ethio learn <span style="font-size: 1rem;">Instructor Profile</span></a>
                <div class="header-menu">
                
                <a class="nav-link notification-icon" href="notification.php">
    <span class="notification-text "style="color:red">You have <?php echo $notificationCount; ?> new notifications</span>
    <span class="badge bg-danger " style="width: 30px; height: auto; margin-right: 18px; "><?php echo $notificationCount; ?></span>
    <img src="Img/notification.png" alt="Notification" style="width: 30px; height: auto; margin-right: 18px; border-radius: 50%;">
</a>
                        
                        <span class="las la-power-off"></span>
                        <a href=" Logout.php"><span style="color:white" >Logout</span></a>
                    </div>
                </div>
            </div>
        </header>
        
      
