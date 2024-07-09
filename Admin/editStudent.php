<?php
include_once("Header.php");
include_once("../DB_Files/db.php");

if (isset($_REQUEST['id'])) {
    $stu_id = $_REQUEST['id'];
    
    // Fetch student details
    $sql = "SELECT * FROM students WHERE stu_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $stu_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stu_email = $row["stu_email"]; // Retrieving student's email for enrolled courses
    } else {
        echo "<script>alert('Student not found!');</script>";
        echo "<script>setTimeout(()=>{window.location.href='Students.php';},0);</script>";
    }
}

if (isset($_POST['reqUpdate'])) {
    $stu_name = $_POST['stu_name'];
    $stu_email = $_POST['stu_email'];
    $stu_pass = $_POST['stu_pass'];
    $stu_occ = $_POST['stu_occ'];
    $stu_id = $_POST['stu_id'];

    // Update student details
    $sql = "UPDATE students SET stu_name=?, stu_email=?, stu_pass=?, stu_occ=? WHERE stu_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $stu_name, $stu_email, $stu_pass, $stu_occ, $stu_id);

    if ($stmt->execute()) {
        echo "<script>alert('Student details updated successfully!');</script>";
        echo "<script>setTimeout(()=>{window.location.href='Students.php';},0);</script>";
    } else {
        echo "<script>alert('Failed to update student details!');</script>";
    }
}

if (isset($_POST['delete'])) {
    $stu_id = $_POST['stu_id'];

    // Remove foreign key constraints
    $sql_remove_constraints = "SET FOREIGN_KEY_CHECKS=0";
    $conn->query($sql_remove_constraints);

    // Delete student
    $sql_delete_student = "DELETE FROM students WHERE stu_id=?";
    $stmt_delete_student = $conn->prepare($sql_delete_student);
    $stmt_delete_student->bind_param("i", $stu_id);

    if ($stmt_delete_student->execute()) {
        echo "<script>alert('Student deleted successfully!');</script>";
        echo "<script>setTimeout(()=>{window.location.href='Students.php';},0);</script>";
    } else {
        echo "<script>alert('Failed to delete student!');</script>";
    }

    // Reapply foreign key constraints
    $sql_apply_constraints = "SET FOREIGN_KEY_CHECKS=1";
    $conn->query($sql_apply_constraints);
}
?>
    <div class="container" style="padding:7%;">
<div class="col-sm-12 mt-5 jumbotron">
        <h3 class="text-center" style="padding:7%;">Update Student Details</h3>
        <form action="" method="POST" enctype="multipart/form-data">
            <br>
            <div class="form-group">
                <label for="stu_id">ID</label>
                <input type="text" id="stu_id" name="stu_id" class="form-control" value="<?php echo $row['stu_id']; ?>" readonly>
            </div><br>
            <div class="form-group">
                <label for="stu_name">Name</label>
                <input type="text" id="stu_name" name="stu_name" class="form-control" value="<?php echo isset($row['stu_name']) ? $row['stu_name'] : ''; ?>">
            </div><br>
            <div class="form-group">
                <label for="stu_email">Email</label>
                <input type="email" id="stu_email" name="stu_email" class="form-control" value="<?php echo isset($row['stu_email']) ? $row['stu_email'] : ''; ?>">
            </div><br>
            <div class="form-group">
                <label for="stu_pass">Password</label>
                <input type="password" id="stu_pass" name="stu_pass" class="form-control" value="<?php echo isset($row['stu_pass']) ? $row['stu_pass'] : ''; ?>">
            </div><br>
            <div class="form-group">
                <label for="stu_occ">Occupation</label>
                <input type="text" id="stu_occ" name="stu_occ" class="form-control" value="<?php echo isset($row['stu_occ']) ? $row['stu_occ'] : ''; ?>">
            </div><br>
            <div class="text-center">
                <button class="btn btn-danger" type="submit" name="reqUpdate">Update</button>
                <a href="Students.php" class="btn btn-secondary">Close</a>
                <button type="submit" name="delete" class="btn btn-warning" onclick="return confirm('Are you sure you want to delete this student?')">Delete</button>
            </div>
        </form>
    </div>
</div>

<!-- Display student's enrolled courses -->
<div class="container" style="padding:7%;">
<div class="col-sm-12 mt-5 jumbotron">
    <h5 class="text-center fw-bolder">Student Enrolled Courses Details</h5>
    <br>
    <?php
    $sql_enrolled_courses = "SELECT * FROM courseorder WHERE stu_id=?";
    $stmt_enrolled_courses = $conn->prepare($sql_enrolled_courses);
    $stmt_enrolled_courses->bind_param("i", $stu_id);
    $stmt_enrolled_courses->execute();
    $result_enrolled_courses = $stmt_enrolled_courses->get_result();

    if ($result_enrolled_courses->num_rows > 0) {
    ?>
        <table class="table text-center">
            <thead>
                <tr>
                    <th class="text-dark" scope="col">Course ID</th>
                    <th class="text-dark" scope="col">Course Name</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row_enrolled_courses = $result_enrolled_courses->fetch_assoc()) {
                    echo '<tr>';
                    echo '<th class="text-dark" scope="row">' . $row_enrolled_courses['course_id'] . '</th>';
                    echo '<td class="text-dark">' . $row_enrolled_courses['course_name'] . '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    <?php
    } else {
        echo "<p class='text-dark p-2 fw-bolder'>Student Enrolled Courses Not Found.</p>";
    }
    ?>
</div>

<?php
include_once("Footer.php");
?>
