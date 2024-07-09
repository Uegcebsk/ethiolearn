<?php
include_once("Header copy.php");
include_once("../DB_Files/db.php");
?>

<div class="col-sm-9 mt-5 ">
    <div class="input-group mb-3">
        <input type="text" class="form-control" id="search_text" name="search_text" placeholder="Quiz Category">
    </div>
    <div id="result"></div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function(){
        $('#search_text').keyup(function(){
            var txt=$(this).val();
            if(txt!=''){
                $('#result').html('');
                $.ajax({
                    url: "result_fetch.php",
                    type: "post",
                    data: {search:txt},
                    dataType: "text",
                    success: function (data) {
                        $('#result').html(data);
                    }
                });
            }else{
            }
        });
    });
</script>

<?php
$output='';
$sql="SELECT * FROM exam_results WHERE exam_type LIKE '%".$_POST["search"]."%'";
$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result)>0){
    $output .='
    <table class="table">
    <tr>
    <th class="text-dark fw-bolder">Student Email</th>
    <th class="text-dark fw-bolder">Exam Category</th>
    <th class="text-dark fw-bolder">Mark</th>
    <th class="text-dark fw-bolder">Exam Time</th>
    </tr>
    ';
    while($row=mysqli_fetch_array($result)){
        $output .='
        <tr>
        <td class="text-dark fw-bolder">'.$row["email"].'</td>
        <td class="text-dark fw-bolder">'.$row["exam_type"].'</td> 
        <td class="text-dark fw-bolder">'.$row["mark"].'</td>
        <td class="text-dark fw-bolder">'.$row["exam_time"].'</td>
        </tr>
        ';
    }
    echo $output;
}else{
    echo "<p class='text-dark p-2 fw-bolder'>Results Not Found. </p>";
}
?>
