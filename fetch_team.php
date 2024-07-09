<?php
include_once("DB_Files/db.php");

$limit = 4; // Number of team members per page
$page = isset($_POST['page']) ? $_POST['page'] : 1; // Define $page
$start = ($page - 1) * $limit;

$output = '';

$sql = "SELECT * FROM lectures LIMIT $start, $limit";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $output .= '
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
    echo $output;
} else {
    echo "<p>No team members found</p>";
}
?>
