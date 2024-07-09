<?php
include_once("Header copy.php");
include_once("../DB_Files/db.php");

// Pagination settings
$itemsPerPage = isset($_GET['itemsPerPage']) ? (int)$_GET['itemsPerPage'] : 5; // Default items per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
$offset = ($page - 1) * $itemsPerPage; // Calculate offset

// Fetch and display paginated results
$output = '';
$sql = "SELECT er.*, s.stu_name 
        FROM exam_results er 
        JOIN students s ON er.student_id = s.stu_id
        LIMIT $offset, $itemsPerPage";
$result = mysqli_query($conn, $sql);
$totalItemsResult = mysqli_query($conn, "SELECT COUNT(result_id) AS total FROM exam_results");
$totalItemsRow = mysqli_fetch_assoc($totalItemsResult);
$totalPages = ceil($totalItemsRow['total'] / $itemsPerPage);

if (mysqli_num_rows($result) > 0) {
    $output .= '<div id="initialResults">
                    <table class="table">
                        <tr>
                            <th class="text-dark fw-bolder">Student name</th>
                            <th class="text-dark fw-bolder">Exam Category</th>
                            <th class="text-dark fw-bolder">Total Questions</th>
                            <th class="text-dark fw-bolder">Correct Answers</th>
                            <th class="text-dark fw-bolder">Wrong Answers</th>
                            <th class="text-dark fw-bolder">Exam Time</th>
                            <th class="text-dark fw-bolder">Mark</th>
                        </tr>';
    while ($row = mysqli_fetch_array($result)) {
        $output .= '<tr>
                        <td class="text-dark fw-bolder">' . $row["stu_name"] . '</td>
                        <td class="text-dark fw-bolder">' . $row["exam_category"] . '</td> 
                        <td class="text-dark fw-bolder">' . $row["total_questions"] . '</td>
                        <td class="text-dark fw-bolder">' . $row["correct_answers"] . '</td>
                        <td class="text-dark fw-bolder">' . $row["wrong_answers"] . '</td>
                        <td class="text-dark fw-bolder">' . $row["exam_time"] . '</td>
                        <td class="text-dark fw-bolder">' . $row["mark"] . '</td>
                    </tr>';
    }
    $output .= '</table></div>';
    // Add pagination controls at the end of $output
    $output .= '<nav aria-label="Page navigation example"><ul class="pagination">';
    if ($page > 1) {
        $prevPage = $page - 1;
        $output .= "<li class='page-item'><a class='page-link' href='?page=$prevPage&itemsPerPage=$itemsPerPage'>Previous</a></li>";
    }
    for ($i = 1; $i <= $totalPages; $i++) {
        $activeClass = $page == $i ? 'active' : '';
        $output .= "<li class='page-item $activeClass'><a class='page-link' href='?page=$i&itemsPerPage=$itemsPerPage'>$i</a></li>";
    }
    if ($page < $totalPages) {
        $nextPage = $page + 1;
        $output .= "<li class='page-item'><a class='page-link' href='?page=$nextPage&itemsPerPage=$itemsPerPage'>Next</a></li>";
    }
    $output .= '</ul></nav>';
} else {
    $output .= "<p class='text-dark p-2 fw-bolder'>Results Not Found. </p>";
}
?>
<style>
    .container{
        padding:5%;
        width:100%;
    }
</style>
<div class="container">
<div class="col-sm-11 mt-8 ">
    <div class="input-group mb-3">
        <select id="itemsPerPage" class="form-select">
            <option value="5">5 per page</option>
            <option value="10">10 per page</option>
            <option value="20">20 per page</option>
        </select>
        <input type="text" class="form-control" id="search_text" name="search_text" placeholder="Student Name">
    </div>
    <?php echo $output; ?> <!-- Display initial results and pagination here -->
    <div id="searchResults"></div>
</div>
</div>

<script src="/ethiolearn/js/jquery-3.3.1.min.js"></script>
<script>
$(document).ready(function(){
    var debounceTimer;

    $('#search_text').keyup(function(){
        clearTimeout(debounceTimer);
        var txt = $(this).val().trim(); // Trim the search text
        debounceTimer = setTimeout(function() {
            if(txt !== ''){
                $('#initialResults').hide();
                $('#searchResults').html('');
                $.ajax({
                    url: "student_exam_result_fetch.php",
                    type: "post",
                    data: {search: txt}, // Send the search term
                    dataType: "html", // Expect HTML response
                    success: function (data) {
                        $('#searchResults').html(data); // Display search results
                    }
                });
            } else {
                $('#initialResults').show();
                $('#searchResults').html('');
            }
        }, 500); // Adjust the delay as needed
    });
});
</script>
