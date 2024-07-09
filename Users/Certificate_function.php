<?php
// certificate_functions.php

// Include necessary files
include_once("../DB_Files/db.php");

// Function to check if a student is eligible for a certificate in a specific course
function isEligibleForCertificate($studentId, $courseId)
{
    global $conn;

    // Check if the student has achieved a passing grade in all exams for the given course
    $sqlExams = "SELECT COUNT(*) AS total_exams, 
                        SUM(IF(mark >= 80, 1, 0)) AS passed_exams 
                    FROM exam_results er
                    INNER JOIN exam_category ec ON er.exam_category = ec.exam_name
                    WHERE ec.course_id = ? AND er.student_id = ?";
    $stmtExams = $conn->prepare($sqlExams);
    $stmtExams->bind_param("ii", $courseId, $studentId);
    $stmtExams->execute();
    $resultExams = $stmtExams->get_result()->fetch_assoc();
    $stmtExams->close();

    // Calculate the percentage of passed exams
    $passedExamCount = $resultExams['passed_exams'];
    $totalExamCount = $resultExams['total_exams'];
    $examPassPercentage = ($totalExamCount > 0) ? ($passedExamCount / $totalExamCount) * 100 : 0;

    // Check if the student has completed at least 85% of lessons
    $completedPercentage = getCurrentLessonProgress($studentId, $courseId);

    // Check if the student has passed all quizzes with at least 85% marks
    $totalQuizzes = getTotalQuizzesCount($courseId);
    $completedQuizzes = getCompletedQuizzesCount($studentId, $courseId);
    $quizPassPercentage = ($totalQuizzes > 0) ? ($completedQuizzes / $totalQuizzes) * 100 : 0;

    // Check if the student is eligible for the certificate based on the criteria
    return ($completedPercentage >= 85 && $quizPassPercentage >= 85 && $examPassPercentage >= 80);
}

// Function to get the current progress of lessons in a course
function getCurrentLessonProgress($studentId, $courseId)
{
    global $conn;

    // Get the total number of lessons in the course
    $sqlTotalLessons = "SELECT COUNT(*) AS total_lessons FROM lesson WHERE course_id = ?";
    $stmtTotalLessons = $conn->prepare($sqlTotalLessons);
    $stmtTotalLessons->bind_param("i", $courseId);
    $stmtTotalLessons->execute();
    $totalLessonsResult = $stmtTotalLessons->get_result()->fetch_assoc();
    $totalLessons = $totalLessonsResult['total_lessons'];
    $stmtTotalLessons->close();

    // Get the total progress of lessons by the student
    $sqlTotalProgress = "SELECT SUM(progress) AS total_progress FROM lesson_progress WHERE student_id = ? AND course_id = ?";
    $stmtTotalProgress = $conn->prepare($sqlTotalProgress);
    $stmtTotalProgress->bind_param("ii", $studentId, $courseId);
    $stmtTotalProgress->execute();
    $totalProgressResult = $stmtTotalProgress->get_result()->fetch_assoc();
    $totalProgress = $totalProgressResult['total_progress'];
    $stmtTotalProgress->close();

    // Calculate the percentage of completed lessons
    $completedPercentage = ($totalLessons > 0) ? ($totalProgress / ($totalLessons * 100)) * 100 : 0;

    // Ensure the completed percentage does not exceed 100%
    $completedPercentage = min($completedPercentage, 100);

    return $completedPercentage;
}

// Function to get the number of quizzes for a course
function getTotalQuizzesCount($courseId)
{
    global $conn;

    // Get the count of quizzes for the course
    $sql = "SELECT COUNT(*) AS total_quizzes 
            FROM exam_category 
            WHERE course_id = ? AND assessment_type = 'quiz'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $courseId);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    return $result['total_quizzes'];
}

// Function to get the number of exams for a course
function getTotalExamsCount($courseId)
{
    global $conn;

    // Query to get the count of exams for the course
    $sql = "SELECT COUNT(*) AS total_exams 
            FROM exam_category 
            WHERE course_id = ? AND assessment_type = 'exam'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $courseId);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    return $result['total_exams'];
}

// Function to get the number of completed exams for a student in a course
function getCompletedExamsCount($studentId, $courseId)
{
    global $conn;

    // Query to get the count of completed exams for the course
    $sql = "SELECT COUNT(*) AS completed_exams 
            FROM exam_results er
            INNER JOIN exam_category ec ON er.exam_category = ec.exam_name
            WHERE er.student_id = ? AND ec.course_id = ? AND er.mark >= 80";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $studentId, $courseId);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    return $result['completed_exams'];
}

// Function to get the total number of lessons for a course
function getTotalLessonsCount($courseId)
{
    global $conn;

    // Get the count of lessons for the course
    $sql = "SELECT COUNT(*) AS total_lessons FROM lesson WHERE course_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $courseId);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    return $result['total_lessons'];
}

// Function to get the number of completed quizzes for a student in a course
function getCompletedQuizzesCount($studentId, $courseId)
{
    global $conn;

    // Get the count of completed quizzes for the course
    $sql = "SELECT COUNT(*) AS completed_quizzes 
            FROM quiz_result qr
            INNER JOIN exam_category ec ON qr.exam_type = ec.exam_name
            WHERE qr.stu_id = ? AND ec.course_id = ? AND qr.mark >= 85";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $studentId, $courseId);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    return $result['completed_quizzes'];
}

// Function to insert certificate information into the database
function insertCertificate($studentId, $courseId, $courseName)
{
    global $conn;

    // Check if the certificate already exists for the student and course
    $sqlCheck = "SELECT COUNT(*) AS cert_count FROM certificates WHERE stu_id = ? AND course_id = ?";
    $stmtCheck = $conn->prepare($sqlCheck);
    $stmtCheck->bind_param("ii", $studentId, $courseId);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result()->fetch_assoc();
    $stmtCheck->close();

    // If the certificate already exists, return without inserting
    if ($resultCheck['cert_count'] > 0) {
        return;
    }

    // Prepare the insertion query
    $sql = "INSERT INTO certificates (certificate, course_name, issue_date, completion_status, stu_id, course_id) VALUES (?, ?, ?, ?, ?, ?)";
    
    // Set the issue date to the current date
    $issueDate = date('Y-m-d');
    
    // Set the completion status to 'completed'
    $completionStatus = 'completed';

    // Prepare and execute the statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssii", $certificate, $courseName, $issueDate, $completionStatus, $studentId, $courseId);
    
    // Set the certificate name
    $certificate = "Certificate of Completion";

    // Execute the statement
    $stmt->execute();
    $stmt->close();
}
?>
