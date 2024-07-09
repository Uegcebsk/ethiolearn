<?php
include_once("Header.php");
include_once("../DB_Files/db.php");

// Function to get the course status text
function getCourseStatus($status) {
    return $status == 1 ? "Active" : "Inactive";
}

?>
<div class="container" style="padding:5%;">
    <div class="col-sm-12 mt-6">
        <p class="bg-dark text-white p-2">List of Courses</p>
        <?php
        $sql = "SELECT c.course_id, c.course_name, l.l_name AS instructor_name, c.status 
                FROM course c 
                JOIN lectures l ON c.lec_id = l.l_id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
        ?>
        <table class="table">
            <thead>
                <tr>
                    <th class="text-dark fw-bolder" scope="col">Course ID</th>
                    <th class="text-dark fw-bolder" scope="col">Name</th>
                    <th class="text-dark fw-bolder" scope="col">Instructor</th>
                    <th class="text-dark fw-bolder" scope="col">Status</th>
                    <th class="text-dark fw-bolder" scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php  
                while($row = $result->fetch_assoc()) { 
                    echo '<tr>';
                    echo '<th class="text-dark fw-bolder" scope="row">' . $row['course_id'] . '</th>';
                    echo '<td class="text-dark fw-bolder">' . $row['course_name'] . '</td>';
                    echo '<td class="text-dark fw-bolder">' . $row['instructor_name'] . '</td>';
                    echo '<td class="text-dark fw-bolder">' . getCourseStatus($row['status']) . '</td>';
                    echo '<td>';
                    echo '
                    <form action="editCourse.php" method="POST" class="d-inline">
                        <input type="hidden" name="id" value=' . $row["course_id"] . '>
                        <button type="submit" class="btn btn-info mr-3" name="view" value="View"><i class="uil uil-pen"></i></button>
                    </form>';
                    
                    // Display Activate or Deactivate button based on current status
                    if ($row['status'] == 1) {
                        echo '
                        <form action="" method="POST" class="d-inline">
                            <input type="hidden" name="id" value=' . $row["course_id"] . '>
                            <input type="hidden" name="status" value="0">
                            <button type="submit" class="btn btn-warning" name="deactivate" value="Deactivate"><i class="uil uil-power"></i></button>
                        </form>';
                    } else {
                        echo '
                        <form action="" method="POST" class="d-inline">
                            <input type="hidden" name="id" value=' . $row["course_id"] . '>
                            <input type="hidden" name="status" value="1">
                            <button type="submit" class="btn btn-success" name="activate" value="Activate"><i class="uil uil-power"></i></button>
                        </form>';
                    }
                    
                    echo '
                    <form action="" method="POST" class="d-inline" onsubmit="return confirmDelete();">
                        <input type="hidden" name="id" value=' . $row["course_id"] . '>
                        <button type="submit" class="btn btn-secondary" name="delete" value="Delete"><i class="uil uil-trash-alt"></i></button>
                    </form>
                    </td>
                    </tr>';
                } 
                ?>
            </tbody>
        </table>
        <?php 
        } else { 
            echo "<p class='text-dark p-2 fw-bolder'>Course Not Found. </p>"; 
        } 
        
        // Activate or Deactivate Course
        if(isset($_REQUEST['activate']) || isset($_REQUEST['deactivate'])){
            $courseId = $_REQUEST['id'];
            $status = $_REQUEST['status'];
            $sql="UPDATE course SET status=$status WHERE course_id=$courseId";
            if($conn->query($sql) === TRUE){
                echo '<meta http-equiv="refresh" content="0;URL=?updated"/>';
            } else {
                echo "Update Failed";
            }
        }

        // Delete Course
        if(isset($_REQUEST['delete'])){
            $sql="DELETE FROM course WHERE course_id={$_REQUEST['id']}";
            if($conn->query($sql)==TRUE){
                echo '<meta http-equiv="refresh" content="0;URL=?deleted"/>';
            } else {
                echo "Delete Failed";
            }
        }
        ?>
    </div>
</div>


<div class="container"style="text-align: center;
            margin-top: 10px">
        <a href="addCourse.php" class="btn mt-5 float-right bg-danger text-white">Add Course</a>
    </div>
<!-- JavaScript Confirmation Function -->
<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this course?");
    }
</script>

<?php
include_once("Footer.php");
?>
