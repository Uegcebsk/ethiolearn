<?php
include_once("../DB_Files/db.php");
include_once("ProfileHeader.php");

$link = isset($_REQUEST['link']) ? $_REQUEST['link'] : '';
$course_id = isset($_REQUEST['course_id']) ? $_REQUEST['course_id'] : '';
$lesson_id = isset($_REQUEST['lesson_id']) ? $_REQUEST['lesson_id'] : ''; // Retrieve lesson_id

if (empty($link) || empty($course_id) || empty($lesson_id)) {
    header('Location: watchlist.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watch Lesson</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/ethiolearn/Font awesome/webfonts/all.min.css">
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
        .lesson-description {
            margin-top: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .lesson-description h3 {
            margin-bottom: 10px;
            font-size: 22px;
            color: #007bff;
        }
        .lesson-description p {
            font-size: 16px;
            line-height: 1.6;
            color: #333;
        }
        .progress-bar {
            cursor: pointer;
        }
        .seek-bar {
            pointer-events: none;
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
                    $sql = "SELECT * FROM lesson WHERE lesson_link=?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("s", $link);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();
                    $stmt->close();

                    if (strpos($row['lesson_link'], 'youtube.com/embed/') !== false) {
                        echo '<div class="video-container">';
                        echo '<iframe id="videoPlayer" width="560" height="315" src="' . $row['lesson_link'] . '" allowfullscreen></iframe>';
                        echo '</div>';
                    } else {
                        $videoPath = '../instructor/' . $row['lesson_link'];

                        if (file_exists($videoPath) && pathinfo($videoPath, PATHINFO_EXTENSION) === 'mp4') {
                            echo '<h4 class="card-title">' . $row['lesson_name'] . '</h4>';
                            echo '<div class="video-container">';
                            echo '<video id="videoPlayer" controls class="seek-bar"><source src="' . $videoPath . '" type="video/mp4"></video>';
                            echo '</div>';
                        } else {
                            echo '<p class="text-danger">Unsupported video link.</p>';
                        }
                    }
                    ?>
                    
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="progress mt-2">
                                <div id="progressBar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <button id="playPauseBtn" class="btn btn-primary me-2"><i class="fas fa-play"></i></button>
                            <button id="muteUnmuteBtn" class="btn btn-secondary me-2"><i class="fas fa-volume-up"></i></button>
                            <button id="fullscreenBtn" class="btn btn-info"><i class="fas fa-expand"></i></button>
                            <a href="watchlist.php?course_id=<?php echo $course_id; ?>" class="btn btn-success me-2">Back to Watchlist</a>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-muted">
                    <div class="lesson-description">
                        <h3>Lesson Description</h3>
                        <p><?php echo nl2br($row['lesson_description']); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const videoPlayer = document.getElementById('videoPlayer');
    const progressBar = document.getElementById('progressBar');
    let isTrackingProgress = false;
    let progressTimer;

    function startTrackingProgress() {
        isTrackingProgress = true;
        progressTimer = setInterval(updateProgress, 5000);
    }

    function stopTrackingProgress() {
        isTrackingProgress = false;
        clearInterval(progressTimer);
        updateProgress();
    }

    videoPlayer.addEventListener('loadedmetadata', function() {
        progressBar.style.width = '0%';
        startTrackingProgress();
    });

    videoPlayer.addEventListener('play', function() {
        startTrackingProgress();
    });
    
    videoPlayer.addEventListener('pause', function() {
        stopTrackingProgress();
    });

    videoPlayer.addEventListener('ended', function() {
        stopTrackingProgress();
    });

    document.getElementById('playPauseBtn').addEventListener('click', function() {
        if (videoPlayer.paused || videoPlayer.ended) {
            videoPlayer.play();
        } else {
            videoPlayer.pause();
        }
    });

    document.getElementById('muteUnmuteBtn').addEventListener('click', function() {
        if (videoPlayer.muted) {
            videoPlayer.muted = false;
        } else {
            videoPlayer.muted = true;
        }
    });

    document.getElementById('fullscreenBtn').addEventListener('click', function() {
        if (videoPlayer.requestFullscreen) {
            videoPlayer.requestFullscreen();
        } else if (videoPlayer.mozRequestFullScreen) { /* Firefox */
            videoPlayer.mozRequestFullScreen();
        } else if (videoPlayer.webkitRequestFullscreen) { /* Chrome, Safari and Opera */
            videoPlayer.webkitRequestFullscreen();
        } else if (videoPlayer.msRequestFullscreen) { /* IE/Edge */
            videoPlayer.msRequestFullscreen();
        }
    });

    function updateProgress() {
        const lessonId = <?php echo $lesson_id; ?>;
        const courseId = <?php echo $course_id; ?>;
        const studentId = <?php echo $_SESSION['stu_id']; ?>;
        let progress = (videoPlayer.currentTime / videoPlayer.duration) * 100;
        let completed = videoPlayer.ended ? 1 : 0;

        progressBar.style.width = progress + '%';

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'update_lesson_progress.php', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.onload = function() {
            if (xhr.status === 200) {
                console.log('Progress updated successfully.');
            } else {
                console.error('Failed to update progress.');
            }
        };
        xhr.send(JSON.stringify({
            lesson_id: lessonId,
            course_id: courseId,
            student_id: studentId,
            progress: progress,
            completed: completed
        }));
    }

    window.addEventListener('beforeunload', function() {
        if (isTrackingProgress) {
            updateProgress();
        }
    });

    document.querySelector('.btn-success').addEventListener('click', function() {
        if (isTrackingProgress) {
            updateProgress();
        }
    });

    // Disable seeking forward
    videoPlayer.addEventListener('seeking', function() {
        if (videoPlayer.currentTime < videoPlayer.seekable.start(0)) {
            videoPlayer.currentTime = videoPlayer.seekable.start(0);
        }
    });
});
</script>

</body>
</html>
