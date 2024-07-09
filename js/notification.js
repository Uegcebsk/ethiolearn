
    // Function to check for new messages
    function checkForNewMessages() {
        $.ajax({
            url: 'check_new_messages.php', // The PHP script to check for new messages
            success: function(data) {
                // Check if there are new messages
                if (data > 0) {
                    // Show notification
                    showNotification("New Messages", "You have " + data + " new message(s).");
                }
            }
        });
    }

    // Function to show notification
    function showNotification(title, message) {
        // Check if the browser supports notifications
        if (!("Notification" in window)) {
            alert("This browser does not support desktop notifications.");
        }
        // Check if the user has granted permission to show notifications
        else if (Notification.permission === "granted") {
            var notification = new Notification(title, {
                body: message
            });
        }
        // Otherwise, request permission to show notifications
        else if (Notification.permission !== "denied") {
            Notification.requestPermission().then(function(permission) {
                // If permission is granted, show notification
                if (permission === "granted") {
                    var notification = new Notification(title, {
                        body: message
                    });
                }
            });
        }
    }

    // Periodically check for new messages
    setInterval(checkForNewMessages, 60000); // Check every minute (adjust as needed)

