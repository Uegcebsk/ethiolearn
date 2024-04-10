<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ethio learn</title>
</head>
<body>
    <!-- Navigation Bar -->
    <nav>
        <div class="container nav__container">
            <a class="custom__links" href="index.php">
                <h4 class="title" style="font-size: 25px;">
                    <span style="color: green;">Ethio</span> 
                    <span style="color: gold;">learn</span>
                </h4>
            </a>
        </div>
    </nav>

    <?php
    include_once("../DB_Files/db.php");

    if(isset($_POST['Q_id'])) {
        $qid = $_POST['Q_id'];
        $sql = "SELECT A_id, A_body, likes, a_timestamp, s.stu_name,s.stu_img 
                FROM Answers a
                JOIN students s ON a.A_stu_id = s.stu_id
                WHERE a.Q_id = $qid
                ORDER BY a.a_timestamp DESC";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // Output answers
            echo '<div class="container mb-4">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Answers</h5>';
            while ($row = $result->fetch_assoc()) {
                echo '
                <div class="card mb-3">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle overflow-hidden" style="width: 50px; height: 50px; margin-right: 10px;">
                            <img src="' . $row["stu_img"] . '" alt="Student Image" class="img-fluid rounded-circle">
                        </div>
                        <div>
                            <p class="mb-1"><strong>' . $row["stu_name"] . '</strong></p>
                            <p class="mb-0 text-muted">' . $row["a_timestamp"] . '</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="card-text">A_id: ' . $row["A_id"] . '</p>
                        <p class="card-text">Answer: ' . $row["A_body"] . '</p>
                        <p class="card-text">Likes: <span id="likes_' . $row["A_id"] . '">' . $row["likes"] . '</span></p>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-success like-btn" data-answer-id="' . $row["A_id"] . '">
                                <i class="fas fa-thumbs-up"></i> Like
                            </button>
                            <button type="button" class="btn btn-fail unlike-btn" data-answer-id="' . $row["A_id"] . '">
                                <i class="fas fa-thumbs-down"></i> Unlike
                            </button>
                        </div>
                    </div>
                </div>';
            }
            echo '</div></div></div>';
            echo '<div class="container" id="answer-form-container">
                    <form name="form3" id="answer-form" method="POST">
                        <input type="hidden" name="Q_id" value="' . $qid . '">
                        <div class="form-group">
                            <label for="answer">Your Answer:</label>
                            <textarea class="form-control" id="answer" name="answer" rows="3" maxlength="100"></textarea>
                            <small class="form-text text-muted">Maximum 100 characters allowed.</small>
                        </div>
                        <button type="button" class="btn btn-primary" id="submit-answer-btn">Submit Answer</button>
                        <div id="feedback-message"></div>
                    </form>
                </div>';
        } else {
            // No answers, display invitation to add answer
            echo '<div class="container">
                    <p>No answers for this question.</p>
                    <p>Be the first to answer!</p>
                    <div id="answer-form-container">
                        <form name="form3" id="answer-form" method="POST">
                            <input type="hidden" name="Q_id" value="' . $qid . '">
                            <div class="form-group">
                                <label for="answer">Your Answer:</label>
                                <textarea class="form-control" id="answer" name="answer" rows="3" maxlength="100"></textarea>
                                <small class="form-text text-muted">Maximum 100 characters allowed.</small>
                            </div>
                            <button type="button" class="btn btn-primary" id="submit-answer-btn">Submit Answer</button>
                            <div id="feedback-message"></div>
                        </form>
                    </div>
                </div>';
        }
    }

    $conn->close();
    ?>

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- JavaScript code -->
    <script>
        $(document).ready(function(){
            // Like button click event
            $(document).on('click', '.like-btn', function(){
                var A_id = $(this).data('answer-id');
                $.ajax({
                    type: 'POST',
                    url: 'like.php',
                    data: {A_id: A_id},
                    success: function(response){
                        if(response === 'success') {
                            var likes = parseInt($('#likes_' + A_id).text());
                            $('#likes_' + A_id).text(likes + 1);
                        } else {
                            alert(response); // Display error message
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText); // Log error
                    }
                });
            });

            // Unlike button click event
            $(document).on('click', '.unlike-btn', function(){
                var A_id = $(this).data('answer-id');
                $.ajax({
                    type: 'POST',
                    url: 'unlike.php',
                    data: {A_id: A_id},
                    success: function(response){
                        if(response === 'success') {
                            var likes = parseInt($('#likes_' + A_id).text());
                            $('#likes_' + A_id).text(likes - 1); // Decrease like count
                        } else {
                            alert(response); // Display error message
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error: ', status, error); // Log detailed error information
                    }
                });
            });

            // Submit answer form
            $('#submit-answer-btn').click(function(){
                console.log("Submit Answer button clicked"); // Add this line for logging
                $.ajax({
                    type: 'POST',
                    url: 'submit-answer.php',
                    data: $('#answer-form').serialize(),
                    success: function(response){
                        $('#feedback-message').html(response); // Display feedback message
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error: ', status, error); // Log detailed error information
                    }
                });
            });

        });
    </script>
</body>
</html>
