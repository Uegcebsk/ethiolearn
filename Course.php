<?php
include_once("Inc/Header.php");
include_once("DB_Files/db.php");
?>

<link rel="stylesheet" href="CSS/responsiveness.css">
<link rel="stylesheet" href="CSS/filter.css"> 
<script src="/ethiolearn/js/jquery-3.3.1.min.js"></script>
<style>
  /* CSS for Filter Section */

</style>

<section class="coursess">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="filter-container">
                    <div class="filter-header">
                        <h3>Filter</h3>
                    </div>
                    <div class="card-body">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="search_text" name="search_text" placeholder="Search Here">
                        </div>
                        <div class="categories">
                            <h4>Categories</h4>
                            <ul>
                                <?php
                                // Fetch categories from the database
                                $sql_categories = "SELECT * FROM categories";
                                $result_categories = $conn->query($sql_categories);
                                if ($result_categories->num_rows > 0) {
                                    while ($row_category = $result_categories->fetch_assoc()) {
                                        echo '<li class="category" data-category-id="' . $row_category['id'] . '">' . $row_category['catagorie_name'] . '</li>';
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                        <div class="filter-options">
                            <h4>Filter Options</h4>
                            <label><input type="checkbox" id="free_courses"> Free Courses</label>
                            <label><input type="checkbox" id="paid_courses"> Paid Courses</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <h2>All Courses</h2>

                <div id="courses-container" class="container courses__container">
                    <!-- Courses will be dynamically loaded here -->
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function () {
        // Load courses on page load
        fetchCourses();

        // Fetch courses when a category is clicked
        $(".category").click(function () {
            var categoryId = $(this).data("category-id");
            fetchCourses(categoryId);
        });

        // Fetch courses based on category, search text, and filters
        function fetchCourses(categoryId = '') {
            var freeCourses = $("#free_courses").prop("checked") ? 1 : 0;
            var paidCourses = $("#paid_courses").prop("checked") ? 1 : 0;
            $.ajax({
                url: "course_fetch.php",
                type: "post",
                data: {
                    category_id: categoryId,
                    search: $("#search_text").val(),
                    free_courses: freeCourses,
                    paid_courses: paidCourses
                },
                dataType: "html",
                success: function (data) {
                    $("#courses-container").html(data);
                }
            });
        }

        // Search courses when text is typed
        $('#search_text').keyup(function () {
            fetchCourses();
        });

        // Fetch courses when filter checkboxes are clicked
        $("#free_courses, #paid_courses").change(function () {
            fetchCourses();
        });
    });
</script>

<?php
include_once("Inc/Footer.php");
?>
