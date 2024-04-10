<?php
include_once("Header copy.php");
include_once("../DB_Files/db.php");

// Pagination settings
$itemsPerPage = isset($_GET['itemsPerPage']) ? (int)$_GET['itemsPerPage'] : 5; // Default items per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
$offset = ($page - 1) * $itemsPerPage; // Calculate offset

// Fetch and display paginated results
$output = '';
$sql = "SELECT * FROM exam_result LIMIT $offset, $itemsPerPage";
$result = mysqli_query($conn, $sql);
$totalItemsResult = mysqli_query($conn, "SELECT COUNT(id) AS total FROM exam_result");
$totalItemsRow = mysqli_fetch_assoc($totalItemsResult);
$totalPages = ceil($totalItemsRow['total'] / $itemsPerPage);

if (mysqli_num_rows($result) > 0) {
    $output .= '<div id="initialResults">
                    <table class="table">
                        <tr>
                            <th class="text-dark fw-bolder">Student Email</th>
                            <th class="text-dark fw-bolder">Exam Category</th>
                            <th class="text-dark fw-bolder">Mark</th>
                            <th class="text-dark fw-bolder">Exam Time</th>
                        </tr>';
    while ($row = mysqli_fetch_array($result)) {
        $output .= '<tr>
                        <td class="text-dark fw-bolder">' . $row["email"] . '</td>
                        <td class="text-dark fw-bolder">' . $row["exam_type"] . '</td> 
                        <td class="text-dark fw-bolder">' . $row["mark"] . '</td>
                        <td class="text-dark fw-bolder">' . $row["exam_time"] . '</td>
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
        <input type="text" class="form-control" id="search_text" name="search_text" placeholder="Quiz Category">
    </div>
    <?php echo $output; ?> <!-- Display initial results and pagination here -->
    <div id="searchResults"></div>
</div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
$(document).ready(function(){
    $('#itemsPerPage').change(function(){
        var itemsPerPage = $(this).val();
        var currentQuery = window.location.search;
        var newQuery = updateQueryStringParameter(currentQuery, 'itemsPerPage', itemsPerPage);
        window.location.search = newQuery;
    });

    function updateQueryStringParameter(uri, key, value) {
        var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
        var separator = uri.indexOf('?') !== -1 ? "&" : "?";
        if (uri.match(re)) {
            return uri.replace(re, '$1' + key + "=" + value + '$2');
        }
        else {
            return uri + separator + key + "=" + value;
        }
    }

    var debounceTimer;
    $('#search_text').keyup(function(){
        clearTimeout(debounceTimer);
        var txt = $(this).val();
        debounceTimer = setTimeout(function() {
            if(txt != ''){
                $('#initialResults').hide();
                $('#searchResults').html('');
                $.ajax({
                    url: "result_fetch.php",
                    type: "post",
                    data: {search:txt},
                    dataType: "text",
                    success: function (data) {
                        $('#searchResults').html(data);
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
