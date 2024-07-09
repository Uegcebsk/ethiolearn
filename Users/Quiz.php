<?php
include_once("ProfileHeader.php");
include_once("../DB_Files/db.php");
$category = $_SESSION["exam_category"];
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> 
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-8 mt-5 ms-5">
            <div class="bg-dark p-4 border-5">
                <p style="margin-top: -10px;" class="float-start fw-bolder text-light">Category: <?php echo $category; ?></p>
                <p style="margin-top: -10px;" class="float-end fw-bolder text-warning" id="countdowntimer"></p>
            </div>
            <br><br>
            <div class="col-lg-9 col-lg-push-10">
                <div class="float-end fw-bolder text-dark" id="total_que">0</div>
                <div class="float-end fw-bolder text-dark"> /</div>
                <div class="float-end fw-bolder text-dark" id="current_que">0</div>
            </div>
            <br><br><br>
            <div class="row mt-5 ms-5">
                <div class="row">
                    <div class="col-lg-8 text-dark col-lg-push-1" id="load_questions"></div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-lg-12 col-lg-push-3">
                    <div class="col-lg-12 text-center">
                        <input type="button" class="btn btn-info fw-bolder text-light" value="Previous" onclick="load_previous();">&nbsp;
                        <input type="button" class="btn btn-success fw-bolder text-light" value="Next" onclick="load_next();">
                        <!-- Flag button -->
                        <button class="btn btn-danger fw-bolder text-light" id="flagBtn" onclick="flagQuestion()">Flag</button>
                    </div>
                </div>
            </div>
            <!-- Interactive Question Number Navigation -->
            <div class="row mt-5">
                <div class="col-lg-12 text-center" id="question_nav">
                    <!-- Question numbers will be dynamically added here -->
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var flaggedQuestions = {}; // Object to store flagged status of questions

    // Function to dynamically generate question number navigation
    function generate_question_numbers(totalQuestions) {
        var questionNav = document.getElementById("question_nav");
        questionNav.innerHTML = ""; // Clear previous content
        for (var i = 1; i <= totalQuestions; i++) {
            var questionNumberButton = document.createElement("button");
            questionNumberButton.setAttribute("class", "btn btn-primary fw-bolder text-light");
            questionNumberButton.setAttribute("onclick", "load_questions(" + i + ")");
            questionNumberButton.setAttribute("id", "question_" + i); // Assign unique id to each button
            questionNumberButton.textContent = i;
            questionNav.appendChild(questionNumberButton);
            questionNav.innerHTML += "&nbsp;"; // Add space between buttons
        }
        // Update button colors based on flagged status
        updateButtonColors();
    }

    // Function to flag/unflag the current question
    function flagQuestion() {
        var currentQuestionNo = document.getElementById("current_que").innerText;
        if (flaggedQuestions[currentQuestionNo]) {
            // Unflag the question
            flaggedQuestions[currentQuestionNo] = false;
        } else {
            // Flag the question
            flaggedQuestions[currentQuestionNo] = true;
        }
        // Update button colors based on flagged status
        updateButtonColors();
    }

    // Function to update button colors based on flagged status
    function updateButtonColors() {
        for (var questionNo in flaggedQuestions) {
            var button = document.getElementById("question_" + questionNo);
            if (flaggedQuestions[questionNo]) {
                button.classList.remove("btn-primary");
                button.classList.add("btn-warning");
            } else {
                button.classList.remove("btn-warning");
                button.classList.add("btn-primary");
            }
        }
    }

    setInterval(function() {
        timer();
    },1000);

    function timer() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                if (xmlhttp.responseText<="00:00:01") {
                    window.location = "result.php";
                }
                document.getElementById("countdowntimer").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET", "forajax/load_timer.php", true);
        xmlhttp.send(null);
    }

    function load_total_que() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("total_que").innerHTML = xmlhttp.responseText;
                generate_question_numbers(parseInt(xmlhttp.responseText)); // Generate question number navigation
            }
        };
        xmlhttp.open("GET", "forajax/load_total_que.php", true);
        xmlhttp.send(null);
    }

    var questionno = "1";
    load_questions(questionno);

    function load_questions(questionno) {
        document.getElementById("current_que").innerHTML = questionno;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                if (xmlhttp.responseText >= "over") {
                    window.location = "result.php";
                } else {
                    document.getElementById("load_questions").innerHTML = xmlhttp.responseText;
                    load_total_que();
                }
            }
        };
        xmlhttp.open("GET", "forajax/load_questions.php?questionno=" + questionno, true);
        xmlhttp.send(null);
    }

    function radioclick(radiovalue, questionno) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                // Handle response if needed
            }
        };
        xmlhttp.open("GET", "forajax/save_answer_in_answer.php?questionno=" + questionno + "&value1=" + radiovalue, true);
        xmlhttp.send(null);
    }

    function load_previous() {
        if (questionno == "1") {
            load_questions(questionno);
        } else {
            questionno = eval(questionno) - 1;
            load_questions(questionno);
        }
    }

    function load_next() {
        questionno = eval(questionno) + 1;
        load_questions(questionno);
    }

    window.onload = function() {
        document.onkeydown = function(e) {
            return (e.which || e.keyCode) != 116;
        };
    }
</script>
