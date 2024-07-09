<?php
include_once("Header copy.php");
include_once("../DB_Files/db.php");

$receiver_id = ''; // Initialize receiver ID for students or admin
$receiver_type = ''; // Initialize receiver type

// Check if receiver ID and type are provided in the URL
if (isset($_GET['receiver_id']) && isset($_GET['receiver_type'])) {
    $receiver_id = $_GET['receiver_id'];
    $receiver_type = $_GET['receiver_type'];
}

if (isset($_REQUEST['sendMessageBtn'])) {
    $receiver_id = $_POST['receiver_id']; // Get receiver ID from form
    $receiver_type = $_POST['receiver_type']; // Get receiver type from form
    $subject = $_POST['subject'];
    $content = $_POST['content'];

    if (empty($receiver_id) || empty($receiver_type) || empty($subject) || empty($content)) {
        $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2">All Fields Required</div>';
    } else {
        // Insert message into database
        $sender_id = $_SESSION['l_id']; // Assume sender is the logged-in lecturer
        
        // Determine sender type
        $sender_type = 'lecturer';
        
        // No need for receiver_name column in the INSERT query

        $sql = "INSERT INTO message (sender_id, sender_type, receiver_id, receiver_type, subject, content) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        
        // Adjusted data types in bind_param
        $stmt->bind_param("isisss", $sender_id, $sender_type, $receiver_id, $receiver_type, $subject, $content);
        
        if ($stmt->execute()) {
            $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2">Message Sent Successfully</div>';
            // Redirect to inbox or dashboard
            echo "<script>setTimeout(()=>{window.location.href='messagee.php';},300);</script>";
        } else {
            $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2">Failed to send message</div>';
        }

        $stmt->close();
    }
}

// Function to retrieve the admin's name
function getAdminName($conn) {
    $sql = "SELECT username FROM admin";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['username'];
    } else {
        return '';
    }
}

// Function to retrieve a student's name
function getStudentName($conn, $student_id) {
    $sql = "SELECT stu_name FROM students WHERE stu_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['stu_name'];
    } else {
        return '';
    }
}

// Get lecturer students
function getLecturerStudents($conn, $lecturer_id)
{
    $sql = "SELECT DISTINCT s.stu_id, s.stu_name 
            FROM courseorder co
            INNER JOIN students s ON co.stu_id = s.stu_id
            INNER JOIN course c ON co.course_id = c.course_id
            WHERE c.lec_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $lecturer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $students = [];
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
    return $students;
}

$lecturer_id = $_SESSION['l_id']; // Get lecturer ID from session
$students = getLecturerStudents($conn, $lecturer_id);
?>

<div class="container" style="padding:6%;">
    <div class="col-sm-12 mt-5 jumbotron">
        <h3 class="text-center">Compose Message</h3>
        <form action="" method="POST" id="sendMessageForm">
            <br>
            <?php if (isset($msg)) { echo $msg; } ?><br>
            <div class="form-group">
                <label for="receiver_type">Recipient Type</label>
                <select name="receiver_type" id="receiver_type" class="form-control">
                    <option value="student" <?php if ($receiver_type === 'student') echo 'selected'; ?>>Student</option>
                    <option value="admin" <?php if ($receiver_type === 'admin') echo 'selected'; ?>>Admin</option>
                </select>
            </div><br>
            <div class="form-group" id="receiver_id_container">
                <label for="receiver_id">Recipient Name</label>
                <!-- This select input will be dynamically populated with options -->
                <select name="receiver_id" id="receiver_id" class="form-control">
                    <?php if ($receiver_type === 'student') {
                        foreach ($students as $student) { ?>
                            <option value="<?php echo $student['stu_id']; ?>" <?php if ($receiver_id == $student['stu_id']) echo 'selected'; ?>><?php echo $student['stu_name']; ?></option>
                    <?php }
                    } else { ?>
                        <option value="-1" <?php if ($receiver_id == -1) echo 'selected'; ?>>Admin</option>
                    <?php } ?>
                </select>
            </div><br>
            <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" id="subject" name="subject" class="form-control">
            </div><br>
            <div class="form-group">
                <label for="content">Content</label>
                <textarea id="content" name="content" rows="5" class="form-control"></textarea>
            </div><br>
            <div class="text-center">
                <button class="btn btn-danger" type="submit" id="sendMessageBtn" name="sendMessageBtn">Send Message</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Get the receiver type select element
    var receiverTypeSelect = document.getElementById('receiver_type');
    
    // Get the receiver ID container
    var receiverIdContainer = document.getElementById('receiver_id_container');
    
    // Function to populate the receiver ID select based on the selected type
    function populateReceiverIdSelect(receiverType) {
        var receiverIdSelect = document.getElementById('receiver_id');
        receiverIdSelect.innerHTML = ''; // Clear previous options
        
        if (receiverType === 'student') {
            // If the selected type is student, retrieve and populate the student options
            <?php foreach ($students as $student) { ?>
                var option = document.createElement('option');
                option.value = '<?php echo $student['stu_id']; ?>';
                option.text = '<?php echo $student['stu_name']; ?>';
                receiverIdSelect.add(option);
            <?php } ?>
        } else if (receiverType === 'admin') {
            // If the selected type is admin, populate the admin option
            var option = document.createElement('option');
            option.value = '-1'; // Set a value that doesn't conflict with actual student IDs
            option.text = 'Admin';
            receiverIdSelect.add(option);
        }
    }
    
    // Listen for changes in the receiver type select
    receiverTypeSelect.addEventListener('change', function () {
        // Get the selected receiver type
        var receiverType = receiverTypeSelect.value;
        
        // Populate the receiver ID select based on the selected type
        populateReceiverIdSelect(receiverType);
    });
    
    // On initial load, populate the receiver ID select based on the default receiver type
    var defaultReceiverType = receiverTypeSelect.value;
    populateReceiverIdSelect(defaultReceiverType);
});
</script>
