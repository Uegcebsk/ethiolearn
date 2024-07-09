<?php
include_once("Header copy.php");
include_once("../DB_Files/db.php");

if (!isset($_SESSION['l_id'])) {
    header("Location: index.php");
    exit();
}

// Function to display feedback messages
function displayMessage($msg, $type = 'success')
{
    return '<div class="alert alert-' . $type . ' col-sm-6 ml-5 mt-2 m-2">' . $msg . '</div>';
}

?>
<style>
    .container{
        padding:2%;
    }
</style>
<div class="container">
<div class="col-sm-11 mt-5">
    <br><br>
    <div class="animated fadeIn">
        <div class="col-lg-12">
            <div class="card bg-transparent">
                <div class="card-header bg-dark text-light">
                    <strong class="card-title">Categories</strong>
                </div>
                <div class="card-body">
                    <?php
                    $instructorId = $_SESSION['l_id'];
                    $sql = "SELECT ec.id, ec.exam_name, ec.assessment_type, ec.exam_time 
                            FROM exam_category ec
                            INNER JOIN course c ON ec.course_id = c.course_id
                            WHERE c.lec_id = '$instructorId' AND ec.assessment_type = 'quiz'";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                    ?>
                        <table class="table table-borderless">
                            <thead class="">
                                <tr>
                                    <th class="text-dark fw-bolder" scope="col">ID</th>
                                    <th class="text-dark fw-bolder" scope="col">Category Name</th>
                                    <th class="text-dark fw-bolder" scope="col">Assessment type</th>
                                    <th class="text-dark fw-bolder" scope="col">Time</th>
                                    <th class="text-dark fw-bolder" scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    echo '<tr>';
                                    echo '<th class="text-dark fw-bolder" scope="row">' . $row['id'] . '</th>';
                                    echo '<td class="text-dark fw-bolder">' . $row['exam_name'] . '</td>';
                                    echo '<td class="text-dark fw-bolder">' . $row['assessment_type']. '</td>';
                                    echo '<td class="text-dark fw-bolder">' . $row['exam_time'] . '</td>';
                                    echo '<td>';
                                    if($row['assessment_type'] === 'exam') {
                                        echo '<form action="add Exam.php" method="POST" class="d-inline">';
                                    } else {
                                        echo '<form action="addQuestion.php" method="POST" class="d-inline">';
                                    }
                                    echo '<input type="hidden" name="id" value=' . $row["id"] . '>';
                                    echo '<button type="submit" class="btn btn-info mr-3" name="view" value="View"><i class="fas fa-plus"></i></button>';
                                    echo '</form>';
                                    echo '</td>';
                                    echo '</tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    <?php } else {
                        echo "No Exam Categories found for this instructor.";
                    } ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php
include_once("Footer.php");
?>
