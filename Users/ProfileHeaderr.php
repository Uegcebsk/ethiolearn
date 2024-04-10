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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.6/css/unicons.css">
    <style>
        body {
            background: #f7f9fa;
            color: #333;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }
        .navbar {
            background-color: #363636;
        }
        .navbar-brand {
            font-size: 1.5rem;
            color: #fff;
            font-weight: bold;
        }
        .navbar-toggler {
            border: none;
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 1000;
            width: 250px; /* Adjust the width as needed */
            background-color: #363636;
            padding-top: 65px;
            overflow-y: auto;
            transition: left 0.3s ease;
        }
        .sidebar-sticky {
            padding-bottom: 20px;
        }
        .nav-link {
            color: #fff;
        }
        .content-container {
            padding-top: 70px;
            padding-left: 270px; /* Adjust this value to match the width of the sidebar */
            text-align: center; /* Center align content */
        }
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
        .fullscreen {
            overflow: hidden;
        }
        @media (max-width: 768px) {
            .sidebar {
                left: -250px;
            }
            .content-container {
                padding-left: 20px;
            }
            .fullscreen {
                overflow: auto;
            }
        }
        .notification-icon {
    display: flex;
    align-items: center;
    color: #fff;
    text-decoration: none;
}

.notification-text {
    margin-right: 10px;
}

.notification-icon img {
    width: 30px;
    height: auto;
}

.badge {
    position: relative;
    top: -15px;
    right: -25px;
    padding: 5px 8px;
    border-radius: 50%;
    background-color: #dc3545;
    color: #fff;
    font-size: 0.8rem;
}

@media (max-width: 768px) {
    .sidebar {
        left: -250px;
    }
    .content-container {
        padding-left: 20px;
    }
    .fullscreen {
        overflow: auto;
    }
}

    </style>
</head>
<body>
    <!-- Navbar -->
<nav class="navbar navbar-dark fixed-top">
    <button class="navbar-toggler" type="button" id="sidebarToggle">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="../index.php">Ethio learn <span style="font-size: 1rem;">Student Profile</span></a>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
        <a class="nav-link notification-icon" href="notification.php">
    <span class="notification-text "style="color:red">You have <?php echo $notificationCount; ?> new notifications</span>
    <span class="badge bg-danger " style="width: 30px; height: auto; margin-right: 18px; "><?php echo $notificationCount; ?></span>
    <img src="Img/notification.png" alt="Notification" style="width: 30px; height: auto; margin-right: 18px; border-radius: 50%;">
</a>

        </li>
    </ul>
</nav>


    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="sidebar-sticky">
            <ul class="nav flex-column">
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
                    <a href="ChangePass.php" class="nav-link">
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
    </nav>

     <!-- Content Container -->
     <div class="content-container">
        <!-- Your content here -->
    </div>

    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.querySelector('.sidebar').style.left = (document.querySelector('.sidebar').style.left === '0px') ? '-250px' : '0px';
            document.body.classList.toggle('fullscreen');
        });
    </script>
</body>
</html>
      
