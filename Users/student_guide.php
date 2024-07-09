<?php
include_once("ProfileHeader.php");
include_once("../DB_Files/db.php");
if (!isset($_SESSION['stu_id'])) {
    header('Location:../index.php');
}

// Include fetch_notification_count.php to get the notification count
include_once("fetch_notification_count.php");

$stu_email = $_SESSION['stu_email'];
if (isset($stu_email)) {
    $sql = "SELECT stu_img FROM students WHERE stu_email='$stu_email'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $stu_img = $row['stu_img'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>New Student Guide</title>
    <link rel="stylesheet" href="/ethiolearn/instructor/style.css">
    <link rel="stylesheet" href="https://unpkg.com/shepherd.js/dist/css/shepherd.css"> <!-- Shepherd CSS -->
    <!-- Add your custom CSS styles -->
    <style>
        /* Your custom CSS styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .section {
            margin-bottom: 40px;
        }
        .section h2 {
            margin-bottom: 10px;
        }
        .section p {
            line-height: 1.6;
        }
        .shepherd-content {
            max-width: 600px;
        }
    </style>
</head>
<body>

    <div class="main-content">
        <header>
            <!-- Your header content here -->
        </header>

        <div class="container">
            <h1>New Student Guide</h1>

            <div class="section" id="navigation-instructions">
                <h2>Navigation Instructions</h2>
                <p>Welcome to Ethio Learn! Here's a guide to help you navigate through the platform.</p>
            </div>

            <div class="section" id="description-contents">
                <h2>Description of Contents</h2>
                <p>Here's a brief overview of what you can find in each section.</p>
            </div>

            <!-- Add more sections as needed -->

            <!-- Button to start the tour -->
            <button id="start-tour">Start Tour</button>
        </div>

    
    </div>

    <script src="https://unpkg.com/shepherd.js"></script> <!-- Shepherd JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize Shepherd
            var tour = new Shepherd.Tour({
                defaultStepOptions: {
                    scrollTo: true,
                    cancelIcon: true
                }
            });

            // Add steps to the tour
            tour.addStep({
                id: 'navigation-instructions-step',
                text: 'Welcome to the New Student Guide! This guide will help you navigate through the platform.',
                attachTo: {
                    element: '#navigation-instructions',
                    on: 'bottom'
                },
                buttons: [
                    {
                        text: 'Next',
                        action: tour.next
                    }
                ]
            });

            tour.addStep({
                id: 'description-contents-step',
                text: 'Here, you can find a brief overview of what you can find in each section of the platform.',
                attachTo: {
                    element: '#description-contents',
                    on: 'bottom'
                },
                buttons: [
                    {
                        text: 'Next',
                        action: tour.next
                    },
                    {
                        text: 'End Tour',
                        action: tour.cancel
                    }
                ]
            });

            // Start the tour when the "Start Tour" button is clicked
            document.getElementById('start-tour').addEventListener('click', function () {
                tour.start();
            });
        });
    </script>

</body>
</html>
