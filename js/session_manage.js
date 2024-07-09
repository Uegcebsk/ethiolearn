// Set page_open to true in session storage when the page loads
document.addEventListener('DOMContentLoaded', function() {
    // Only set sessionStorage if it's not already set
    if (sessionStorage.getItem('page_open') === null) {
        sessionStorage.setItem('page_open', 'true');
    } else if (sessionStorage.getItem('page_open') === 'true') {
        alert('This page is already open in another tab.');
        window.location.href = 'anotherpage.php'; // Redirect to another page
    }
});

// Set page_open to false in session storage when the page unloads
window.addEventListener('beforeunload', function() {
    sessionStorage.setItem('page_open', 'false');
});
