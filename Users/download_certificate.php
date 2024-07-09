<?php
// Include necessary files
include_once("ProfileHeader.php");
include_once("../DB_Files/db.php");
include_once("functions.php");

// Check if a user is logged in
if (!isset($_SESSION['stu_id'])) {
    header('Location:../Home.php');
    exit(); // Exit to prevent further execution
}

// Check if the course ID is provided
if (!isset($_GET['course_id'])) {
    echo "<p class='text-center'>Course ID is missing.</p>";
    exit();
}

// Get the student ID from the session
$studentId = $_SESSION['stu_id'];
$courseId = $_GET['course_id'];

// Check if the student is eligible for the certificate
if (!isEligibleForCertificate($studentId, $courseId)) {
    echo "<p class='text-center'>Sorry, you are not eligible for the certificate for this course.</p>";
    exit();
}

// Get student's name from the database
$sqlStudent = "SELECT stu_name FROM students WHERE stu_id = ?";
$stmtStudent = $conn->prepare($sqlStudent);
$stmtStudent->bind_param("i", $studentId);
$stmtStudent->execute();
$resultStudent = $stmtStudent->get_result();
$student = $resultStudent->fetch_assoc();
$studentName = $student['stu_name'];
$stmtStudent->close();

// Get the course name and duration
$sqlCourse = "SELECT course_name, course_duration FROM course WHERE course_id = ?";
$stmtCourse = $conn->prepare($sqlCourse);
$stmtCourse->bind_param("i", $courseId);
$stmtCourse->execute();
$resultCourse = $stmtCourse->get_result();
$course = $resultCourse->fetch_assoc();
$courseName = $course['course_name'];
$duration = $course['course_duration']; // Assuming duration is in days
$stmtCourse->close();

// Get the current date
$dateOfCompletion = date('Y-m-d');

// Get the name of the signatory (for example, admin name)
$sqlAdmin = "SELECT username FROM admin LIMIT 1"; // Assuming only one admin for simplicity
$resultAdmin = $conn->query($sqlAdmin);
$admin = $resultAdmin->fetch_assoc();
$signatoryName = $admin['username'];

// Function to generate and download the certificate
function generateAndDownloadCertificate() {
    global $studentName, $courseName, $duration, $dateOfCompletion, $signatoryName;

    // Redirect output to a buffer
    ob_start();

    // Generate the certificate using FPDF
    require('download_certificate.php');

    // Get the PDF content from the buffer
    $pdf_content = ob_get_clean();

    // Send PDF as response to download
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="Certificate.pdf"');
    echo $pdf_content;
    exit();
}

// Handle download button click
if (isset($_POST['download_certificate'])) {
    generateAndDownloadCertificate();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $courseName; ?> Certificate</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            background-color: #f2f2f2;
            padding: 20px;
        }

        .certificate {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            border: 10px solid #8e44ad;
            padding: 50px;
            text-align: center;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
        }

        .certificate h2 {
            font-size: 48px;
            margin-bottom: 20px;
            color: #2c3e50;
        }

        .certificate p {
            font-size: 24px;
            margin-bottom: 15px;
            color: #7f8c8d;
        }

        .certificate strong {
            color: #2c3e50;
            font-size: 28px;
        }

        .signature {
            margin-top: 40px;
            font-size: 20px;
            color: #2c3e50;
            text-align: right;
        }

        .logo {
            margin-top: 20px;
            font-size: 36px;
            color: #e74c3c;
            font-weight: bold;
        }

        .certificate-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .certificate-header .logo {
            text-align: left;
        }

        .certificate-header .issue-date {
            text-align: right;
        }

        .download-btn {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            font-size: 18px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            text-decoration: none; /* Added for better UX */
        }

        .download-btn:hover {
            background-color: #2980b9;
        }

        @media only screen and (max-width: 768px) {
            .certificate {
                max-width: 90%;
            }
        }
    </style>
</head>

<body>
    <div id="certificate-content" class="certificate">
        <div class="certificate-header">
            <div class="logo">Ethio <span style="color: #FFD700;">Learn</span> <span style="color: #FF0000;">Academy</span></div>
            <div class="issue-date">Date: <strong><?php echo date('F j, Y', strtotime($dateOfCompletion)); ?></strong></div>
        </div>
        <h2>Certificate of Completion</h2>
        <p>This is to certify that</p>
        <p><strong><?php echo $studentName; ?></strong></p>
        <p>has successfully completed the course</p>
        <p><strong><?php echo $courseName; ?></strong></p>
        <p>Duration: <strong><?php echo $duration; ?> days</strong></p>
        <p>Issued by: <strong>Ethio Learn Academy</strong></p>
        <div class="signature">
            <img src="/ethiolearn/Img/certificate_sign.jpg" alt="Signature" style="max-width: 150px; border-radius: 50%;">
            <p><?php echo $signatoryName; ?></p>
        </div>
        
        <!-- Download button -->
        <form method="post">
            <button type="submit" name="download_certificate" class="download-btn">Download Your Certificate</button>
        </form>
    </div>
</body>

</html>
