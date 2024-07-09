<?php
// Include your database connection file if needed
include_once("DB_Files/db.php");

$limit = 3; // Number of testimonials per page
$page = isset($_POST['page']) ? $_POST['page'] : 1; // Define $page
$start = ($page - 1) * $limit;

$output = '';

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

        $output .= '
            <div class="testimonial">
                <div class="avatar">
                    <img src="' . $n_img . '" alt="' . $s_name . '">
                </div>
                <div class="testimonial-content">
                    <h5>' . $s_name . '</h5>
                    <small>' . $c_name . '</small>
                    <p>' . $f_content . '</p>
                </div>
            </div>';
    }
} else {
    $output = "<p>No approved testimonials found</p>";
}

echo $output;
?>
