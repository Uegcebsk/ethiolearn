<?php
include_once("Inc/Header.php");
include_once("DB_Files/db.php");

// Fetch total number of courses
$sqlCourses = "SELECT COUNT(*) as total_courses FROM course";
$resultCourses = $conn->query($sqlCourses);
$rowCourses = $resultCourses->fetch_assoc();
$totalCourses = $rowCourses['total_courses'];

// Fetch total number of students
$sqlStudents = "SELECT COUNT(*) as total_students FROM students where email_verified =1";
$resultStudents = $conn->query($sqlStudents);
$rowStudents = $resultStudents->fetch_assoc();
$totalStudents = $rowStudents['total_students'];

// Fetch total number of awards
$sqlAwards = "SELECT COUNT(*) as total_awards FROM certificates";
$resultAwards = $conn->query($sqlAwards);
$rowAwards = $resultAwards->fetch_assoc();
$totalAwards = $rowAwards['total_awards'];

// Get current date
$currentDate = date("F Y"); // Format: Month Year (e.g., May 2024)
?>

<link rel="stylesheet" href="CSS/About.css">
<link rel="stylesheet" href="CSS/responsiveness.css">
<style>
    /* Pagination Styles */
.pagination {
    margin-top: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.pagination a {
    width: 20px;
    height: 20px;
    background-color: #ddd;
    border-radius: 50%;
    display: inline-block;
    text-align: center;
    line-height: 20px;
    color: black;
    text-decoration: none;
    margin: 0 5px;
    transition: background-color 0.3s;
}

.pagination a.active {
    background-color: #4CAF50;
    color: white;
}

/* Adjust active bubble position */
.pagination a.active {
    transform: scale(1.5); /* Increase size of active bubble */
    z-index: 1; /* Ensure active bubble is on top */
    margin-top: -5px; /* Adjust vertical position */
}

</style>
<!-- Achievements -->
<section class="about__achievements">
    <div class="container about__achievements-container">
        <div class="about__achievements-left">
            <img src="Img/about achievements.svg" alt="">
        </div>
        <div class="about__achievements-right">
            <h1>Achievements</h1>
            <p>Our global community and our course catalog get bigger every day. Check out our latest numbers as of <?php echo $currentDate; ?>.</p>
            <div class="achievements__cards">
                <article class="achievements__card">
                    <span class="achievement__icon">
                        <i class="uil uil-video"></i>
                    </span>
                    <h3><?php echo $totalCourses; ?></h3>
                    <p>Courses</p>
                </article>

                <article class="achievements__card">
                    <span class="achievement__icon">
                        <i class="uil uil-users-alt"></i>
                    </span>
                    <h3><?php echo $totalStudents; ?></h3>
                    <p>Students</p>
                </article>

                <article class="achievements__card">
                    <span class="achievement__icon">
                        <i class="uil uil-trophy"></i>
                    </span>
                    <h3><?php echo $totalAwards; ?></h3>
                    <p>Certified Students</p>
                </article>
            </div>
        </div>
    </div>
</section>

<!-- Team -->
<section class="team reveal">
    <h2>Meet Our Team</h2>
    <div class="container team__container">
        <?php
        $limit = 4; // Number of team members per page
        $page = isset($_POST['team_page']) ? $_POST['team_page'] : 1; // Define $team_page
        $start = ($page - 1) * $limit;

        $sql = "SELECT COUNT(*) AS total FROM lectures";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $total_members = $row['total'];
        $total_pages = ceil($total_members / $limit);

        $sql = "SELECT * FROM lectures LIMIT $start, $limit";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '
                <article class="team__member">
                    <div class="team__member-image">
                        <img src="' . str_replace('..', '.', $row['l_img']) . '" alt="">
                    </div>
                    <div class="team__member-info">
                        <h4>' . $row['l_name'] . '</h4>
                        <p>' . $row['l_design'] . '</p>
                    </div>
                </article>';
            }
        } else {
            echo "<p>No team members found</p>";
        }
        ?>
    </div>
    <!-- Pagination for team members -->
    <div class="pagination" id="team-pagination">
        <?php
        for ($i = 1; $i <= $total_pages; $i++) {
            echo '<a href="javascript:void(0);" onclick="showTeamMembers(' . $i . ')"';
            if ($i === $page) {
                echo ' class="active"';
            }
            echo '>' . $i . '</a>';
        }
        ?>
    </div>
</section>


<?php
include_once("DB_Files/db.php");
?>

<!--FAQ-->
<section class="faqs reveal">
    <h2>Frequently Asked Questions</h2>
    <div class="container faqs__container">
        <?php
        // Fetch approved FAQs from the contact table
        $sql = "SELECT * FROM contact WHERE approved = 1 AND answer IS NOT NULL";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <article class="faq">
                    <div class="faq__icon"><i class="uil uil-plus"></i></div>
                    <div class="question__answer">
                        <h4><?php echo htmlspecialchars($row['msg']); ?></h4>
                        <p><?php echo htmlspecialchars($row['answer']); ?></p>
                    </div>
                </article>
                <?php
            }
        } else {
            echo "<p>No FAQs available at the moment.</p>";
        }
        ?>
    </div>
</section>


<script src="/ethiolearn/js/jquery-3.3.1.min.js"></script>

<script>
    function loadTeamMembers(page) {
    $.ajax({
        url: 'fetch_team.php',
        type: 'POST',
        data: { page: page },
        success: function(response) {
            $('.team__container').html(response);
            updatePagination(page);
        }
    });
}
const faqs = document.querySelectorAll('.faq');

faqs.forEach(faq => {
    faq.addEventListener('click', () => {
        faq.classList.toggle('open');

        //change icon
        const icon = faq.querySelector('.faq__icon i');
        if (icon.className === 'uil uil-plus') {
            icon.className = "uil uil-minus";
        } else {
            icon.className = "uil uil-plus";
        }
    });
});

function updatePagination(page) {
    $('#team-pagination').empty(); // Clear existing bubbles
    for (var i = 1; i <= <?php echo $total_pages; ?>; i++) {
        var bubble = $('<a></a>').attr('href', 'javascript:void(0);').attr('onclick', 'loadTeamMembers(' + i + ')');
        if (page == i) {
            bubble.addClass('active');
        }
        $('#team-pagination').append(bubble);
    }
}

// Initial load
loadTeamMembers(1);

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

window.addEventListener("scroll", reveal);
</script>

<?php
include_once("Inc/Footer.php");
?>