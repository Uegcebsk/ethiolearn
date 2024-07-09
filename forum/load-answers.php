<?php
include_once("../DB_Files/db.php");

if (isset($_POST['Q_id'])) {
    $qid = $_POST['Q_id'];
    $sql = "SELECT A_id, A_body, likes, a_timestamp, s.stu_name, s.stu_img 
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
                    <p class="card-text">Answer: ' . $row["A_body"] . '</p>
                    <p class="card-text">Likes: <span id="likes_' . $row["A_id"] . '">' . $row["likes"] . '</span></p>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-success like-btn" data-answer-id="' . $row["A_id"] . '">
                            <i class="fas fa-thumbs-up"></i> Like
                        </button>
                        <button type="button" class="btn btn-danger unlike-btn" data-answer-id="' . $row["A_id"] . '">
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
                            <textarea class="form-control" id="answer" name="answer" rows="3" maxlength="300"></textarea>
                            <small class="form-text text-muted">Maximum 300 characters allowed.</small>
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

<script>
$(document).ready(function(){
    // Function to load partial answers for a question
    $(".show-answers").click(function(){
        var qid = $(this).data("qid");
        var containerId = "#answers-container-" + qid;

        // Toggle visibility of answers container
        $(containerId).toggle();

        // If the container is visible, load answers
        if ($(containerId).is(":visible")) {
            $.ajax({
                url: "load-answers.php",
                method: "POST",
                data: { Q_id: qid },
                success: function(data) {
                    $(containerId).html(data);
                }
            });
        }
    });

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
  // Submit answer form
$(document).on('click', '#submit-answer-btn', function(){
    var form = $(this).closest('form');
    var qid = form.find('input[name="Q_id"]').val();
    var containerId = "#answers-container-" + qid;

    // Disable the submit button to prevent multiple submissions
    $(this).prop('disabled', true);

    $.ajax({
        type: 'POST',
        url: 'submit-answer.php',
        data: form.serialize(),
        success: function(response){
            $('#feedback-message').html(response); // Display feedback message
            
            if (response.trim() === 'success') {
                // Clear the form inputs
                form[0].reset();

                // Reload the answers to include the new one
                $.ajax({
                    url: 'load-answers.php',
                    method: 'POST',
                    data: { Q_id: qid },
                    success: function(data) {
                        $(containerId).html(data);
                    }
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error: ', status, error); // Log detailed error information
        },
        complete: function() {
            // Re-enable the submit button after request completes
            $('#submit-answer-btn').prop('disabled', false);
        }
    });
});

});
</script>
