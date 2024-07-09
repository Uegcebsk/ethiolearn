<?php
$host = "localhost";
$user = "root";
$database = "ethiolearning";
$password = "";

if ($conn = new mysqli($host, $user, $password, $database)) {
    // connection successful
} else {
    // error message in database connection
    echo 'Database Error';
    exit;
}

// Check if the function exists before declaring it
if (!function_exists('row_count')) {
    function row_count($result) {
        global $conn;
        return mysqli_num_rows($result);
    }
}

// Check if the function exists before declaring it
if (!function_exists('escape')) {
    function escape($string) {
        global $conn;
        return mysqli_real_escape_string($conn, $string);
    }
}

// Check if the function exists before declaring it
if (!function_exists('query')) {
    function query($query) {
        global $conn;
        return mysqli_query($conn, $query);
    }
}

// Check if the function exists before declaring it
if (!function_exists('confirm')) {
    function confirm($result) {
        global $conn;

        if (!$result) {
            die("Query failed" . mysqli_error($conn));
        }
    }
}

// Check if the function exists before declaring it
if (!function_exists('fetch_array')) {
    function fetch_array($result) {
        global $conn;
        return mysqli_fetch_array($result);
    }
}

// Check if the function exists before declaring it
if (!function_exists('prepare')) {
    function prepare($sql) {
        global $conn;
        return $conn->prepare($sql);
    }
}
?>
