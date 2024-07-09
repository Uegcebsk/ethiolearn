<?php
include_once("Header.php");
include_once("../DB_Files/db.php");

$msg = ''; // Initialize message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['sendMessageBtn'])) {
        $receiver_id = $_POST['receiver_id'] ?? '';
        $receiver_type = $_POST['receiver_type'] ?? '';
        $subject = $_POST['subject'] ?? '';
        $content = $_POST['content'] ?? '';

        if (empty($receiver_id) || empty($receiver_type) || empty($subject) || empty($content)) {
            $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2">All Fields Required</div>';
        } else {
            // Insert message into database
            $sender_id = $_SESSION['id']; // Assume sender is the logged-in admin
            $sender_type = 'admin';

            $sql = "INSERT INTO message (sender_id, sender_type, receiver_id, receiver_type, subject, content) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            
            // Check if the statement was prepared properly
            if ($stmt) {
                $stmt->bind_param("isisss", $sender_id, $sender_type, $receiver_id, $receiver_type, $subject, $content);
                if ($stmt->execute()) {
                    $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2">Message Sent Successfully</div>';
                    // Redirect to inbox or dashboard
                    echo "<script>setTimeout(()=>{window.location.href='admin_messages.php';},500);</script>";
                } else {
                    $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2">Failed to send message</div>';
                }
                $stmt->close();
            } else {
                $msg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2">Error preparing statement</div>';
            }
        }
    }
}

// Get all students
function getAllStudents($conn) {
    $sql = "SELECT stu_id, stu_name FROM students";
    $result = $conn->query($sql);
    $students = [];
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
    return $students;
}

// Get all lecturers
function getAllLecturers($conn) {
    $sql = "SELECT l_id, l_name FROM lectures";
    $result = $conn->query($sql);
    $lecturers = [];
    while ($row = $result->fetch_assoc()) {
        $lecturers[] = $row;
    }
    return $lecturers;
}

$all_students = getAllStudents($conn);
$all_lecturers = getAllLecturers($conn);
?>

<div class="container" style="padding:6%;">
    <div class="col-sm-12 mt-5 jumbotron">
        <h3 class="text-center">Compose Message</h3>
        <form action="" method="POST" id="sendMessageForm">
            <br>
            <?php echo $msg; ?><br>
            <div class="form-group">
                <label for="receiver_type">Recipient Type</label>
                <select name="receiver_type" id="receiver_type" class="form-control">
                    <option value="student">All Students</option>
                    <option value="lecturer">All Lecturers</option>
                </select>
            </div><br>
            <div class="form-group" id="receiver_id_container">
                <label for="receiver_id">Recipient Name</label>
                <!-- This select input will be dynamically populated with options -->
                <select name="receiver_id" id="receiver_id" class="form-control">
                    <!-- Options will be added dynamically using JavaScript -->
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
    
    // Get the receiver ID select element
    var receiverIdSelect = document.getElementById('receiver_id');
    
    // Function to populate the receiver ID select based on the selected type
    function populateReceiverIdSelect(receiverType) {
        receiverIdSelect.innerHTML = ''; // Clear previous options
        
        if (receiverType === 'student') {
            // If the selected type is student, populate with all students
            <?php foreach ($all_students as $student) { ?>
                var option = document.createElement('option');
                option.value = '<?php echo $student['stu_id']; ?>';
                option.text = '<?php echo $student['stu_name']; ?>';
                receiverIdSelect.add(option);
            <?php } ?>
        } else if (receiverType === 'lecturer') {
            // If the selected type is lecturer, populate with all lecturers
            <?php foreach ($all_lecturers as $lecturer) { ?>
                var option = document.createElement('option');
                option.value = '<?php echo $lecturer['l_id']; ?>';
                option.text = '<?php echo $lecturer['l_name']; ?>';
                receiverIdSelect.add(option);
            <?php } ?>
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

<?php include_once("Footer.php"); ?>
