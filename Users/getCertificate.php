<?php

// Include necessary files
include_once("ProfileHeader.php");
include_once("Certificate_function.php");

// Get the student ID from the session
$studentId = $_SESSION['stu_id'];

// Display certificates information for each course
$sql = "SELECT c.course_id, c.course_name 
        FROM course c 
        INNER JOIN courseorder co ON c.course_id = co.course_id 
        WHERE co.stu_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $studentId);
$stmt->execute();
$result = $stmt->get_result();

// Initialize variables to store courses' information
$certificates = array();

while ($row = $result->fetch_assoc()) {
    $courseId = $row['course_id'];
    $courseName = $row['course_name'];

    // Get current lesson progress
    $completedPercentage = getCurrentLessonProgress($studentId, $courseId);

    // Format completed percentage to two decimal places
    $completedPercentage = number_format($completedPercentage, 2);

    // Get total number of lessons, quizzes, and exams
    $totalLessons = getTotalLessonsCount($courseId);
    $totalQuizzes = getTotalQuizzesCount($courseId);
    $totalExams = getTotalExamsCount($courseId); // Function to get total exams count
    $completedExams = getCompletedExamsCount($studentId, $courseId); // Function to get completed exams count

    // Ensure completed exams do not exceed total exams
    if ($completedExams > $totalExams) {
        $completedExams = $totalExams;
    }

    // Get completed quizzes and exams
    $completedQuizzes = getCompletedQuizzesCount($studentId, $courseId);

    // Ensure completed quizzes do not exceed total quizzes
    if ($completedQuizzes > $totalQuizzes) {
        $completedQuizzes = $totalQuizzes;
    }

    // Check if eligible for certificate
    $eligibleForCertificate = isEligibleForCertificate($studentId, $courseId);

    // Calculate completed lessons based on percentage
    $completedLessons = ($totalLessons * $completedPercentage) / 100;

    // Add course information to certificates array
    $certificates[] = array(
        'course_id' => $courseId,
        'course_name' => $courseName,
        'completed_percentage' => $completedPercentage,
        'total_lessons' => $totalLessons,
        'completed_lessons' => $completedLessons,
        'total_quizzes' => $totalQuizzes,
        'completed_quizzes' => $completedQuizzes,
        'total_exams' => $totalExams,
        'completed_exams' => $completedExams,
        'eligible_for_certificate' => $eligibleForCertificate
    );
}

// Output certificates information
if (!empty($certificates)) {
    echo '<div class="container">';
    echo '<div class="row justify-content-center">';
    echo '<div class="col-sm-11">';
    echo '<p class="bg-dark text-white p-2 fw-bolder text-center">Certificates</p>';

    // Iterate through each course
    foreach ($certificates as $certificate) {
        $courseId = $certificate['course_id'];
        $courseName = $certificate['course_name'];
        $completedPercentage = $certificate['completed_percentage'];
        $totalLessons = $certificate['total_lessons'];
        $completedLessons = $certificate['completed_lessons'];
        $totalQuizzes = $certificate['total_quizzes'];
        $completedQuizzes = $certificate['completed_quizzes'];
        $totalExams = $certificate['total_exams'];
        $completedExams = $certificate['completed_exams'];
        $eligibleForCertificate = $certificate['eligible_for_certificate'];

        // Output course information
        echo '<div class="mt-4 border p-3">';
        echo '<p class="text-center">Course: <strong>' . $courseName . '</strong></p>';
        echo '<p class="text-center">Completed Lessons: ' . $completedPercentage . '% (' . number_format($completedLessons, 2) . ' out of ' . $totalLessons . ')</p>';
        echo '<p class="text-center">Total Quizzes: ' . $totalQuizzes . ', Completed: ' . $completedQuizzes . '</p>';
        echo '<p class="text-center">Total Exams: ' . $totalExams . ', Completed: ' . $completedExams . '</p>';

        // Check if eligible for certificate
        if ($eligibleForCertificate) {
            // Insert certificate into the database
            insertCertificate($studentId, $courseId, $courseName);

            // Output success message and download link
            echo '<p class="text-success text-center">Congratulations! You are eligible for the certificate for this course.</p>';
            echo '<a href="generate_certificate.php?course_id=' . $courseId . '" class="btn btn-success btn-block mt-3">Download Certificate</a>';
        } else {
            // Output failure message and eligibility criteria
            echo '<p class="text-danger text-center">Sorry, you are not yet eligible for the certificate for this course.</p>';
            echo '<p class="text-center">To be eligible, you need to:</p>';
            echo '<ul class="text-center">';
            echo '<li>Complete at least 85% of the lessons in this course.</li>';
            echo '<li>Pass all quizzes with at least 85% marks.</li>';
            echo '<li>Pass all exams with at least 80% marks.</li>';
            echo '</ul>';
        }

        echo '</div>'; // Close border div
    }

    echo '</div>';
    echo '</div>';
    echo '</div>';
} else {
    echo "<p class='text-center'>No courses found.</p>";
}
?>

