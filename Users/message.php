<?php
include_once("ProfileHeader.php");
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
            $sender_id = $_SESSION['stu_id']; // Assume sender is the logged-in student
            $sender_type = 'student';

            $sql = "INSERT INTO message (sender_id, sender_type, receiver_id, receiver_type, subject, content) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            
            // Check if the statement was prepared properly
            if ($stmt) {
                $stmt->bind_param("isisss", $sender_id, $sender_type, $receiver_id, $receiver_type, $subject, $content);
                if ($stmt->execute()) {
                    $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2">Message Sent Successfully</div>';
                    // Redirect to inbox or dashboard
                    echo "<script>setTimeout(()=>{window.location.href='message.php';},300);</script>";
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

// Get students enrolled in the same course as the logged-in student
function getEnrolledStudents($conn, $stu_id) {
    $sql = "SELECT DISTINCT s.stu_id, s.stu_name 
            FROM courseorder co
            INNER JOIN students s ON co.stu_id = s.stu_id
            INNER JOIN course c ON co.course_id = c.course_id
            WHERE c.course_id IN (SELECT course_id FROM courseorder WHERE stu_id = ?) AND s.stu_id != ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $stu_id, $stu_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $students = [];
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
    return $students;
}

$stu_id = $_SESSION['stu_id']; // Get student ID from session
$enrolled_students = getEnrolledStudents($conn, $stu_id);

// Get the lecturer who teaches the student
function getStudentLecturer($conn, $stu_id) {
    $sql = "SELECT lec_id FROM course WHERE course_id IN (SELECT course_id FROM courseorder WHERE stu_id = ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $stu_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['lec_id'];
    } else {
        return false;
    }
}

// Get the lecturer ID who teaches the student
$lecturer_id = getStudentLecturer($conn, $_SESSION['stu_id']);

// Get the lecturer name
function getLecturerName($conn, $lecturer_id) {
    $sql = "SELECT l_name FROM lectures WHERE l_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $lecturer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['l_name'];
    } else {
        return '';
    }
}

// Lecturer name
$lecturer_name = getLecturerName($conn, $lecturer_id);
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
                    <option value="lecturer">Lecturer</option>
                    <option value="student">Other Students Enrolled in the Same Course</option>
                </select>
            </div><br>
            <div class="form-group" id="receiver_id_container">
                <label for="receiver_id">Recipient Name</label>
                <!-- This select input will be dynamically populated with options -->
                <select name="receiver_id" id="receiver_id" class="form-control">
                    <option value="<?php echo $lecturer_id; ?>"><?php echo $lecturer_name; ?></option>
                    <?php foreach ($enrolled_students as $student) { ?>
                        <option value="<?php echo $student['stu_id']; ?>"><?php echo $student['stu_name']; ?></option>
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
        
        if (receiverType === 'lecturer') {
            // If the selected type is lecturer, populate with lecturer option
            var lecturerOption = document.createElement('option');
            lecturerOption.value = '<?php echo $lecturer_id; ?>';
            lecturerOption.text = '<?php echo $lecturer_name; ?>';
            receiverIdSelect.add(lecturerOption);
        } else if (receiverType === 'student') {
            // If the selected type is student, retrieve and populate the student options
            <?php foreach ($enrolled_students as $student) { ?>
                var option = document.createElement('option');
                option.value = '<?php echo $student['stu_id']; ?>';
                option.text = '<?php echo $student['stu_name']; ?>';
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


