<?php 
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: Index.php');
    exit; // Always exit after header redirection
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Ethio Learn</title>
    <link rel="stylesheet" href="/ethiolearn/instructor/style.css">
    <link rel="stylesheet" href="/ethiolearn/Font awesome/webfonts/all.min.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.6/css/unicons.css">
     <!-- Bootstrap  -->
     <link rel="stylesheet" href="/ethiolearn/bootstrap/css/bootstrap.min.css">
     <script src="/ethiolearn/js/dropdown.js"></script>
     <style>
        .badge {
            position: relative;
            top: -10px;
            right: -10px;
            background-color: red;
            color: white;
            border-radius: 50%;
            padding: 3px 8px;
            font-size: 12px;
            min-width: 15px;
            text-align: center;
            z-index: 1;
        }
        .notification-icon {
            position: relative;
            padding: 8px 10px;
        }
                .goog-logo-link,.goog-te-gadget span{

display:none !important;

}

.goog-te-gadget{

color:transparent!important;
font-size :0;

}
.goog-te-banner-frame{
 display:none !important;
 }
 .goog-te-gadget img{
    display:none !important;
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
        <div class="side-header">
            <h3>
                <div class="profile">
                    <div class="profile-img bg-img" style="background-image: url(/ethiolearn/Images/Lectures/destinn.jpg)"></div>
                    <span id="name"><?php // Output the name here ?></span>
                </div>
            </h3>
        </div>
        <div class="side-content">
            <div class="side-menu">
                <ul>
                    <li class="nav-item">
                        <a href="Dashboard.php" class="nav-link">
                            <i class="uil uil-tachometer-fast-alt"></i>
                            <b>Dashboard</b>
                        </a>
                    </li>
            
                        <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" aria-haspopup="true" aria-expanded="false">
        <i class="uil uil-clipboard-alt"></i> courses
    </a>
    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
        <li><a class="dropdown-item" href="add_catagories.php">Course Categories</a></li>
        <li><a class="dropdown-item" href="Course.php">Courses</a></li>
    </ul>
</li>

                        <li class="nav-item">
                            <a href="Students.php" class="nav-link">
                                <i class="uil uil-user"></i>
                                <b>Students</b>
                            </a>
                        </li>

                        <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" aria-haspopup="true" aria-expanded="false">
        <i class="uil uil-clipboard-alt"></i> Instructors
    </a>
    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
        <li><a class="dropdown-item" href="Lectures.php">add instructor</a></li>
        <li><a class="dropdown-item" href="track_lectures.php">instructor Activities</a></li>
    </ul>
</li>


                        <li class="nav-item">
                            <a href="Blog.php" class="nav-link">
                            <i class="uil uil-blogger-alt"></i>
                                <b>Blogs</b>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="forum_questions.php" class="nav-link">
                            <i class="uil uil-blogger-alt"></i>
                                <b>forums</b>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="messageDropdown" role="button" aria-haspopup="true" aria-expanded="false">
        <i class="uil uil-message"></i> Message
    </a>
    <ul class="dropdown-menu" aria-labelledby="messageDropdown">
        <li><a class="dropdown-item" href="admin_Messages.php">Send Message</a></li>
        <li></span><a class="dropdown-item" href="inbox.php">Inbox<?php
                        // Include the check_new_messages.php script to get new message count
                        include_once("check_new_message.php");
                        ?>
                        <!-- Display new message count as a badge -->
        <li><a class="dropdown-item" href="Messages.php">guests message</a></li>

    </ul>
</li>
                    
                     
                        <li class="nav-item">
                            <a href="PaymentStatus.php" class="nav-link">
                                <i class="uil uil-invoice"></i>
                                <b>Payment Status</b>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="SellReport.php" class="nav-link">
                                <i class="uil uil-analysis"></i>
                                <b>Report</b>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="Feedback.php" class="nav-link">
                                <i class="uil uil-feedback"></i>
                                <b>Feedback</b>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="ChangePass.php" class="nav-link">
                                <i class="uil uil-key-skeleton"></i>
                                <b>Change Password</b>
                            </a>
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
        <a class="navbar-brand" href="/ethiolearn/index.php">Ethio learn <span style="font-size: 1rem;">Admin Profile</span></a>
        <!-- Add message notification icon before logout icon -->
        <div class="header-menu">
        <div id='google_translate_element'></div>
            <script src='//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit' async></script>
<script>

function googleTranslateElementInit() {

new google.translate.TranslateElement({

pageLanguage: 'en',

autoDisplay: 'true',

includedLanguages:'am,en,om', 

layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL

}, 'google_translate_element');

}

</script>
            <!-- Make the icon clickable to lead to inbox_detail.php -->
            <a href="inbox_detail_admin.php?admin_id=<?php echo $_SESSION['id']; ?>" class="notification-icon">
                <span class="fas fa-comment"></span>
                <!-- Display new message count as a badge -->
                <span class="badge"><?php echo $new_messages_count; ?></span>
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
