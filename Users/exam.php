<?php
include_once("ProfileHeader.php");
include_once("../DB_Files/db.php");

// Check if exam category is set in the URL
if (isset($_GET["exam_category"])) {
    // Set exam category in the session
    $_SESSION["exam_category"] = $_GET["exam_category"];
}

$category = $_SESSION["exam_category"];
?>

<script src="/ethiolearn/js/jquery-3.3.1.min.js"></script> 
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
    var examTimeComplete = false; // Flag to indicate if exam time is complete
    var allQuestionsAnswered = false; // Flag to indicate if all questions are answered
    var examEndTime; // Variable to store the end time of the exam

    // Function to start the countdown timer
    function startTimer() {
        var timerInterval = setInterval(function() {
            // Get the current time
            var currentTime = new Date().getTime();

            // Calculate the time remaining in milliseconds
            var timeRemaining = examEndTime - currentTime;

            // Check if the time is over
            if (timeRemaining <= 0) {
                clearInterval(timerInterval); // Stop the timer
                examTimeComplete = true; // Set the flag
                checkRedirect(); // Check if redirect is needed
                document.getElementById("countdowntimer").innerHTML = "00:00:00"; // Display 00:00:00
            } else {
                // Convert milliseconds to hours, minutes, and seconds
                var hours = Math.floor((timeRemaining / (1000 * 60 * 60)) % 24);
                var minutes = Math.floor((timeRemaining / (1000 * 60)) % 60);
                var seconds = Math.floor((timeRemaining / 1000) % 60);

                // Add leading zeros if necessary
                hours = hours < 10 ? "0" + hours : hours;
                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                // Display the time remaining
                document.getElementById("countdowntimer").innerHTML = hours + ":" + minutes + ":" + seconds;
            }
        }, 1000); // Update every second
    }

    // Function to fetch the exam end time from the server
    function fetchEndTime() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                // Parse the minutes received from the server
                var minutesRemaining = parseInt(xmlhttp.responseText);

                // Calculate the end time in milliseconds
                examEndTime = new Date().getTime() + (minutesRemaining * 60 * 1000);

                // Start the countdown timer
                startTimer();
            }
        };
        xmlhttp.open("GET", "forajax/exam/load_exam_timer.php", true);
        xmlhttp.send(null);
    }

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
            if (button) { // Check if button exists
                if (flaggedQuestions[questionNo]) {
                    button.classList.remove("btn-primary");
                    button.classList.add("btn-warning");
                } else {
                    button.classList.remove("btn-warning");
                    button.classList.add("btn-primary");
                }
            }
        }
    }

    function load_total_que() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("total_que").innerHTML = xmlhttp.responseText;
                generate_question_numbers(parseInt(xmlhttp.responseText)); // Generate question number navigation
            }
        };
        xmlhttp.open("GET", "forajax/exam/load_total_question.php", true);
        xmlhttp.send(null);
    }

    var questionno = "1";
    load_questions(questionno);

    function load_questions(questionno) {
        document.getElementById("current_que").innerHTML = questionno;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                if (xmlhttp.responseText == "over") { // Modified condition
                    // If exam is over, set flag and check if we can redirect
                    examTimeComplete = true;
                    checkRedirect();
                } else {
                    // Otherwise, load the questions
                    document.getElementById("load_questions").innerHTML = xmlhttp.responseText;
                    load_total_que();
                    // Check if all questions are answered
                    if (parseInt(questionno) === parseInt(document.getElementById("total_que").innerHTML)) {
                        // All questions are answered, show the submit button
                        allQuestionsAnswered = true;
                        $("#submitBtn").show();
                    } else {
                        // Hide the submit button if not all questions are answered
                        $("#submitBtn").hide();
                    }
                }
            }
        };
        xmlhttp.open("GET", "forajax/exam/load_exam_question.php?questionno=" + questionno, true);
        xmlhttp.send(null);
    }

    // Function to submit the exam
    function submitExam() {
        // Set the allQuestionsAnswered flag to true and check if we can redirect
        allQuestionsAnswered = true;
        checkRedirect();
    }

    // Function to check if redirect to exam_result.php is needed
    function checkRedirect() {
        if (examTimeComplete || allQuestionsAnswered) { // If time is complete or all questions are answered
            // Redirect only if exam time is complete or all questions are answered
            window.location.href = "exam_result.php";
        }
    }

    // Function to load the previous question
    function load_previous() {
        if (questionno == "1") {
            load_questions(questionno);
        } else {
            questionno = eval(questionno) - 1;
            load_questions(questionno);
        }
    }

    // Function to load the next question
    function load_next() {
        var totalQuestions = parseInt(document.getElementById("total_que").innerText);
        if (questionno < totalQuestions) {
            questionno++;
            load_questions(questionno);
        } else {
            // If all questions are answered, prevent further increment
            alert("You have answered all questions. Please submit the exam.");
        }
    }

    // Function to handle radio button clicks
    function radioclick(radiovalue, questionno) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                // Handle response if needed
            }
        };
        xmlhttp.open("GET", "forajax/exam/save_answer.php?questionno=" + questionno + "&value1=" + radiovalue, true);
        xmlhttp.send(null);
    }

    // Function to handle filling in the blank questions
    function fillInTheBlank(answer, questionno) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                // Handle response if needed
            }
        };
        xmlhttp.open("GET", "forajax/exam/save_answer.php?questionno=" + questionno + "&value1=" + answer, true);
        xmlhttp.send(null);
    }

    // Flagged questions object
    var flaggedQuestions = {};

    // Execute the fetchEndTime function to start the timer
    fetchEndTime();

    // jQuery to handle click event for submit button
    $(document).ready(function() {
        $("#submitBtn").click(function() {
            submitExam();
        });
    });
</script>

<!-- Submit button -->
<div class="row mt-5">
    <div class="col-lg-12 col-lg-push-3">
        <div class="col-lg-12 text-center">
            <button id="submitBtn" class="btn btn-primary fw-bolder text-light" style="display: none;">Submit Exam</button>
        </div>
    </div>
</div>
