<?php
include_once("Header copy.php");
include_once("../DB_Files/db.php");

// Function to display success or error messages
function displayMessage($msg, $type = 'success')
{
    return '<div class="alert alert-' . $type . ' col-sm-6 ml-5 mt-2 m-2">' . $msg . '</div>';
}

// Function to fetch course options for the select dropdown
function fetchCourseOptions()
{
    global $conn;
    $sql = "SELECT * FROM course";
    $result = $conn->query($sql);
    $options = '<option value="" selected disabled hidden>--Select Category--</option>';
    while ($row = $result->fetch_assoc()) {
        $options .= '<option value="' . $row['course_name'] . '">' . $row['course_name'] . '</option>';
    }
    return $options;
}

// Handling form submission to add exam category
if (isset($_POST['submit'])) {
    if (empty($_POST['category']) || empty($_POST['time'])) {
        $msg = displayMessage('All Fields Required', 'warning');
    } else {
        $category = $_POST['category'];
        $time = $_POST['time'];

        $sql = "INSERT INTO exam_category(exam_name,exam_time) VALUES ('$category','$time')";

        if ($conn->query($sql) === TRUE) {
            $msg = displayMessage('Category Added Successfully');
            echo '<meta http-equiv="refresh" content="3;"/>';
        } else {
            $msg = displayMessage('Category Added Failed', 'warning');
        }
    }
}
?>

<div class="col-sm-9 mt-5">
    <br><br>
    <div class="animated fadeIn">
        <div class="row">
            <!-- Add Category Form -->
            <div class="col-lg-6">
                <div class="card bg-transparent">
                    <form action="" method="POST">
                        <div class="card-header bg-dark text-light"><strong>Add Category</strong></div>
                        <?php if (isset($msg)) {
                            echo $msg;
                        } ?>
                        <div class="card-body card-block">
                            <div class="form-group">
                                <label for="category" class="form-control-label"><b>Add Category</b></label>
                                <select class="form-control" name="category" id="category">
                                    <?php echo fetchCourseOptions(); ?>
                                </select>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="time" class="form-control-label"><b>Time in Minutes</b></label>
                                <input placeholder="Time in Minute" type="text" id="time" name="time" class="form-control">
                            </div>
                            <div class="form-group">
                                <br>
                                <button type="submit" name="submit" class="btn btn-success">Add Exam</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Display Existing Categories -->
            <div class="col-lg-6">
                <div class="card bg-transparent">
                    <div class="card-header bg-dark">
                        <strong class="card-title text-light">Categories</strong>
                    </div>
                    <div class="card-body">
                        <?php
                        $sql = "SELECT * FROM exam_category";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            ?>
                            <table class="table ">
                                <thead class="">
                                <tr>
                                    <th class="text-dark fw-bolder" scope="col">ID</th>
                                    <th class="text-dark fw-bolder" scope="col">Category Name</th>
                                    <th class="text-dark fw-bolder" scope="col">Time</th>
                                    <th class="text-dark fw-bolder" scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php while ($row = $result->fetch_assoc()) {
                                    echo '<tr>';
                                    echo '<th class="text-dark fw-bolder" scope="row">' . $row['id'] . '</th>';
                                    echo '<td class="text-dark fw-bolder">' . $row['exam_name'] . '</td>';
                                    echo '<td class="text-dark fw-bolder">' . $row['exam_time'] . '</td>';
                                    echo '<td>';
                                    echo '
                                        <form action="editExam.php" method="POST" class="d-inline">
                                            <input type="hidden" name="id" value=' . $row["id"] . '>
                                            <button type="submit" class="btn btn-info mr-3" name="view" value="View"><i class="uil uil-pen"></i></button>
                                        </form>
                                        <form action="" method="POST" class="d-inline">
                                            <input type="hidden" name="id" value=' . $row["id"] . '>
                                            <button type="submit" class="btn btn-secondary" name="delete" value="Delete"><i class="uil uil-trash-alt"></i></button>
                                        </form>
                                    </td>
                                </tr>';
                                } ?>
                                </tbody>
                            </table>
                        <?php } else {
                            echo "<p class='text-dark p-2 fw-bolder'>Exam Not Found. </p>";
                        }

                        // Handling category deletion
                        if (isset($_POST['delete'])) {
                            $sql = "DELETE FROM exam_category WHERE id={$_POST['id']}";
                            if ($conn->query($sql) === TRUE) {
                                echo '<meta http-equiv="refresh" content="0;URL=?deleted"/>';
                            } else {
                                echo "Delete Failed";
                            }
                        }

                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
