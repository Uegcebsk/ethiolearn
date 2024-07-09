<?php
include_once("../DB_Files/db.php");

if(isset($_POST['search'])) {
    $output = '';
    $search = mysqli_real_escape_string($conn, $_POST['search']);
    $sql = "SELECT qr.*, s.stu_name 
            FROM quiz_result qr 
            JOIN students s ON qr.stu_id = s.stu_id
            WHERE s.stu_name LIKE '%$search%'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $output .= '<div id="searchResultsTable">
                        <table class="table">
                            <tr>
                                <th class="text-dark fw-bolder">Student name</th>
                                <th class="text-dark fw-bolder">Exam Category</th>
                                <th class="text-dark fw-bolder">Mark</th>
                                <th class="text-dark fw-bolder">Exam Time</th>
                            </tr>';
        while ($row = mysqli_fetch_array($result)) {
            $output .= '<tr>
                            <td class="text-dark fw-bolder">' . $row["stu_name"] . '</td>
                            <td class="text-dark fw-bolder">' . $row["exam_type"] . '</td> 
                            <td class="text-dark fw-bolder">' . $row["mark"] . '</td>
                            <td class="text-dark fw-bolder">' . $row["exam_time"] . '</td>
                        </tr>';
        }
        $output .= '</table></div>';
    } else {
        $output = "<p class='text-dark p-2 fw-bolder'>No Results Found. </p>";
    }

    echo $output;
}
?>
