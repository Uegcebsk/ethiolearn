<?php
include_once("Header copy.php");
include_once("../DB_Files/db.php");

// Assuming $lec_id contains the instructor's ID
$lec_id = $_SESSION['l_id'];

?>
<div class="container">
<div class="col-sm-9 mt-5" style="align-item:Center";>
    <p class="bg-dark text-white p-2">List of Feedback</p>
    <?php
    // Fetch feedback for courses taught by the instructor
   // Fetch feedback along with replies
$sql = "SELECT f.*, r.reply_content 
        FROM feedback f 
        LEFT JOIN replies r ON f.f_id = r.feedback_id 
        WHERE f.lec_id = '$lec_id'";
$result = $conn->query($sql);

// Display feedback and reply form
if ($result->num_rows > 0) {
    echo '<table class="table">';
    echo '<thead>
            <tr>
                <th class="text-dark fw-bolder" scope="col">Student ID</th>
                <th class="text-dark fw-bolder" scope="col">Feedback</th>
                <th class="text-dark fw-bolder" scope="col">Reply</th>
                <th class="text-dark fw-bolder" scope="col">Action</th>
            </tr>
          </thead>';
    echo '<tbody>';
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<th class="text-dark fw-bolder" scope="row">' . $row['stu_id'] . '</th>';
        echo '<td class="text-dark fw-bolder">' . $row['f_content'] . '</td>';
        echo '<td class="text-dark fw-bolder">' . $row['reply_content'] . '</td>';
        echo '<td class="text-dark fw-bolder">';
        echo '
            <form action="" method="POST" class="d-inline">
                <input type="hidden" name="id" value=' . $row["f_id"] . '>
                <button type="submit" class="btn btn-secondary" name="delete" value="Delete">
                    <i class="uil uil-trash-alt"></i>
                </button>
            </form>
            <form action="" method="POST" class="d-inline">
                <input type="hidden" name="id" value=' . $row["f_id"] . '>
                <button type="submit" class="btn btn-secondary" name="reply" value="Reply">
                    Reply
                </button>
            </form>
        </td>
        </tr>';
    }
    echo '</tbody>';
    echo '</table>';
} else {
    echo "<p class='text-dark p-2 fw-bolder'>Feedback Not Found. </p>";
}

// Handle reply submission
if (isset($_REQUEST['reply'])) {
    // Assuming you have a form for reply submission
    // Retrieve reply content from form
    $replyContent = $_POST['reply_content'];
    $feedbackId = $_POST['id'];

    // Insert reply into the database
    $sql = "INSERT INTO replies (feedback_id, reply_content) VALUES ('$feedbackId', '$replyContent')";
    if ($conn->query($sql) === TRUE) {
        echo "Reply added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


// Handle delete submission
if (isset($_REQUEST['delete'])) {
    // Assuming you have a form for reply submission
    // Retrieve reply content from form
    $feedbackId = $_POST['id'];

    // Insert reply into the database
    $sql = "DELETE FROM replies WHERE feedback_id = '$feedbackId'";
    if ($conn->query($sql) === TRUE) {
        echo "Reply deleted successfully";
    } else { 
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
<form action="" method="POST" class="d-inline">
    <input type="hidden" name="id" value='<?php echo $row["f_id"]; ?>'>
    <input type="text" name="reply_content" placeholder="Enter your reply">
    <button type="submit" class="btn btn-primary" name="reply" value="Reply">Submit Reply</button>
</form>

</div>
</div>

<?php
include_once("Footer.php");
?>
