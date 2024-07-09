<?php
include_once("ProfileHeader.php");
include_once("../DB_Files/db.php");
?>
<script src="/ethiolearn/js/jquery-3.3.1.min.js"></script>
<div class="container" style="padding:4%;">
    <div class="row justify-content-center">
        <div class="col-sm-11 mt-4">
            <p class="bg-dark text-white p-2 fw-bolder text-center">List of Quizzes</p>
            <br>
            <?php
            $studentId = $_SESSION['stu_id'];
            $sql = "SELECT ec.*, c.course_name 
                    FROM exam_category ec
                    INNER JOIN course c ON ec.course_id = c.course_id
                    INNER JOIN courseorder co ON c.course_id = co.course_id
                    WHERE co.stu_id = $studentId AND ec.active = 1 AND ec.assessment_type = 'quiz'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $category = $row["exam_name"];
                    $_SESSION["category"] = $category;
            ?>
                    <div class="mt-3">
                        <form action="" method="post">
                            <input name="test" type="button" class="btn btn-secondary border-5 form-control fw-bolder text-light" value="<?php echo $row['course_name'] . ' - ' . $row['exam_name']; ?>" onclick="set_exam_type_session('<?php echo $row['exam_name']; ?>');">
                        </form>
                    </div>
            <?php
                }
            } else {
                echo "<p class='text-center'>No quizzes found for the courses you have ordered.</p>";
            }
            ?>
            <br><br><br><br><br><br><br>
            <div class="text-center">
                <a href="OldResult.php" class="btn btn-danger border-5 fw-bolder text-light">Show Result</a>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function set_exam_type_session(exam_category) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                window.location = "Quiz.php";
            }
        };
        xmlhttp.open("GET", "forajax/set_exam_type_session.php?exam_category=" + exam_category, true);
        xmlhttp.send(null);
    }
</script>
