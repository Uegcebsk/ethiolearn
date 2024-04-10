<?php
include_once("../DB_Files/db.php");
include_once("header copy.php");
?>
<style>
    .container{
        padding: 5%;
    }
</style>

<div class="d-flex justify-content-center"> <!-- Added div to center content -->
    <div class="container" >
        <p>List of Courses</p>
        <?php
        // Assuming $instructor_id holds the ID of the intended instructor
        $l_id = $_SESSION['l_id']; // Assuming you store the logged-in instructor's ID in session
        $sql = "SELECT c.* FROM course c JOIN lectures l ON c.lec_id = l.l_id WHERE l.l_id = $l_id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
        ?>
        <table class="table">
            <thead>
                <tr>
                    <th class="text-dark fw-bolder" scope="col">Course ID</th>
                    <th class="text-dark fw-bolder" scope="col">Name</th>
                    <th class="text-dark fw-bolder" scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php  while($row=$result->fetch_assoc()){ 
                echo '<tr>';
                    echo '<th class="text-dark fw-bolder" scope="row">'.$row['course_id'].'</th>';
                    echo '<td class="text-dark fw-bolder">'.$row['course_name'].'</td>';
                   
                    echo '<td>';
                    echo '
                    <form action="editCourse.php" method="POST" class="d-inline">
                    <input type="hidden" name="id" value='.$row["course_id"].'>
                    <button type="submit" class="btn btn-info mr-3" name="view" value="View"><i class="fas fa-eye"></i></button>
                    </form>
                    <form action="add material.php" method="POST" enctype="multipart/form-data" class="d-inline"> <!-- Modified action attribute -->
                    <input type="hidden" name="course_id" value="'.$row['course_id'].'"> <!-- Added hidden input field -->
                        <button type="submit" class="btn btn-secondary" name="add_material" value="Add Material"> <!-- Changed button name -->
                            Add Material <!-- Changed button text -->
                        </button>
                        </form>
                    </td>
                </tr>';
                } ?>
            </tbody>
        </table>
        <?php }else{ echo "<p class='text-dark p-2 fw-bolder'>No courses found for this instructor.</p>";} 
        
        if(isset($_REQUEST['delete'])){
            $sql="DELETE FROM course WHERE course_id={$_REQUEST['id']}";
            if($conn->query($sql)==TRUE){
                echo '<meta http-equiv="refresh" content="0;URL=?deleted"/>';
            }else{
                echo "Delete Failed";
            }
        }
        ?>
    </div>
</div> <!-- Close the centered div -->

<?php
include_once("Footer.php");
?>
