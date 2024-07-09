<?php
ob_start(); // Start output buffering

session_start(); // Start session (if not already started)

// Include necessary files
require_once("ProfileHeader.php"); // Assuming this file includes necessary headers, DB connections, etc.
require_once("../DB_Files/db.php");

// Function to check if a student is eligible for a certificate in a specific course
function isEligibleForCertificate($studentId, $courseId)
{
    global $conn;
    // Implementation of eligibility criteria
    return true; // Replace with actual eligibility check logic
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

// Function to generate PDF using FPDF
function generatePDF($studentName, $courseName, $duration, $dateOfCompletion, $signatoryName)
{
    require('../fpdf186/fpdf.php'); // Include the FPDF library

    ob_end_clean(); // Clean the output buffer before generating PDF

    // Create a new PDF instance
    $pdf = new FPDF('P', 'mm', 'A4'); // Portrait orientation, millimeter unit, A4 size
    $pdf->AddPage();

    // Logo
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->SetTextColor(255, 215, 0); // Gold color for logo text
    $pdf->Cell(0, 10, 'Ethio Learn Academy', 0, 1, 'C', false); // Logo text

    // Certificate content
    $pdf->SetFillColor(255, 255, 255); // White background
    $pdf->SetDrawColor(52, 152, 219); // Blue border
    $pdf->Rect(5, 5, 200, 287, 'DF'); // Border rectangle with white fill and blue border
    $pdf->SetFont('Arial', 'B', 24);
    $pdf->SetTextColor(0, 0, 0); // Black text color
    $pdf->Cell(0, 30, 'Ethio learn Acadamy', 0, 1, 'C', false);

    $pdf->SetFont('Arial', 'B', 24);
    $pdf->SetTextColor(0, 0, 0); // Black text color
    $pdf->Cell(0, 30, 'Certificate of Completion', 0, 1, 'C', false);

    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 20, 'This is to certify that', 0, 1, 'C', false);

    $pdf->SetFont('Arial', 'B', 20);
    $pdf->Cell(0, 25, $studentName, 0, 1, 'C', false);

    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 20, 'has successfully completed the course', 0, 1, 'C', false);

    $pdf->SetFont('Arial', 'B', 20);
    $pdf->Cell(0, 25, $courseName, 0, 1, 'C', false);

    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 20, 'Duration: ' . $duration . ' days', 0, 1, 'C', false);

    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 20, 'Issued by: Ethio Learn Academy', 0, 1, 'C', false);

    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 20, 'Date: ' . date('F j, Y', strtotime($dateOfCompletion)), 0, 1, 'C', false);

    // Signature
    $pdf->Image('../Img/certificate_sign.jpg', 140, 210, 50, 50, 'JPG'); // Adjust position and size as needed

    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 20, 'Signature: ' . $signatoryName, 0, 1, 'R', false);

    // Output the PDF
    $pdf->Output('D', 'Certificate.pdf'); // 'D' indicates download, 'I' for inline display
    exit();
}

// Check if the download button is clicked
if (isset($_POST['download'])) {
    generatePDF($studentName, $courseName, $duration, $dateOfCompletion, $signatoryName);
}

// End output buffering and flush the output
ob_end_flush();
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
            background-color: #ffffff; /* White background */
            color: #ffffff; /* White text color */
            padding: 20px;
        }

        .certificate {
            max-width: 800px;
            margin: 0 auto;
            background-color: #ffffff; /* White background */
            padding: 50px;
            text-align: center;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
            border: 10px solid #3498db; /* Blue border */
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

        .signature img {
            max-width: 150px;
            border-radius: 50%;
        }

        .signature p {
            font-size: 20px;
            color: #2c3e50;
            margin-top: 10px;
        }

        .logo {
            font-size: 36px;
            color: #00FF00; /* Green color for logo */
            font-weight: bold;
        }

        .certificate-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .certificate-header .logo {
            text-align: left;
        }

        .certificate-header .issue-date {
            text-align: right;
            font-size: 20px;
            color: #2c3e50;
        }

        @media only screen and (max-width: 768px) {
            .certificate {
                max-width: 90%;
            }
        }

        .download-btn {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            font-size: 18px;
            background-color: #3498db; /* Blue background */
            color: #ffffff; /* White text color */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            text-decoration: none; /* Added to remove underline */
            width: 250px; /* Adjusted width for better responsiveness */
        }

        .download-btn:hover {
            background-color: #2980b9; /* Darker blue on hover */
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
        <p>Duration: <strong><?php echo $duration; ?></strong></p>
        <p>Issued by: <strong>Ethio Learn Academy</strong></p>
        <div class="signature">
            <img src="../Img/certificate_sign.jpg" alt="Signature">
            <p><?php echo $signatoryName; ?></p>
        </div>
    </div>
    <form method="post" action="">
        <button type="submit" name="download" class="download-btn">Download Your Certificate</button>
    </form>
</body>
</html>
