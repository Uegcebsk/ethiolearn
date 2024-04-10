<?php
include_once("ProfileHeader.php");
include_once("../DB_Files/db.php");

$stu_email = $_SESSION['stu_email'];
?>
<style>
    .row{
         padding-left: 10%;
         margin-top: 3%;
    }
</style>

<div class="row justify-content-center">
        <div class="col-sm-10 mt-4">
        <div class="jumbotron">
            <p class="bg-dark text-white p-2 fw-bolder">Enrolled Courses</p>
            <br>
            <?php
            if (isset($stu_email)) {
                $sql = "SELECT co.order_id, c.course_id, c.course_name, c.course_duration, c.course_desc, c.course_img, l.l_name AS lecturer_name FROM courseorder AS co JOIN course AS c ON c.course_id = co.course_id JOIN lectures AS l ON c.lec_id = l.l_id WHERE co.stu_email = '$stu_email'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
            ?>
                        <div class="bg-white mb-3 p-2 rounded">
                            <div class="row">
                                <div class="col-sm-3 m-2">
                                    <img class="card-img-top mt-2 text-light" src="<?php echo $row['course_img']; ?>" alt="">
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <div class="card-body">
                                        <p class="card-text text-dark fw-bolder card-header bg-light"><?php echo $row['course_name']; ?></p>
                                        <br>
                                        <small class="card-text text-dark">Duration (Hours): <?php echo $row['course_duration'] ?></small> <br/>
                                        <small class="card-text text-dark">Instructor: <?php echo $row['lecturer_name'] ?></small>
                                        <br> 
                                        <a href="WatchList.php?course_id=<?php echo $row['course_id']?>" class="btn mt-5 float-right bg-danger text-white">Watch Course</a>
                                        <a href="materials.php?course_id=<?php echo $row['course_id']?>" class="btn mt-5 float-right bg-danger text-white">course materials</a>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
            <?php
                    }
                }
            }
            ?>
        </div>
    </div>
</div>
