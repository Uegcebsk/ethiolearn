$(document).ready(function() {
    // Function to load messages
    function loadMessages() {
        $.ajax({
            url: 'get_messages.php',
            type: 'GET',
            success: function(response) {
                $('#messages-container').html(response);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    // Load messages when the page is loaded
    loadMessages();

    // Function to send message
    $('#message-form').submit(function(e) {
        e.preventDefault(); // Prevent form submission

        var messageContent = $('#message-input').val().trim();
        if (messageContent !== '') {
            $.ajax({
                url: 'send_message.php',
                type: 'POST',
                data: {
                    message_content: messageContent,
                    receiver_id: $('#receiver-id').val() // Get receiver ID from hidden input
                },
                success: function(response) {
                    $('#message-input').val('');
                    loadMessages(); // Reload messages after sending
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    });

    // Auto refresh messages every 5 seconds
    setInterval(loadMessages, 5000);
});
