<?php
include_once("Header.php");
include_once("../DB_Files/db.php");

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $answer = $_POST['answer'];
    $approved = isset($_POST['approve']) ? 1 : 0;
    
    $sql = "UPDATE contact SET approved = $approved, answer = '$answer' WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        $msg = "<div class='alert alert-success'>Question updated successfully.</div>";
    } else {
        $msg = "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }

    // Fetch the updated data
    $sql = "SELECT * FROM contact WHERE id=$id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}

if (isset($_REQUEST['view'])) {
    $sql = "SELECT * FROM contact WHERE id={$_REQUEST['id']}";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}
?>

<div class="container" style="padding: 6%;">
    <div class="col-sm-12 mt-5 jumbotron">
        <h3 class="text-center">View Message</h3>
        <?php if (isset($msg)) { echo $msg; } ?><br>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="contact_id">ID</label>
                <input type="text" id="contact_id" name="id" class="form-control" value="<?php if (isset($row['id'])) { echo $row['id']; } ?>" readonly>
            </div><br>
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" class="form-control" value="<?php if (isset($row['f_name'])) { echo $row['f_name']; } ?>" readonly>
            </div><br>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" class="form-control" value="<?php if (isset($row['l_name'])) { echo $row['l_name']; } ?>" readonly>
            </div><br>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" class="form-control" value="<?php if (isset($row['email'])) { echo $row['email']; } ?>" readonly>
            </div><br>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" name="message" class="form-control" rows="5" readonly><?php if (isset($row['msg'])) { echo $row['msg']; } ?></textarea>
            </div><br>
            <div class="form-group">
                <label for="answer">Answer</label>
                <textarea id="answer" name="answer" class="form-control" rows="5" required><?php if (isset($row['answer'])) { echo $row['answer']; } ?></textarea>
            </div><br>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="approve" name="approve" value="1" <?php if (isset($row['approved']) && $row['approved']) { echo 'checked'; } ?>>
                <label class="form-check-label" for="approve">Approve</label>
            </div><br>
            <div class="text-center">
                <button type="submit" name="update" class="btn btn-primary">Save Changes</button>
                <a href="Messages.php" class="btn btn-secondary">Close</a>
            </div>
        </form>
    </div>
</div>

<?php
include_once("Footer.php");
?>
