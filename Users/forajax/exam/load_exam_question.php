<?php
session_start();
include_once("../../../DB_Files/db.php");

$question_no="";
$question="";
$opt1="";
$opt2="";
$opt3="";
$opt4="";
$answer="";
$count="";
$ans="";

$queno=$_GET["questionno"];

if(isset($_SESSION["answer"][$queno])){
    $ans=$_SESSION["answer"][$queno];
}

// Fetch exam category from session
$category = $_SESSION["exam_category"];

// Fix SQL query to use the correct category
$res=mysqli_query($conn,"SELECT * FROM exam_questions WHERE catergory='$category' && ques_no=$_GET[questionno]"); // Changed 'catergory' to 'category'
$count=mysqli_num_rows($res);

if($count==0){
    echo "over";
}else{
    while($row=mysqli_fetch_array($res)){
        $question_no=$row["ques_no"]; 
        $question=$row["question_text"];
        $question_type = $row["question_type"];
        
        if ($question_type == "multiple_choice") {
            $opt1=$row["opt1"];
            $opt2=$row["opt2"];
            $opt3=$row["opt3"];
            $opt4=$row["opt4"];
        } elseif ($question_type == "true_false") {
            $opt1 = "True";
            $opt2 = "False";
        } else { // fill_in_the_blank
            // Options not applicable for fill in the blank questions
        }
    }
    ?>

    <table style="margin-top: -50px;" class="table ms-3">
        <tr>
            <td class="fw-bolder text-dark border-0">
                <?php echo "(" .$question_no .")   " . $question; ?>
            </td>
        </tr>
    </table>

    <?php if ($question_type == "multiple_choice"): ?>

    <table class="table border-0 ms-5">
        <tr>
            <td class="border-0">
                <input class="text-dark" type="radio" name="r1" id="r1" value="<?php echo $opt1; ?>"  onclick="radioclick(this.value,<?php echo $question_no ?>)"
                <?php
                if($ans==$opt1){
                    echo "checked";
                }
                ?>>
                <label class="text-dark fw-bolder ms-3" for=""><?php echo $opt1; ?></label> 
            </td>
        </tr>


        <tr>
            <td class="border-0">
                <input type="radio" name="r1" id="r1" value="<?php echo $opt2; ?>" onclick="radioclick(this.value,<?php echo $question_no ?>)"
                <?php
                if($ans==$opt2){
                    echo "checked";
                }
                ?>>
                <label class="text-dark fw-bolder ms-3" for="" ><?php echo $opt2; ?></label>
            </td>
        </tr>


        <tr>
            <td class="border-0">
                <input type="radio" value="<?php echo $opt3; ?>" name="r1" id="r1" onclick="radioclick(this.va,<?php echo $question_no ?>)"
                <?php
                if($ans==$opt3){
                    echo "checked";
                }
                ?>>
                <label class="text-dark fw-bolder ms-3"  for="" ><?php echo $opt3; ?></label>

            </td>
        </tr>


        <tr>
            <td class="border-0">
                <input type="radio" onclick="radioclick(this.value,<?php echo $question_no ?>)" value="<?php echo $opt4; ?>" name="r1" id="r1" 
                <?php
                if($ans==$opt4){
                    echo "checked";
                }
                ?>>
                <label  class="text-dark fw-bolder ms-3" for=""><?php echo $opt4; ?></label>
            </td>
        </tr>


    </table>

    <?php elseif ($question_type == "true_false"): ?>

    <table class="table border-0 ms-5">
        <tr>
            <td class="border-0">
                <input class="text-dark" type="radio" name="r1" id="r1" value="True"  onclick="radioclick('True',<?php echo $question_no ?>)"
                <?php
                if($ans=="True"){
                    echo "checked";
                }
                ?>>
                <label class="text-dark fw-bolder ms-3" for="">True</label> 
            </td>
        </tr>


        <tr>
            <td class="border-0">
                <input type="radio" name="r1" id="r1" value="False" onclick="radioclick('False',<?php echo $question_no ?>)"
                <?php
                if($ans=="False"){
                    echo "checked";
                }
                ?>>
                <label class="text-dark fw-bolder ms-3" for="">False</label>
            </td>
        </tr>
    </table>

    <?php else: // fill_in_the_blank ?>

    <div class="form-group">
        <input type="text" class="form-control" id="blank_answer_<?php echo $question_no; ?>" placeholder="Your answer here..." value="<?php echo $ans; ?>" oninput="fillInTheBlank(this.value, <?php echo $question_no; ?>)">
    </div>

    <?php endif; ?>

<?php
}
?>
