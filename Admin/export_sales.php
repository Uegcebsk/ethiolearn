<?php
include_once("../DB_Files/db.php");

// Fetch data based on the search parameters
$start = isset($_GET['start']) ? $_GET['start'] : '';
$end = isset($_GET['end']) ? $_GET['end'] : '';
$course_id = isset($_GET['course_id']) ? $_GET['course_id'] : '';
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : '';
$stu_name = isset($_GET['stu_name']) ? $_GET['stu_name'] : '';

$where_clause = "1=1";
if (!empty($start) && !empty($end)) {
    $start = date('Y-m-d', strtotime($start));
    $end = date('Y-m-d', strtotime($end));
    $where_clause .= " AND date BETWEEN '$start' AND '$end'";
}
if (!empty($course_id)) {
    $where_clause .= " AND course_id = '$course_id'";
}
if (!empty($order_id)) {
    $where_clause .= " AND order_id = '$order_id'";
}
if (!empty($stu_name)) {
    $where_clause .= " AND stu_name LIKE '%$stu_name%'";
}

$sql = "SELECT order_id, course_name, stu_name, date, amount FROM courseorder WHERE $where_clause ORDER BY date DESC";
$result = $conn->query($sql);

// Set filename
$filename = 'sales_report_' . date('Ymd') . '.csv';

// Set headers for CSV file download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '"');

// Open output stream
$output = fopen('php://output', 'w');

// Set CSV column headers
fputcsv($output, array('Order ID', 'Course Name', 'Student Name', 'Order Date', 'Amount (birr)'));

// Fetch data from the database and write to CSV
while ($row = $result->fetch_assoc()) {
    // Format amount with "birr" string instead of "$"
    $row['amount'] .= ' birr';
    // Write data to CSV
    fputcsv($output, $row);
}

// Close output stream
fclose($output);
exit;
?>
