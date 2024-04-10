<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ethio learn</title>
    <link rel="stylesheet" href="/ethiolearn/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/ethiolearn/Inc/Header.css">
    <link rel="stylesheet" href="/ethiolearn/CSS/responsiveness.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.6/css/unicons.css">
    <style>
    /* Additional CSS for translation button */
    #google_translate_element {
        margin-left: 20px;
        display:flex;
    }

    /* Hide Google Translate icon */
    
    /* Styling for translation button */
    #google_translate_element button {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 10px 10px; /* Adjust padding for increased width and height */
        border-radius: 5px;
        font-size: 10px; /* Increase font size */
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    #google_translate_element button:hover {
        background-color: #0056b3;
    }

    /* Reduce space between language selector and button */
    #google_translate_element .goog-te-gadget-simple {
        margin-top: -5px;
    }

    /* Responsive styling */
    @media screen and (max-width: 768px) {
        #google_translate_element {
            margin-left: 10px;
            margin-top: 10px;
        }
    }
</style>

</head>

<body>
    <!-- Navigation Bar -->
    <nav>
        <div class="container nav__container">
            <a class="custom__links" href="index.php">
            <h4 class="title">
    <span style="color: green;">Ethio</span> 
    <span style="color: gold;">learn</span> 
    <br>
    <span style="color: red;">Educational Center</span>
</h4>
            </a>
            <div id="google_translate_element"></div> <!-- Translation button -->
            <ul class="nav__menu">
                <li>
                    <a class="custom__links" href="/ethiolearn/index.php">Home</a>
                </li>
                <li>
                    <a class="custom__links" href="/ethiolearn/Course.php">Courses</a>
                </li>
                <li>
                    <a class="custom__links" href="/ethiolearn/Blog.php">Blogs</a>
                </li>
                <li>
                    <a class="custom__links" href="/ethiolearn/forum/forum.php">forum</a>
                </li>

                <li>
                    <a class="custom__links" href="/ethiolearn/Contact.php">Contact</a>
                </li>
                <li>
                    <a class="custom__links" href="/ethiolearn/About.php">About</a>
                </li>
              
                <?php
                session_start();
                if(isset($_SESSION['stu_id'])){
                    echo'
                    <li>
                    <a class="custom__links" href="Users/Profile.php">Profile</a>
                </li>
                    ';
                }else{
                    echo '
                    <li>
                    <a class="custom__links joinBtn" href="Login&SignIn.php">Join For Free</a>
                </li>
                    ';
                }
                ?>
                
            </ul>
            <button id="open-menu-btn"><i class="uil uil-bars"></i></button>
            <button id="close-menu-btn"><i class="uil uil-multiply"></i></button>
        </div>
    </nav>

    <!-- Your existing scripts -->

    <!-- Google Translate API script -->
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en',
                includedLanguages: 'am,om', // Target languages (Amharic, Afan Oromo)
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                autoDisplay: false
            }, 'google_translate_element');
        }
    </script>

    <script>
        //change color nav
        window.addEventListener('scroll', () => {
            document.querySelector('nav').classList.toggle('window-scroll', window.scrollY > 0)
        })

        //show hide nav
        const menu = document.querySelector(".nav__menu");
        const menuBtn = document.querySelector("#open-menu-btn");
        const closeBtn = document.querySelector("#close-menu-btn");

        menuBtn.addEventListener('click', () => {
            menu.style.display = "flex";
            closeBtn.style.display = "inline-block";
            menuBtn.style.display = "none";
        })

        //close nav menu
        const closeNav = () => {
            menu.style.display = "none";
            closeBtn.style.display = "none";
            menuBtn.style.display = "inline-block";
        }
        closeBtn.addEventListener('click', closeNav)

        const changeColor = () => {
            $('ul > li > a').css('background-color', 'inherit')
            $(event.target).css("background-color", "red")
        }

        $('ul > li > a').on('click', changeColor)
    </script>
</body>

</html>
