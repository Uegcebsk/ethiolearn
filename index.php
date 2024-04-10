<?php
include_once("Inc/Header.php");
include_once("DB_Files/db.php");
?>

<link rel="stylesheet" href="CSS/Home.css">
<link rel="stylesheet" href="CSS/responsiveness.css">
<link scr="/ethiolearn/js/testimonial.js>
<!-- Swiper JS -->
<script src=""></script>

<!-- Header -->
<style>
    .testimonials {
    padding: 50px 0;
    background-color: #f9f9f9;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 15px;
}

.testimonials h2 {
    text-align: center;
    margin-bottom: 30px;
}

.testimonial-list {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}

.testimonial {
    width: calc(33.33% - 30px);
    margin: 15px;
    background-color: #fff;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.avatar img {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    margin-bottom: 15px;
}

.testimonial-content h5 {
    margin-bottom: 10px;
    font-size: 18px;
}

.testimonial-content small {
    color: #888;
}

.testimonial-content p {
    font-size: 16px;
    line-height: 1.6;
    color: #555;
}
/* CSS for Navigation Bubbles */
.navigation-bubbles {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.bubble {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background-color: #ccc;
    margin: 0 5px;
    cursor: pointer;
}

.bubble.active {
    background-color: #333;
}


</style>
 <!-- Header -->
 <header>
        <button class="prev" onclick="prevImage()">&#10094;</button>
        <button class="next" onclick="nextImage()">&#10095;</button>
        <div class="container header__container">
            <div class="header__left">
                <h1>Grow your Skills to Advance your Career path</h1>
                <p>Education is the place where learning begins .</p>
                <?php
                if (isset($_SESSION['stu_id'])) {
                    echo '
                    <a href="Users/Profile.php">
                    <button class="button"> Visit Profile
                    </button></a>
                    ';
                } else {
                    echo '
                    <a href="Login&SignIn.php">
                    <button class="button">Get Started
                    </button></a>
                    ';
                }
                ?>
            </div>
            <div class="header__right">
            </div>
        </div>
    </header>
<!-- Categories -->
<section class="categories reveal">
    <div class="container categories__container">
        <div class="categories__left">
            <h1>Categories</h1>
            <?php
            // Define or fetch the dynamic content
            $academy_description = "Students can learn their programming languages very easily with good knowledge capacity from Imperial Academy.";
            ?>
            <p><?php echo $academy_description; ?></p>
        </div>
        <div class="categories__right">
            <?php
            // Fetch categories from the database
            $sql = "SELECT * FROM categories";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                // Loop through each category and display dynamically
                while ($row = $result->fetch_assoc()) {
                    echo "<article class='category'>";
                    echo "<span class='category__icon'><i class='" . $row['icon'] . "'></i></span>";
                    echo "<h5>" . $row['catagorie_name'] . "</h5>";
                    echo "<p>" . $row['description'] . "</p>";
                    echo "</article>";
                }
            } else {
                echo "No categories found";
            }
            ?>
        </div>
    </div>
</section>

<section class="courses reveal">
    <h2>Our Popular Courses</h2>
    <div class="container courses__container">
        <?php
        $sql = "SELECT c.course_id, c.course_name, c.course_price, c.course_img, l.l_name FROM course c INNER JOIN lectures l ON c.lec_id = l.l_id ORDER BY RAND() LIMIT 6";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $course_id = $row['course_id'];
                ?>
                <article class="course">
                    <a href="CourseDetails.php?course_id=<?php echo $course_id; ?>">
                        <div class="course__image">
                            <img src="<?php echo str_replace('..', '.', $row['course_img']); ?>" alt="">
                            <div class="price-badge">Birr <?php echo $row['course_price']; ?></div>
                        </div>
                        <div class="course__info">
                            <h3><?php echo $row['course_name']; ?></h3>
                            <h5 style="underline:none">By<?php echo $row['l_name']; ?></h5>
                            <a href="CourseDetails.php?course_id=<?php echo $course_id; ?>" class="button">Learn More</a>
                        </div>
                    </a>
                </article>
                <?php
            }
        }
        ?>
    </div>
</section>



