<?php
include_once("Header copy.php");
include_once("../DB_Files/db.php");

if (isset($_REQUEST['reqUpdate'])) {
    // Retrieve course ID from the request
    $cid = $_REQUEST['id'];

    if (empty($_REQUEST['course_name']) || empty($_REQUEST['course_desc']) || empty($_REQUEST['course_duration']) || empty($_REQUEST['course_lessons'])) {
        $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2">All Fields Required</div>';
    } else {
        $cname = $_REQUEST['course_name'];
        $cdesc = $_REQUEST['course_desc'];
        $cduration = $_REQUEST['course_duration'];
        $clessons = $_REQUEST['course_lessons'];

        // Update the course details in the database
        $sql = "UPDATE course SET course_name='$cname', course_desc='$cdesc', course_duration='$cduration', course_lessons='$clessons' WHERE course_id='$cid'";
        
        // Debugging: Echo out the SQL query
        echo "SQL Query: $sql<br>";

        if ($conn->query($sql) === TRUE) {
            $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2">Updated Successfully</div>';
            echo "<script>setTimeout(()=>{window.location.href='Course.php';},300);</script>";
        } else {
            // Handle SQL query errors
            $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2">Update Failed: ' . $conn->error . '</div>';
        }
    }
}
?>
<style>
    .container {
        padding: 5%;
    }
</style>

<div class="container display-content-center ">
<div class="col-sm-11 mt-5 jumbotron">
    <h3 class="text-center">Edit Course Details</h3>
    <?php
    if (isset($_REQUEST['view'])) {
        $sql = "SELECT * FROM course WHERE course_id={$_REQUEST['id']}";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
    }



    ?>
    <form action="" method="POST" enctype="multipart/form-data">
        <br>
        <?php if (isset($msg)) {
            echo $msg;
        } ?><br>
       
        <div class="form-group">
            <label for="course_name">Course Name</label>
            <input type="text" id="course_name" name="course_name" class="form-control" value="<?php if (isset($row['course_name'])) {
                                                                                                    echo $row['course_name'];
                                                                                                } ?>">
        </div><br>
        <div class="form-group">
            <label for="course_desc">Course Description</label>
            <input id="course_desc" name="course_desc" class="form-control" value="<?php if (isset($row['course_desc'])) {
                echo $row['course_desc'];
            } ?>">
            </input>
        </div>
        <br>
        <div class="form-group">
            <label for="course_duration">Course Duration</label>
            <input type="text" id="course_duration" name="course_duration" class="form-control" value="<?php if (isset($row['course_duration'])) {
                                                                                                            echo $row['course_duration'];
                                                                                                        } ?>">
        </div>
        <br>
        <div class="form-group">
            <label for="course_lessons">Course Lessons</label>
            <input type="text" id="course_lessons" name="course_lessons" class="form-control" value="<?php if (isset($row['course_lessons'])) {
                                                                                                            echo $row['course_lessons'];
                                                                                                        } ?>">
        </div>
        <br>
        <div class="form-group">
            <label for="course_img">Course Image</label>
            <br>
            <img style="height: 300px; width:400px;" src="<?php if (isset($row['course_img'])) {
                            echo $row['course_img'];
                        } ?>" alt="" class="img-thumbnail">
            <!-- <input type="file" id="course_img" name="course_img" class="form-control-file"> -->
        </div>
        <br>
        <div class="text-center">
            <button class="btn btn-danger" type="submit" id="reqUpdate" name="reqUpdate">Update</button>
            <a href="Course.php" class="btn btn-secondary">Close</a>
        </div>
</div>


    </form>
</div>


<?php
include_once("Footer.php");
?>