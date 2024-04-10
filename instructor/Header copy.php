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
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Ethio Learn</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="/ethiolearn/CSS/all.min.css">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="/ethiolearn/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/ethiolearn/Font awesome/webfonts/all.min.css">

</head>
<body>
   <input type="checkbox" id="menu-toggle">
    <div class="sidebar">
        <div class="side-header">
            <h3><div class="profile">
                <div class="profile-img bg-img" style="background-image: url(/ethiolearn/Images/Lectures/destinn.jpg)"></div><span id="name">     <?php 
            include_once("../DB_Files/db.php");
            $l_id = $_SESSION['l_id'];
            $sql = "SELECT l_name FROM lectures WHERE l_id = '$l_id'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            echo $row['l_name'];
            ?></span></h3>
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
                    <li>
                       <a href="Students.php">
                            <span class="fas fa-user-alt"></span>
                            <small>Students</small>
                        </a>
                    </li>
                    <li>
                       <a href="material.php">
                            <span class="fas fa-file"></span>
                            <small>Material</small>
                        </a>
                    </li>
                    <li>
                       <a href="add material.php">
                            <span class="fas fa-plus"></span>
                            <small>Add material</small>
                        </a>
                    </li>
                    <li>
                       <a href="exam_catagories.php">
                            <span class="fas fa-tasks"></span>
                            <small>Exam Catgorie</small>
                        </a>
                    </li>
                    <li>
                       <a href="add exam.php">
                            <span class="fas fa-plus"></span>
                            <small>Add exam</small>
                        </a>
                    </li>
                    
                    <li>
                       <a href="AddQuizz.php">
                            <span class="fas fa-plus-circle"></span>
                            <small>Add Quizz</small>
                        </a>
                    </li>
                    <li>
                       <a href="resultt.php">
                            <span class="fas fa-poll"></span>
                            <small>All Result</small>
                        </a>
                    </li>
                    <li>
                       <a href="Feedbackmy.php">
                            <span class="fas fa-comment"></span>
                            <small>Feedback</small>
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
                <a class="navbar-brand" href="/ethiolearn/index.php">Ethio learn <span style="font-size: 1rem;">Instructor Profile</span></a>
                <div class="header-menu">
                
                    <div class="notify-icon">
                        <span class="fas fa-envelope"></span>
                        <span class="notify">4</span>
                    </div>
                    
                    <div class="notify-icon">
                        <span class="fas fa-bell"></span>
                        <span class="notify">3</span>
                    </div>
                    
                    <div class="user">
                        <div class="bg-img" style="background-image: url(img/1.jpeg)"></div>
                        
                        <span class="fas fa-power-off"></span>
                        <a href=" Logout.php"><span style="color:white" >Logout</span></a>
                    </div>
                </div>
            </div>
        </header>
        
</body>
</html>
