<?php 
session_start();
if (!isset($_SESSION['l_id'])) {
    header('Location: Index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Ethio Learn</title>
    <link rel="stylesheet" href="/ethiolearn/CSS/style.css">
    <link rel="stylesheet" href="/ethiolearn/CSS/all.min.css">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="/ethiolearn/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/ethiolearn/Font awesome/webfonts/all.min.css">
    <script src="/ethiolearn/js/dropdown.js"></script>
    <script src="/ethiolearn/js/jquery-3.3.1.min.js"></script>

    
    <style>
        .badge {
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
        .notification-icon {
            position: relative;
            padding-right: 10%;
        }
        .notification-text {
            color: red;
            font-size: 14px;
            margin-right: 10px;
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
    .dropdown-toggle{
      padding::5%;
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
        <h3><div class="profile">
           
            <?php 
            include_once("../DB_Files/db.php");
            $l_id = $_SESSION['l_id'];
            $sql = "SELECT l_name, l_img FROM lectures WHERE l_id = '$l_id'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            echo $row['l_name'];
            $l_image=$row['l_img'];
            
            ?>
      <img src="<?php echo $l_image ?>" alt="" class="img-thumbnail rounded-circle" style="margin-left: 10px; height:50px; width:50px; padding:0px;">

            </span></h3>
    </div>
    <div class="side-content">
    <div class="side-menu">
        <ul>
            <li>
                <a href="Dashboard.php" class="active">
                    <span class="fas fa-home"></span>
                    <small>Dashboard</small>
                </a>
            </li>
            <li>
                <a href="Course.php">
                    <span class="fas fa-book"></span>
                    <small>Course</small>
                </a>
            </li>
            <li>
                <a href="Lesson.php">
                    <span class="fas fa-chalkboard"></span>
                    <small>Lesson</small>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown1" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-chalkboard"></i> Lessons
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown1">
                    <li><a class="dropdown-item" href="Lesson.php">Manage lesson</a></li>
                    <li><a class="dropdown-item" href="addLesson.php">Add Lesson</a></li>
                </ul>
            </li>
            <li>
                <a href="Students.php">
                    <span class="fas fa-user-alt"></span>
                    <small>Students</small>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button" aria-haspopup="true" aria-expanded="true">
                    <i class="fas fa-file-alt"></i> Material
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown2">
                    <li><a class="dropdown-item" href="material.php">Manage Materials</a></li>
                    <li><a class="dropdown-item" href="add_material.php">Add Materials</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown3" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-tasks"></i> Assessments
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown3">
                    <li><a class="dropdown-item" href="exam_catagories.php">Exam Categories</a></li>
                    <li><a class="dropdown-item" href="AddQuizz.php">Add Quiz</a></li>
                    <li><a class="dropdown-item" href="add exams.php">Add Exam</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown4" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-envelope"></i> Messages
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown4">
                    <li><a class="dropdown-item" href="messagee.php">Send Message</a></li>
                    <li><a class="dropdown-item" href="inbox.php">Inbox 
                        <?php include_once("check_new_messages.php"); ?>
                        <span class="badge" style="width: 30px; top: -50px;  right: -90px;"><?php echo $new_messages_count; ?></span>
                    </a></li>
                </ul>
            </li>
            <li>
                <a href="resultt.php">
                    <span class="fas fa-poll"></span>
                    <small>All Result</small>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown3" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-tasks"></i> Student Results
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown3">
                    <li><a class="dropdown-item" href="student_exam_result.php">Exam Result</a></li>
                    <li><a class="dropdown-item" href="resultt.php">Quiz Result</a></li>
                </ul>
            </li>
            <li>
                <a href="Feedbackmy.php">
                    <span class="fas fa-comment"></span>
                    <small>Feedback</small>
                </a>
            </li>
            <li>
                <a href="post_notice.php">
                    <span class="fas fa-bullhorn"></span>
                    <small>Post Notice</small>
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
            <span class="fas fa-bars"></span>
        </label>
        
        <a class="navbar-brand" href="">Ethio learn <span style="font-size: 1rem;">Instructor Profile</span></a>
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
            <a href="inbox_detail.php?lecturer_id=<?php echo $_SESSION['l_id']; ?>" class="notification-icon">
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
