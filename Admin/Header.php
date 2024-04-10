<?php 
// if(!isset($_SESSION)){
//     session_start();
// }

session_start();
if (!isset($_SESSION['id'])) {
    header('Location:Index.php');
}
?>

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Ethio Learn</title>
    <link rel="stylesheet" href="/ethiolearn/instructor\/style.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.6/css/unicons.css">
     <!-- Bootstrap  -->
     <link rel="stylesheet" href="/ethiolearn/bootstrap/css/bootstrap.min.css">
   
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
                <li class="nav-item">
                            <a href="Dashboard.php" class="nav-link">
                                <i class="uil uil-tachometer-fast-alt"></i>
                                <b>Dashboard</b>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="add_catagories.php" class="nav-link">
                                <i class="uil uil-accessible-icon-alt"></i>
                                <b>add course catagories</b>
                            </a>
                        </li>


                        <li class="nav-item">
                            <a href="Course.php" class="nav-link">
                                <i class="uil uil-accessible-icon-alt"></i>
                                <b>Courses</b>
                            </a>
                        </li>



                        <li class="nav-item">
                            <a href="Lesson.php" class="nav-link">
                                <i class="uil uil-accessible-icon-alt"></i>
                                <b>Lessons</b>
                            </a>
                        </li>


                        <li class="nav-item">
                            <a href="Students.php" class="nav-link">
                                <i class="uil uil-user"></i>
                                <b>Students</b>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="Exam.php" class="nav-link">
                            <i class="uil uil-plus"></i>
                                <b>Add Quiz Category</b>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="AddQuizz.php" class="nav-link">
                            <i class="uil uil-plus-circle"></i>
                                <b>Add Quiz</b>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="Result.php" class="nav-link">
                            <i class="uil uil-file-landscape-alt"></i>
                                <b>All Result</b>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="AddCertificate.php" class="nav-link">
                            <i class="uil uil-award-alt"></i>
                                <b>Add Certificate</b>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="Lectures.php" class="nav-link">
                            <i class="uil uil-user-plus"></i>
                                <b>Lectures</b>
                            </a>
                        </li>


                        <li class="nav-item">
                            <a href="Blog.php" class="nav-link">
                            <i class="uil uil-blogger-alt"></i>
                                <b>Blogs</b>
                            </a>
                        </li>


                        <li class="nav-item">
                            <a href="SellReport.php" class="nav-link">
                                <i class="uil uil-analysis"></i>
                                <b>Report</b>
                            </a>
                        </li>


                        <li class="nav-item">
                            <a href="PaymentStatus.php" class="nav-link">
                                <i class="uil uil-invoice"></i>
                                <b>Payment Status</b>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="Feedback.php" class="nav-link">
                                <i class="uil uil-feedback"></i>
                                <b>Feedback</b>
                            </a>
                        </li>


                        <li class="nav-item">
                            <a href="Messages.php" class="nav-link">
                            <i class="uil uil-envelope-add"></i>
                                <b>Messages</b>
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
</div>
    
    <div class="main-content">
        
        <header>
            <div class="header-content">
                <label for="menu-toggle">
                    <span class="las la-bars"></span>
                </label>
                <a class="navbar-brand" href="/ethiolearn/index.php">Ethio learn <span style="font-size: 1rem;">Instructor Profile</span></a>
                <div class="header-menu">
                
                    <div class="notify-icon">
                        <span class="las la-envelope"></span>
                        <span class="notify">4</span>
                    </div>
                    
                    <div class="notify-icon">
                        <span class="las la-bell"></span>
                        <span class="notify">3</span>
                    </div>
                    
                    <div class="user">
                        <div class="bg-img" style="background-image: url(img/1.jpeg)"></div>
                        
                        <span class="las la-power-off"></span>
                        <a href="Logout.php" class="nav-link">
                    </div>
                </div>
            </div>
        </header>
        
      

            


            
