<?php
include_once("Header.php");
include_once("../DB_Files/db.php");
?>

<script src="/ethiolearn/js/jquery-3.3.1.min.js"></script>

<div class="container" style="padding:4%;">
    <div class="col-sm-11 mt-5" style="padding-left:5%;">
        <div class="input-group mb-3">
            <input type="text" class="form-control" id="search_text" name="search_text" placeholder="Search by name or email">
            <select id="course_filter" class="form-select ml-2">
                <option value="">All Courses</option>
                <?php
                // Fetch courses from the database
                $sql = "SELECT * FROM course";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['course_id'] . "'>" . $row['course_name'] . "</option>";
                }
                ?>
            </select>
            <select id="itemsPerPage" class="form-select ml-2">
                <option value="5">5 per page</option>
                <option value="10">10 per page</option>
                <option value="20">20 per page</option>
            </select>
            <button id="search_btn" class="btn btn-primary ml-2">Search</button>
        </div>
        <div id="result"></div>
    </div>
</div>

<script>
    $(document).ready(function() {
        fetchStudents();

        // Function to fetch students based on search term, course filter, items per page, and page number
        function fetchStudents(page = 1) {
            var search_text = $('#search_text').val();
            var course_filter = $('#course_filter').val();
            var itemsPerPage = $('#itemsPerPage').val();
            $.ajax({
                url: "student_fetch.php",
                type: "post",
                data: {
                    search_text: search_text,
                    course_filter: course_filter,
                    itemsPerPage: itemsPerPage,
                    page: page
                },
                dataType: "html",
                success: function(data) {
                    $('#result').html(data);
                }
            });
        }

        // Search and pagination on keyup
        $('#search_text').keyup(function() {
            fetchStudents();
        });

        // Handle search button click
        $('#search_btn').click(function(event) {
            event.preventDefault();
            fetchStudents();
        });

        // Handle items per page change
        $('#itemsPerPage').change(function() {
            fetchStudents();
        });

        // Handle course filter change
        $('#course_filter').change(function() {
            fetchStudents();
        });

        // Handle pagination links click
        $(document).on('click', '.pagination-link', function(event) {
            event.preventDefault();
            var page = $(this).data('page');
            fetchStudents(page);
        });
    });
</script>

<?php
include_once("Footer.php");
?>
