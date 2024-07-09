<?php
include_once("DB_Files/db.php");

$output = '';
$categoryCondition = '';
if(isset($_POST["category_id"]) && $_POST["category_id"] != '') {
    $categoryCondition = "AND category_id = " . $_POST["category_id"];
}

$priceCondition = '';
if(isset($_POST["free_courses"]) && $_POST["free_courses"] == 1) {
    $priceCondition = "AND course_price = 0";
} elseif(isset($_POST["paid_courses"]) && $_POST["paid_courses"] == 1) {
    $priceCondition = "AND course_price > 0";
}

// Pagination variables
$limit = 4; // Number of items per page
$page = (isset($_POST['page']) && is_numeric($_POST['page'])) ? $_POST['page'] : 1;
$start = ($page - 1) * $limit;

// Fetching courses with status = 1 and applying conditions
$sql = "SELECT c.*, l.l_name, COUNT(co.stu_id) AS enrolled_students
        FROM course c
        LEFT JOIN lectures l ON c.lec_id = l.l_id
        LEFT JOIN courseorder co ON c.course_id = co.course_id
        WHERE c.status = 1 AND c.course_name LIKE '%" . $_POST["search"] . "%' $categoryCondition $priceCondition
        GROUP BY c.course_id
        LIMIT $start, $limit";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $output .= '<div class="courses__container">';
    while ($row = mysqli_fetch_array($result)) {
        $id = $row["course_id"];
        $output .= '
            <div class="course-container">
                <article class="course">
                    <a href="CourseDetails.php?course_id=' . $id . '">
                        <div class="course__image">
                            <img src="' . str_replace('..', '.', $row['course_img']) . '" alt="">
                            <div class="price-badge">Birr ' . $row['course_price'] . '</div> <!-- Price badge added -->
                        </div>
                        <div class="course__info">
                            <h3>' . $row['course_name'] . '</h3>
                            <h5>Lecture: ' . $row['l_name'] . '</h5>
                            <h5>Enrolled Students: ' . $row['enrolled_students'] . '</h5>
                            <a href="CourseDetails.php?course_id=' . $id . '" class="button">Learn More</a>
                        </div>
                    </a>
                </article>
            </div>';
    }
    $output .= '</div>';

    // Pagination
    $sql = "SELECT COUNT(*) AS total FROM course WHERE status = 1 $categoryCondition $priceCondition";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $total_pages = ceil($row['total'] / $limit);

    $pagination = '<div class="pagination" id="pagination">';
    for ($i = 1; $i <= $total_pages; $i++) {
        $pagination .= '<a href="javascript:void(0);" onclick="loadCourses(' . $i . ')"';
        if ($page == $i) {
            $pagination .= ' class="active"';
        }
        $pagination .= '></a>';
    }
    $pagination .= '</div>';

    // Output both courses and pagination
    echo '<section class="courses">' . $output . '</section>' . $pagination;
} else {
    echo "<p class='alert'>Course Not Found. </p>";
}
?>
<script src="/ethiolearn/js/jquery-3.3.1.min.js"></script>
<script>
function loadCourses(page) {
    var search = "<?php echo isset($_POST['search']) ? $_POST['search'] : '' ?>";
    var categoryId = "<?php echo isset($_POST['category_id']) ? $_POST['category_id'] : '' ?>";
    var freeCourses = "<?php echo isset($_POST['free_courses']) ? $_POST['free_courses'] : '' ?>";
    var paidCourses = "<?php echo isset($_POST['paid_courses']) ? $_POST['paid_courses'] : '' ?>";

    $.ajax({
        url: 'load_courses.php',
        type: 'POST',
        data: {
            page: page,
            search: search,
            category_id: categoryId,
            free_courses: freeCourses,
            paid_courses: paidCourses
        },
        success: function(response) {
            $('.courses').html(response);
            updatePagination(page);
        }
    });
}

function updatePagination(page) {
    $('#pagination').empty(); // Clear existing bubbles
    for (var i = 1; i <= <?php echo $total_pages; ?>; i++) {
        var bubble = $('<a></a>').attr('href', 'javascript:void(0);').attr('onclick', 'loadCourses(' + i + ')');
        if (page == i) {
            bubble.addClass('active');
        }
        $('#pagination').append(bubble);
    }
}
</script>
<style>
    .courses__container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        padding: 10px;
    }

    .course-container {
        width: 300px !important;
        margin-bottom: 20px;
        box-sizing: border-box;
        padding: 10px;
    }

    .course {
        display: flex;
        flex-direction: column;
        border: 1px solid transparent;
        background: var(--color-light);
        transition: var(--transition);
        border-radius: 10px;
        overflow: hidden;
        height: 100%; /* Ensure course fills its container */
        box-sizing: border-box; /* Include padding and border in the element's total width and height */
    }

    .course:hover {
        background: transparent;
        border-color: var(--color-black);
    }

    .course__image {
        position: relative;
        width: 100%;
        height: 180px; /* Fixed height for all images */
        overflow: hidden;
    }

    .course__image img {
        width: 100%;
        height: 100%; /* Ensure the image fills the container */
        object-fit: cover; /* Cover the container without stretching the image */
        transition: transform 0.3s ease;
    }

    .course__image:hover img {
        transform: scale(1.1);
    }

    .price-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: rgb(254, 195, 31);
        color: #fff;
        padding: 5px 10px;
        border-radius: 5px;
        font-weight: bold;
    }

    .course__info {
        padding: 1.5rem;
        background-color: rgb(255, 177, 20);
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-sizing: border-box; /* Ensure padding is included in total height */
    }

    .course__info h3,
    .course__info h5 {
        margin-top: 0;
        margin-bottom: 0.5rem;
        font-size: 1.2rem;
        text-decoration: none !important;
    }

    .course__info h5 {
        margin-bottom: 1rem;
        font-size: 1rem;
    }

    .course__info .button {
        display: inline-block;
        background-color: green;
        color: #fff;
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s ease;
        align-self: flex-start;
    }

    .course__info .button:hover {
        background-color: var(--color-primary-dark);
    }

    /* Pagination Styles */
    .pagination {
        margin-top: 0px;
        display: center;
        justify-content: center;
        align-items: center;
        padding:30%;
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

