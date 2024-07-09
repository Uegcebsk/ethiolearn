<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watch YouTube Video Lesson</title>
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
        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Watch YouTube Video Lesson</div>

                <div class="card-body">
                    <?php
                    include_once("../DB_Files/db.php");
                    include_once("ProfileHeader.php");

                    $link = isset($_REQUEST['link']) ? $_REQUEST['link'] : '';

                    // Fetching course ID based on the lesson link
                    $courseId = ''; // Initialize courseId variable
                    if (!empty($link)) {
                        $sql = "SELECT course_id FROM lesson WHERE lesson_link=?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("s", $link);
                        $stmt->execute();
                        $stmt->bind_result($courseId);
                        $stmt->fetch();
                        $stmt->close();
                    }

                    if (!empty($link)) {
                        // Check if the retrieved link is a YouTube embed link
                        if (strpos($link, 'youtube.com/embed/') !== false) {
                            // Display YouTube video using iframe
                            echo '<div class="video-container">';
                            echo '<div id="player"></div>'; // 1. The <iframe> (and video player) will replace this <div> tag.
                            echo '</div>';
                            echo '<input type="hidden" id="lessonLink" value="' . $link . '">'; // Hidden input to store lesson link
                        } else {
                            // Display error message for unsupported video link
                            echo '<p class="text-danger">Unsupported video link.</p>';
                        }
                    } else {
                        echo '<p class="text-danger">No lesson link provided.</p>';
                    }
                    ?>
                </div>

                <div class="card-footer text-muted">
                    <?php if (!empty($courseId)): ?>
                        <a href="watchlist.php?course_id=<?php echo $courseId; ?>" class="btn btn-primary">Back to Course</a>
                    <?php else: ?>
                        <p class="text-danger">Unable to determine course ID.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var player;

    // 3. This function creates an <iframe> (and YouTube player) after the API code downloads.
    function onYouTubeIframeAPIReady() {
        var lessonLink = document.getElementById('lessonLink').value; // Get lesson link
        player = new YT.Player('player', {
            height: '390',
            width: '640',
            videoId: lessonLink, // 2. Video ID
            playerVars: {
                'playsinline': 1
            },
            events: {
                'onReady': onPlayerReady,
                'onStateChange': onPlayerStateChange
            }
        });
    }

    // 4. The API will call this function when the video player is ready.
    function onPlayerReady(event) {
        event.target.playVideo();
    }

    // 5. The API calls this function when the player's state changes.
    //    The function indicates that when playing a video (state=1),
    //    the player should play for six seconds and then stop.
    var done = false;
    function onPlayerStateChange(event) {
        if (event.data == YT.PlayerState.PLAYING && !done) {
            setTimeout(stopVideo, 6000);
            done = true;
        }
    }
    function stopVideo() {
        player.stopVideo();
    }
</script>

<!-- 2. This code loads the IFrame Player API code asynchronously. -->
<script src="http://www.youtube.com/iframe_api"></script>

</body>
</html>
