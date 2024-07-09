<?php
include_once("../DB_Files/db.php");
include_once("Header.php");

// Check if user is not logged in, redirect to login page

?>

<script src="/ethiolearn/js/jquery-3.3.1.min.js"></script>

<div class="container" style="padding:4%;">
    <div class="col-sm-11 mt-5" style="padding-left:5%;">
        <div class="input-group mb-3">
            <input type="text" class="form-control" id="search_text" name="search_text" placeholder="Search by student name">
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
        fetchQuestions();

        function fetchQuestions(page = 1) {
            var search_text = $('#search_text').val();
            var course_filter = $('#course_filter').val();
            var itemsPerPage = $('#itemsPerPage').val();
            $.ajax({
                url: "forum_questions_fetch.php",
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

        $('#search_text').keyup(function() {
            fetchQuestions();
        });

        $('#search_btn').click(function(event) {
            event.preventDefault();
            fetchQuestions();
        });

        $('#itemsPerPage').change(function() {
            fetchQuestions();
        });

        $('#course_filter').change(function() {
            fetchQuestions();
        });

        $(document).on('click', '.pagination-link', function(event) {
            event.preventDefault();
            var page = $(this).data('page');
            fetchQuestions(page);
        });

        $(document).on('click', '.delete-question', function() {
            var questionId = $(this).data('id');
            if (confirm('Are you sure you want to delete this question?')) {
                $.ajax({
                    url: "forum_delete_questions.php",
                    type: "post",
                    data: { id: questionId },
                    success: function(response) {
                        alert(response);
                        fetchQuestions();
                    }
                });
            }
        });
    });
</script>

<?php
include_once("Footer.php");
?>
