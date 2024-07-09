<?php
session_start();
include_once("../DB_Files/db.php");
if (isset($_SESSION['id'])) {
    // Set online status to 'offline' when logging out
    $offline_status = 'offline';
    $sql_update_status = "UPDATE admin SET online_status = ? WHERE id = ?";
    $stmt_update_status = $conn->prepare($sql_update_status);
    $stmt_update_status->bind_param("si", $offline_status, $_SESSION['id']);
    $stmt_update_status->execute();
}

$_SESSION = array();

if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 86400, '/');
}
session_destroy();
header('Location: index.php');
?>