<section class="testimonials">
    <div class="container">
        <h2>Students Reviews</h2>
        <div class="testimonial-list">
            <?php
            // Modified SQL query to fetch only approved testimonials
            $sql = "SELECT s.stu_name, s.stu_occ, s.stu_img, f.f_content 
                    FROM students AS s 
                    JOIN feedback AS f ON s.stu_id = f.stu_id 
                    WHERE f.approved = 1"; // Assuming '1' denotes approved testimonials
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $s_img = $row['stu_img'];
                    $n_img = str_replace('..', '.', $s_img);
                    $s_name = $row['stu_name'];
                    $s_occ = $row['stu_occ'];
                    $f_content = $row['f_content'];
                    ?>
                    <div class="testimonial">
                        <div class="avatar">
                            <img src="<?php echo $n_img ?>" alt="">
                        </div>
                        <div class="testimonial-content">
                            <h5><?php echo $s_name ?></h5>
                            <small><?php echo $s_occ ?></small>
                            <p><?php echo $f_content ?></p>
                        </div>
                    </div>
                <?php
                }
            } else {
                echo "<p>No approved testimonials found</p>";
            }
            ?>
        </div>
        <div class="navigation-bubbles"></div> <!-- Container for navigation bubbles -->
    </div>
</section>

<script>
    // JavaScript to generate navigation bubbles
    document.addEventListener("DOMContentLoaded", function() {
        const testimonialList = document.querySelector(".testimonial-list");
        const navigationBubbles = document.querySelector(".navigation-bubbles");

        // Get the number of testimonials
        const numTestimonials = testimonialList.children.length;

        // Generate and append navigation bubbles
        for (let i = 0; i < numTestimonials; i++) {
            const bubble = document.createElement("span");
            bubble.classList.add("bubble");
            navigationBubbles.appendChild(bubble);
        }

        // Make the first bubble active initially
        navigationBubbles.children[0].classList.add("active");

        // Add event listener to each bubble for navigation
        navigationBubbles.addEventListener("click", function(event) {
            const bubbleIndex = Array.from(this.children).indexOf(event.target);
            if (bubbleIndex !== -1) {
                // Remove active class from all bubbles
                Array.from(this.children).forEach(bubble => {
                    bubble.classList.remove("active");
                });

                // Add active class to the clicked bubble
                this.children[bubbleIndex].classList.add("active");

                // Scroll to the corresponding testimonial
                testimonialList.children[bubbleIndex].scrollIntoView({
                    behavior: "smooth",
                    block: "start"
                });
            }
        });
    });
</script>



<script>


    //Animation Scroll
function reveal() {
    var reveals = document.querySelectorAll(".reveal");

    for (var i = 0; i < reveals.length; i++) {
        var windowHeight = window.innerHeight;
        var elementTop = reveals[i].getBoundingClientRect().top;
        var elementVisible = 150;

        if (elementTop < windowHeight - elementVisible) {
            reveals[i].classList.add("active");
        } else {
            reveals[i].classList.remove("active");
        }
    }
}
var currentIndex = 0;
        var backgrounds = ['/ethiolearn/Img/des.jpg', '/ethiolearn/Img/des2.jpg', '/ethiolearn/Img/des3.jpg'];
        var header = document.querySelector('header');

        function nextImage() {
            currentIndex = (currentIndex + 1) % backgrounds.length;
            header.style.backgroundImage = 'url(' + backgrounds[currentIndex] + ')';
            header.classList.toggle('alt' + currentIndex);
        }

        function prevImage() {
            currentIndex = (currentIndex - 1 + backgrounds.length) % backgrounds.length;
            header.style.backgroundImage = 'url(' + backgrounds[currentIndex] + ')';
            header.classList.toggle('alt' + currentIndex);
        }

        // Automatically change image every 5 seconds
        setInterval(nextImage, 5000);
        

window.addEventListener("scroll", reveal);
</script>

<section id="features" class="reveal">
    <h1>Awesome Features</h1>
    <div class="fea-base">
        <div class="fea-box">
            <i class="uil uil-graduation-cap"></i>
            <h3>Scholarship Facility</h3>
        </div>

        <div class="fea-box">
            <i class="uil uil-trophy"></i>
            <h3>Global Recognition</h3>
        </div>

        <div class="fea-box">
            <i class="uil uil-clipboard-alt"></i>
            <h3>Enroll Course</h3>
        </div>
    </div>
</section>

<?php
include_once("Inc/Footer.php");
?>