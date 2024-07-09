<?php
include_once("ProfileHeader.php");
include_once("../DB_Files/db.php");
?>
<style>
    .container {
        padding:3%;
    }
</style>
<div class="container" style="padding=5%;">
<div class="col-sm-11 mt-5 ms-5 border-3">
<h5 class="bg-dark card text-white p-2 text-center ">Old Result</h5>
<?php
                $sql = "SELECT * FROM quiz_result WHERE stu_id='$_SESSION[stu_id]'";
                $result = $conn->query($sql);
                echo '
<table class="table table-borderless text-center text-light fw-bolder mt-5">
<thead class="bg-secondary">
    <tr >
        <th class="text-dark" scope="col">Category</th>
        <th class="text-dark" scope="col">Marks</th>
        <th class="text-dark" scope="col">Attempt Date</th>
    </tr>
</thead>
<tbody>';
                while ($row = $result->fetch_assoc()) {
                    echo '<tr  class="border-0">';
                    echo '<th class="text-dark" scope="row">' . $row['exam_type'] . '</th>';
                    echo '<td class="text-dark">' . $row['mark'] . '</td>';
                    echo '<td class="text-dark">' . $row['exam_time'] . '</td>';
                    echo '</tr>';
                }
                echo '</tbody>
</table>';
?>
</div>
</div>