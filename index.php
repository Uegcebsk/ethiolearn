<?php
include_once("Inc/Header.php");
include_once("DB_Files/db.php");
?>

<link rel="stylesheet" href="CSS/Home.css">


<link rel="stylesheet" href="CSS/responsiveness.css">
<link scr="/ethiolearn/js/testimonial.js>
<!-- Swiper JS -->
<script src="></script>

<!-- Header -->
<style>
img {
    width: 100%;
    display: block;
    object-fit: cover;
}

.pagination a.active {
    background-color: #333;
}
.testimonials {
    padding: 20px;
}

.testimonial-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}

.testimonial {
    width: calc(33.33% - 20px);
    margin-bottom: 20px;
    padding: 15px;
    border-radius: 10px;
    background-color: #f8f9fa;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.testimonial:hover {
    transform: translateY(-5px);
}

.avatar img {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 10px;
}

.testimonial-content h5 {
    margin: 0;
    font-size: 18px;
    font-weight: bold;
}

.testimonial-content small {
    font-size: 14px;
    color: #999;
}

.testimonial-content p {
    margin: 10px 0 0;
}

.pagination {
    margin-top: 20px;
    text-align: center;
}

.pagination a {
    display: center;
    width: 20px;
    height: 20px;
    background-color: #ddd;
    border-radius: 50%;
    margin: 0 5px;
    line-height: 20px;
    text-align: center;
    color: black;
    text-decoration: none;
}

.pagination a.active {
    background-color: #4CAF50;
    color: white;
}
.section{
    padding:50%;
}

</style>
 <!-- Header -->
 <header style="height: 70vh;">
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
                    <a href="signup.php">
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
        // SQL query to fetch popular courses based on the number of enrollments and status = 1
        $sql = "SELECT c.course_id, c.course_name, c.course_price, c.course_img, l.l_name,
                       COUNT(co.course_id) AS enrollments
                FROM course c 
                INNER JOIN lectures l ON c.lec_id = l.l_id 
                LEFT JOIN courseorder co ON c.course_id = co.course_id
                WHERE c.status = 1
                GROUP BY c.course_id
                ORDER BY enrollments DESC
                LIMIT 6"; // Change this limit according to your needs
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
                            <h5>By <?php echo $row['l_name']; ?></h5>
                            <p>Enrollments: <?php echo $row['enrollments']; ?></p>
                            <a href="CourseDetails.php?course_id=<?php echo $course_id; ?>" class="button">Learn More</a>
                        </div>
                    </a>
                </article>
                <?php
            }
        } else {
            echo "<p>No popular courses found.</p>";
        }
        ?>
    </div>
</section>
<section class="testimonials">
    <h2>Student Reviews</h2>
    <div class="testimonial-container">
        <?php
        $limit = 3; // Number of testimonials per page
        $page = isset($_POST['page']) ? $_POST['page'] : 1; // Define $page
        $start = ($page - 1) * $limit;

        $sql = "SELECT COUNT(*) AS total FROM feedback WHERE approved = 1";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $total_feedback = $row['total'];
        $total_pages = ceil($total_feedback / $limit);

        $sql = "SELECT s.stu_name, s.stu_occ, s.stu_img, f.f_content, c.course_name
        FROM students AS s 
        JOIN feedback AS f ON s.stu_id = f.stu_id 
        JOIN course AS c ON f.course_id = c.course_id
        WHERE f.approved = 1
        LIMIT $start, $limit";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Display testimonials
                $s_img = $row['stu_img'];
                $n_img = str_replace('..', '.', $s_img);
                $s_name = $row['stu_name'];
                $c_name = $row['course_name'];
                $f_content = $row['f_content'];
                ?>
                <div class="testimonial">
                    <div class="avatar">
                        <img src="<?php echo $n_img ?>" alt="<?php echo $s_name ?>">
                    </div>
                    <div class="testimonial-content">
                        <h5><?php echo $s_name ?></h5>
                        <small><?php echo $c_name ?></small>
                        <p><?php echo $f_content ?></p>
                    </div>
                </div>
                <?php
            }
        } else {
            // No testimonials found message
            echo "<p>No approved testimonials found</p>";
        }
        ?>
    </div>
    <!-- Pagination for testimonials -->
    <div class="pagination" id="testimonial-pagination">
        <?php
        for ($i = 1; $i <= $total_pages; $i++) {
            echo '<a href="javascript:void(0);" onclick="showTestimonials(' . $i . ')"';
            if ($i === $page) {
                echo ' class="active"';
            }
            echo '>' . $i . '</a>';
        }
        ?>
    </div>
</section>

<script src="/ethiolearn/js/jquery-3.3.1.min.js"></script>

<script>
    function showTestimonials(page) {
        var testimonialsContainer = document.querySelector('.testimonial-container');
        var paginationBubbles = document.querySelectorAll('#testimonial-pagination a');

        // Clear existing testimonials
        testimonialsContainer.innerHTML = '';

        // Fetch testimonials for the selected page via AJAX
        $.ajax({
            url: 'fetch_testimonial.php',
            method: 'POST',
            data: { page: page },
            success: function(response) {
                // Display fetched testimonials
                testimonialsContainer.innerHTML = response;

                // Update active state of pagination bubbles
                paginationBubbles.forEach(function(bubble, index) {
                    if (index + 1 === page) {
                        bubble.classList.add('active');
                    } else {
                        bubble.classList.remove('active');
                    }
                });
            }
        });
    }
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
        var backgrounds = ['/ethiolearn/Img/home.jpg', '/ethiolearn/Img/home2.jpg', '/ethiolearn/Img/bg1.jpg'];
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
            <h3>Automated Certificate</h3>
        </div>

        <div class="fea-box">
            <i class="uil uil-trophy"></i>
            <h3>Multi language</h3>
        </div>

        <div class="fea-box">
            <i class="uil uil-clipboard-alt"></i>
            <h3>Descussion Forums</h3>
        </div>
    </div>
</section>

<?php
include_once("Inc/Footer.php");
?>