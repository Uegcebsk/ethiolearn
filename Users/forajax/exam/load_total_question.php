<?php
session_start();
include_once("../../../DB_Files/db.php");

$total_que=0;
$resl=mysqli_query($conn,"SELECT * FROM exam_questions WHERE catergory='$_SESSION[exam_category]'");
$total_que=mysqli_num_rows($resl);
echo $total_que;
?>
