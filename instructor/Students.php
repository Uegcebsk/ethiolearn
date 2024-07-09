<?php
include_once("../DB_Files/db.php");
include_once("Header copy.php");
if (!isset($_SESSION['l_id'])) {
    header('Location:Index.php');
    exit(); // Add exit to stop script execution
}

$lec_id = $_SESSION['l_id'];

// Query to retrieve courses taught by the instructor
$course_query = "SELECT course_id, course_name FROM course WHERE lec_id = '$lec_id'";
$course_result = mysqli_query($conn, $course_query);

// Check if the lecturer teaches more than one course
$course_count = mysqli_num_rows($course_result);

// Only display the select option if the lecturer teaches more than one course
if ($course_count > 1) {
?>
<div class="container" style="margin-top:5%;">
    <div class="col-sm-11 mt-5" style="padding-left:6%;">
        <div class="input-group mb-3">
            <input type="text" class="form-control" id="search_text" name="search_text" placeholder="Search by name or email">
            <select id="course_filter" class="form-select ml-2">
                <option value="">All Courses</option>
                <?php
                while ($row = mysqli_fetch_assoc($course_result)) {
                    echo "<option value='" . $row['course_id'] . "'>" . $row['course_name'] . "</option>";
                }
                ?>
            </select>
            <select id="items_per_page" class="form-select ml-2">
                <option value="5">5 per page</option>
                <option value="10">10 per page</option>
                <option value="20">20 per page</option>
            </select>
        </div>
        <div id="result"></div>
        <div id="pagination" class="mt-3"></div>
    </div>
</div>

<script src="/ethiolearn/js/jquery-3.3.1.min.js"></script>
<script>
    $(document).ready(function() {
        fetchStudents(); // Fetch students when the page loads

        var timer;

        // Trigger fetchStudents when user stops typing for 500ms
        $('#search_text').keyup(function() {
            clearTimeout(timer);
            timer = setTimeout(fetchStudents, 500);
        });

        function fetchStudents(page = 1) {
            var search_text = $('#search_text').val();
            var course_filter = $('#course_filter').val();
            var items_per_page = $('#items_per_page').val();
            $.ajax({
                url: "student_fetch.php",
                type: "post",
                data: {
                    search_text: search_text,
                    course_filter: course_filter,
                    page: page,
                    items_per_page: items_per_page
                },
                dataType: "html",
                success: function(data) {
                    $('#result').html(data);
                }
            });
        }

        $('#course_filter, #items_per_page').change(function() {
            fetchStudents();
        });

        $(document).on('click', '.pagination-link', function(event) {
            event.preventDefault();
            var page = $(this).data('page');
            fetchStudents(page);
        });
    });
</script>
<?php } else { ?>
<div class="container">
    <div class="col-sm-11 mt-5" style="padding-left:5%;">
        <div class="input-group mb-3">
            <input type="text" class="form-control" id="search_text" name="search_text" placeholder="Search by name or email">
            <select id="items_per_page" class="form-select ml-2">
                <option value="5">5 per page</option>
                <option value="10">10 per page</option>
                <option value="20">20 per page</option>
            </select>
        </div>
        <div id="result"></div>
        <div id="pagination" class="mt-3"></div>
    </div>
</div>

<script src="/ethiolearn/js/jquery-3.3.1.min.js"></script>
<script>
    $(document).ready(function() {
        fetchStudents(); // Fetch students when the page loads

        var timer;

        // Trigger fetchStudents when user stops typing for 500ms
        $('#search_text').keyup(function() {
            clearTimeout(timer);
            timer = setTimeout(fetchStudents, 500);
        });

        function fetchStudents(page = 1) {
            var search_text = $('#search_text').val();
            var items_per_page = $('#items_per_page').val();
            $.ajax({
                url: "student_fetch.php",
                type: "post",
                data: {
                    search_text: search_text,
                    page: page,
                    items_per_page: items_per_page
                },
                dataType: "html",
                success: function(data) {
                    $('#result').html(data);
                }
            });
        }

        $('#items_per_page').change(function() {
            fetchStudents();
        });

        $(document).on('click', '.pagination-link', function(event) {
            event.preventDefault();
            var page = $(this).data('page');
            fetchStudents(page);
        });
    });
</script>
<?php } ?>
