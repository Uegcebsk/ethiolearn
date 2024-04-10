<?php
include_once("../DB_Files/db.php");
include_once("ProfileHeader.php");

$link = isset($_REQUEST['link']) ? $_REQUEST['link'] : '';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watch Lesson</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .video-container {
            position: relative;
            width: 100%;
            padding-top: 56.25%; /* 16:9 Aspect Ratio (divide 9 by 16 = 0.5625) */
        }
        .video-container iframe,
        .video-container video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        .progress-bar {
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Watch Lesson</div>

                <div class="card-body">
                    <?php
                    if (!empty($link)) {
                        $sql = "SELECT * FROM lesson WHERE lesson_link=?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("s", $link);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $row = $result->fetch_assoc();
                        $stmt->close();

                        // Check if the retrieved link is a YouTube embed link
                        if (strpos($row['lesson_link'], 'youtube.com/embed/') !== false) {
                            // Display YouTube video using iframe
                            echo '<div class="video-container">';
                            echo '<iframe id="videoPlayer" width="560" height="315" src="' . $row['lesson_link'] . '" allowfullscreen></iframe>';
                            echo '</div>';
                        } else {
                            // Construct the full file path
                            $videoPath = '../instructor/' . $row['lesson_link'];

                            // Check if the file exists
                            if (file_exists($videoPath) && pathinfo($videoPath, PATHINFO_EXTENSION) === 'mp4') {
                                // Display local video file
                                echo '<h4 class="card-title">' . $row['lesson_name'] . '</h4>';
                                echo '<div class="video-container">';
                                echo '<video id="videoPlayer" controls><source src="' . $videoPath . '" type="video/mp4"></video>';
                                echo '</div>';
                            } else {
                                // Display error message for unsupported video link
                                echo '<p class="text-danger">Unsupported video link.</p>';
                            }
                        }
                    } else {
                        echo '<p class="text-danger">No lesson link provided.</p>';
                    }
                    ?>
                </div>

                <div class="card-footer text-muted">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="progress mt-2">
                                <div id="progressBar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <button id="playPauseBtn" class="btn btn-primary me-2">Play</button>
                            <button id="muteUnmuteBtn" class="btn btn-secondary me-2">Mute</button>
                            <button id="fullscreenBtn" class="btn btn-info">Fullscreen</button>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <textarea id="commentArea" class="form-control" placeholder="Add your comment here..." rows="3"></textarea>
                            <button id="postCommentBtn" class="btn btn-success mt-2">Post Comment</button>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <h5>Comments</h5>
                            <div id="commentsSection"></div>
                        </div>
                        
                        <a href="WatchList.php?course_id=<?php echo $row['course_id'] ?>" class="btn btn-primary">Back to Course</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Function to send completion status to backend
    function sendCompletionStatus() {
        // Calculate completion percentage (set to 100% when the video ends)
        const completionPercentage = 100;

        // Send completion status to backend via AJAX
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'update_completion_status.php', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.onload = function() {
            if (xhr.status === 200) {
                console.log('Completion status updated successfully.');
            } else {
                console.error('Failed to update completion status.');
            }
        };
        xhr.send(JSON.stringify({ lesson_id: <?php echo $row['lesson_id']; ?>, completion_percentage: completionPercentage }));
    }

    // When the video ends, send completion status
    const videoPlayer = document.getElementById('videoPlayer'); // Assuming you have a video player element with ID 'videoPlayer'
    if (videoPlayer) {
        videoPlayer.addEventListener('ended', function() {
            sendCompletionStatus();
        });
    }
</script>

<script>
    // Function to send video progress to backend
    function sendVideoProgress(progress) {
        // Send video progress to backend via AJAX
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'video_progress.php', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.onload = function() {
            if (xhr.status === 200) {
                console.log('Video progress updated successfully.');
            } else {
                console.error('Failed to update video progress.');
            }
        };
        xhr.send(JSON.stringify({ lesson_id: <?php echo $row['lesson_id']; ?>, progress: progress }));
    }

    // When the video pauses or stops, send video progress
    const videoPlayer = document.getElementById('videoPlayer'); // Assuming you have a video player element with ID 'videoPlayer'
    let lastProgress = 0;
    if (videoPlayer) {
        videoPlayer.addEventListener('pause', function() {
            const progress = (videoPlayer.currentTime / videoPlayer.duration) * 100;
            if (progress > lastProgress) {
                sendVideoProgress(progress);
                lastProgress = progress;
            }
        });

        videoPlayer.addEventListener('ended', function() {
            const progress = 100;
            sendVideoProgress(progress);
            lastProgress = progress;
        });
    }

    // Function to display stored video progress
    function displayVideoProgress() {
        // Retrieve stored video progress from backend via AJAX
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'video_progress.php?lesson_id=<?php echo $row['lesson_id']; ?>', true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                const progress = JSON.parse(xhr.responseText).progress;
                // Update video player progress bar or display progress percentage as needed
                console.log('Stored video progress retrieved:', progress);
            } else {
                console.error('Failed to retrieve stored video progress.');
            }
        };
        xhr.send();
    }

    // Call function to display stored video progress when the page loads
    window.addEventListener('load', function() {
        displayVideoProgress();
    });
</body>
</html>
<script src="/ethiolearn/bootstrap/jsbootstrap.bundle.min.js"></script>
<script>
    // Video player
    const videoPlayer = document.getElementById('videoPlayer');
    const progressBar = document.getElementById('progressBar');
    const playPauseBtn = document.getElementById('playPauseBtn');
    const muteUnmuteBtn = document.getElementById('muteUnmuteBtn');
    const fullscreenBtn = document.getElementById('fullscreenBtn');

    // Play/Pause button functionality
    playPauseBtn.addEventListener('click', function() {
        if (videoPlayer.paused || videoPlayer.ended) {
            videoPlayer.play();
            playPauseBtn.textContent = 'Pause';
        } else {
            videoPlayer.pause();
            playPauseBtn.textContent = 'Play';
        }
    });

    // Mute/Unmute button functionality
    muteUnmuteBtn.addEventListener('click', function() {
        if (videoPlayer.muted) {
            videoPlayer.muted = false;
            muteUnmuteBtn.textContent = 'Mute';
        } else {
            videoPlayer.muted = true;
            muteUnmuteBtn.textContent = 'Unmute';
        }
    });

    // Fullscreen button functionality
    fullscreenBtn.addEventListener('click', function() {
        if (videoPlayer.requestFullscreen) {
            videoPlayer.requestFullscreen();
        } else if (videoPlayer.webkitRequestFullscreen) {
            videoPlayer.webkitRequestFullscreen();
        } else if (videoPlayer.msRequestFullscreen) {
            videoPlayer.msRequestFullscreen();
        }
    });

    // Update progress bar as the video plays
    videoPlayer.addEventListener('timeupdate', function() {
        const progress = (videoPlayer.currentTime / videoPlayer.duration) * 100;
        progressBar.style.width = progress + '%';
    });

    // Post comment functionality
    const commentArea = document.getElementById('commentArea');
    const postCommentBtn = document.getElementById('postCommentBtn');
    const commentsSection = document.getElementById('commentsSection');

    postCommentBtn.addEventListener('click', function() {
        const comment = commentArea.value.trim();
        if (comment !== '') {
            const commentElement = document.createElement('div');
            commentElement.classList.add('alert', 'alert-info', 'mt-2');
            commentElement.textContent = comment;
            commentsSection.appendChild(commentElement);
            commentArea.value = ''; // Clear the comment area after posting
        }
    });
</script>

</body>
</html>
