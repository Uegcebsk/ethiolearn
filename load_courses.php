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
$limit = 3; // Number of items per page
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

    echo $output;
} else {
    echo "<p class='alert'>Course Not Found. </p>";
}
?>
<link rel="stylesheet" href="CSS/filter.css"> <!-- New CSS file for filter styles -->
