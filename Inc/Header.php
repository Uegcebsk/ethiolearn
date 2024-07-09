<?php
                    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ethio learn</title>
  
    <link rel="stylesheet" href="/ethiolearn/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/ethiolearn/Inc/Header.css">
    <link rel="stylesheet" href="/ethiolearn/Inc/Header2.css">

    <link rel="stylesheet" href="/ethiolearn/CSS/responsiveness.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.6/css/unicons.css">
   
    <style>
        /* Styles for improved design */
        
       
    </style>
</head>

<body>
    <!-- Navigation Bar -->
    <nav>
        <div class="containerr nav__container">
            <a class="custom__links" href="index.php">
                <h4 class="title">
                    <span style="color: #90EE90;">Ethio</span>
                    <span style="color: gold;">learn</span>
                    <br>
                    <span style="color: red;">Educational Center</span>
                </h4>
            </a>

            <div class="google-translate-container">
                <div id="google_translate_element"></div>
            </div>

            <ul class="nav__menu">
                <li><a class="custom__links" href="/ethiolearn/index.php">Home</a></li>
                <li><a class="custom__links" href="/ethiolearn/Course.php">Courses</a></li>
                <li><a class="custom__links" href="/ethiolearn/Blog.php">Blogs</a></li>
                <li><a class="custom__links" href="/ethiolearn/forum/forum.php">Forum</a></li>
                <li><a class="custom__links" href="/ethiolearn/Contact.php">Contact</a></li>
                <li><a class="custom__links" href="/ethiolearn/About.php">About</a></li>
                <?php
                    if (isset($_SESSION['stu_id'])) {
                        echo '<li><a class="custom__links" href="/ethiolearn/Users/dashbord.php">Profile</a></li>';
                    } else {
                        echo '<li><a class="custom__links joinBtn" href="/ethiolearn/login.php">Join For Free</a></li>';
                    }
                ?>
            </ul>
            <button id="open-menu-btn" class="toggle-icon">&#9776;</button>
            <button id="close-menu-btn" class="toggle-icon">&times;</button>
        </div>
    </nav>

    <script>
        // Toggle menu on mobile
        const menu = document.querySelector(".nav__menu");
        const menuBtn = document.querySelector("#open-menu-btn");
        const closeBtn = document.querySelector("#close-menu-btn");

        menuBtn.addEventListener('click', () => {
            menu.classList.toggle('active');
        });

        closeBtn.addEventListener('click', () => {
            menu.classList.remove('active');
        });

        // Change color of navigation links on click
        const links = document.querySelectorAll('.custom__links');

        links.forEach(link => {
            link.addEventListener('click', () => {
                links.forEach(link => link.classList.remove('active'));
                link.classList.add('active');
            });
        });

        // Change navigation color on scroll
        window.addEventListener('scroll', () => {
            const nav = document.querySelector('nav');
            nav.classList.toggle('window-scroll', window.scrollY > 0);
        });
    </script>
    
    <!-- Google Translate Script -->
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en',
                autoDisplay: 'true',
                includedLanguages: 'en,am,om',
                layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL
            }, 'google_translate_element');
        }
    </script>
            <script src='//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit' async></script>
</body>

</html>
