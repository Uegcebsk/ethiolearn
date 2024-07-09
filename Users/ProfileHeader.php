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
    <link rel="stylesheet" href="/ethiolearn/Users/CSS/style.css">
    <link rel="stylesheet" href="/ethiolearn/Font awesome/webfonts/all.min.css">
    <script src="/ethiolearn/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Bootstrap  -->
    <link rel="stylesheet" href="/ethiolearn/bootstrap/css/bootstrap.min.css">
    <style>
        .badge {
            position: relative;
            top: -1px;
            right: -10px;
            background-color: red;
            color: white;
            border-radius: 50%;
            padding: 5px 8px;
            font-size: 12px;
          width: 105px;
            text-align: center;
            z-index: 1;
        }
        .notification-icon {
            position: relative;
            padding-right: 10%;
        }
        .badgee {
            position: relative;
            top: -10px;
            right: -10px;
            background-color: red;
            color: white;
            border-radius: 50%;
            padding: 5px 8px;
            font-size: 12px;
            min-width: 15px;
            text-align: center;
            z-index: 1;
        }
        .notificationn-icon {
            position: relative;
            padding-right: 10%;
        }
        .goog-logo-link, .goog-te-gadget span {
            display: none !important;
        }
        .goog-te-gadget {
            color: transparent !important;
            font-size: 0;
        }
        .goog-te-banner-frame {
            display: none !important;
        }
        .goog-te-gadget img {
            display: none !important;
        }
        body > .skiptranslate {
            display: none;
        }
        body {
            top: 0px !important;
        }
     
    .dropdown-menu {
        position: absolute;
        z-index: 1000;
        background-color: #000; /* Black background color */
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: #dc3545;;
        padding: 10px;
        display: none;
    }

    .dropdown-menu li {
        list-style: none;
    }

    .dropdown-menu a {
        display: block;
        padding: 8px 12px;
        color: #fff; /* White text color */
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .dropdown-menu a:hover {
        background-color: #dc3545; /* Darker background color on hover */
        border: 1px solid;
    }

</style>

  
</head>
<body>
    <input type="checkbox" id="menu-toggle">
    <div class="sidebar">
        <div class="side-header"></div>
        <div class="side-content">
            <div class="side-menu">
                <ul>
                    <li class="nav-item mb-3">
                        <img src="<?php echo $stu_img ?>" alt="" class="img-thumbnail rounded-circle" style="margin-left: 10px; height:150px; width:150px; padding:0px;">
                    </li>
                    <li class="nav-item">
                        <a href="Profile.php" class="nav-link">
                            <i class="uil uil-user-square"></i> Profile
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="dashbord.php" class="nav-link">
                            <i class="uil uil-user-square"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="MyCourse.php" class="nav-link">
                            <i class="uil uil-book"></i> My Courses
                        </a>
                    </li>
                    <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" aria-haspopup="true" aria-expanded="false">
        <i class="uil uil-clipboard-alt"></i> Take Exam/Quiz
    </a>
    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
        <li><a class="dropdown-item" href="exam_courses.php">Take an Exam</a></li>
        <li><a class="dropdown-item" href="EnrollQuiz.php">Take a Quiz</a></li>
    </ul>
</li>
                    <li class="nav-item">
                        <a href="add_testimonial.php" class="nav-link">
                            <i class="uil uil-feedback"></i> testimonial
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="getCertificate.php" class="nav-link">
                            <i class="uil uil-award"></i> Get Certificate
                        </a>
                    </li>
                    <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="messageDropdown" role="button" aria-haspopup="true" aria-expanded="false">
        <i class="uil uil-message"></i> Results
    </a>
    <ul class="dropdown-menu" aria-labelledby="messageDropdown">
    <li><a class="dropdown-item" href="/ethiolearn/Users/student_exam_result.php">Exam result</a></li>
    <li><a class="dropdown-item" href="/ethiolearn/Users/old_result.php">Quiz result</a></li>
    </ul>
</li>
    
                    <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="messageDropdown" role="button" aria-haspopup="true" aria-expanded="false">
        <i class="uil uil-message"></i> Message
    </a>
    <ul class="dropdown-menu" aria-labelledby="messageDropdown">
        <li><a class="dropdown-item" href="/ethiolearn/Users/message.php">Send Message</a></li>
        <li><a class="dropdown-item" href="/ethiolearn/Users/inbox_student.php">Inbox</a></li>
    </ul>
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
                        <a href="notice bord.php" class="nav-link">
                            <i class="uil uil-sign-out-alt"></i> Notices
                        </a>
                    </li>

            <?php
            // Include the check_new_messages.php script to get new message count
            include_once("check_new_message.php");
            ?>
            <!-- Display new message count as a badge -->
        
    </ul>
</li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="main-content">
        <header>
            <div class="header-content">
                <label for="menu-toggle">
                    <span class="fas fa-bars"></span>
                </label>
                <a class="navbar-brand" href="/ethiolearn/index.php">Ethio Learn <span style="font-size: 1rem;">Student Profile</span></a>
                <div class="header-menu">
                    <div id='google_translate_element'></div>
                    <script src='//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit' async></script>
                    <script>
                        function googleTranslateElementInit() {
                            new google.translate.TranslateElement({
                                pageLanguage: 'en',
                                autoDisplay: 'true',
                                includedLanguages: 'am,en,om',
                                layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL
                            }, 'google_translate_element');
                        }
                    </script>
                    <a href="inbox_detail_student.php?stu_id=<?php echo $_SESSION['stu_id']; ?>" class="notificationn-icon">
                        <span class="fas fa-comment" style="width: 50px; height: auto; margin-right: 18px; border-radius: 50%;:"></span>
                        <span class="badgee" style="width: 30px; height: auto; margin-right: 18px; border-radius: 50%;"><?php echo $new_messages_count; ?></span>
                    </a>
                    <a class="nav-link notification-icon" href="notification.php">
                        <span class="badge bg-danger" style="width: 30px; height: auto; margin-right: 18px; border-radius: 50%;"><?php echo $notificationCount; ?></span>
                        <img src="Img/notification.png" alt="Notification" style="width: 30px; height: auto; margin-right: 18px; border-radius: 50%;">
                    </a>
                    <div class="user">
                        <div class="bg-img" style="background-image: url(img/1.jpeg)"></div>
                        <span class="fas fa-power-off"></span>
                        <a href="Logout.php"><span style="color:white">Logout</span></a>
                    </div>
                </div>
            </div>
        </header>
    </div>
   <!-- Add custom JavaScript to open dropdown on hover -->
<!-- Add custom JavaScript to keep dropdown open when cursor moves over it -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Select all dropdown toggles and menus
        var dropdownToggles = document.querySelectorAll('.dropdown-toggle');
        var dropdownMenus = document.querySelectorAll('.dropdown-menu');

        // Function to open dropdown
        function openDropdown(index) {
            dropdownMenus[index].style.display = 'block';
        }

        // Function to close dropdown
        function closeDropdown(index) {
            dropdownMenus[index].style.display = 'none';
        }

        // Add event listeners for each dropdown
        dropdownToggles.forEach(function(toggle, index) {
            var menu = dropdownMenus[index];

            toggle.addEventListener('mouseenter', function() {
                openDropdown(index);
            });

            toggle.addEventListener('mouseleave', function() {
                closeDropdown(index);
            });

            menu.addEventListener('mouseenter', function() {
                openDropdown(index);
            });

            menu.addEventListener('mouseleave', function() {
                closeDropdown(index);
            });
        });
    });
</script>





</body>
</html>
