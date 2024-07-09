// exam_security.js

// Disable copy-pasting
document.addEventListener('copy', function(e) {
    e.preventDefault(); // Prevent default copy behavior
});
document.addEventListener('cut', function(e) {
    e.preventDefault(); // Prevent default cut behavior
});
document.addEventListener('paste', function(e) {
    e.preventDefault(); // Prevent default paste behavior
});

// Disable right-clicking
document.addEventListener('contextmenu', function(e) {
    e.preventDefault(); // Prevent default right-click context menu
});

// Disable opening new tabs or windows
window.open = function() { /* Do nothing */ };

// Overlay to prevent interaction with page elements
var overlay = document.createElement('div');
overlay.setAttribute('id', 'overlay');
overlay.style.position = 'fixed';
overlay.style.top = '0';
overlay.style.left = '0';
overlay.style.width = '100%';
overlay.style.height = '100%';
overlay.style.backgroundColor = 'rgba(255, 255, 255, 0.9)';
overlay.style.zIndex = '9999';
overlay.style.display = 'none';
document.body.appendChild(overlay);

// Function to show overlay
function showOverlay() {
    overlay.style.display = 'block';
}

// Function to hide overlay
function hideOverlay() {
    overlay.style.display = 'none';
}

// Disable keyboard shortcuts (Ctrl + C, Ctrl + V, Ctrl + X, F12)
document.onkeydown = function(e) {
    if ((e.ctrlKey && (e.keyCode === 67 || e.keyCode === 86 || e.keyCode === 88)) || e.keyCode === 123) {
        return false; // Prevent Ctrl + C, Ctrl + V, Ctrl + X, and F12
    }
};

// Disable inspect element
document.addEventListener('keydown', function(e) {
    if (e.keyCode === 123) {
        e.preventDefault(); // Prevent F12
    }
});

// Disable drag-and-drop
window.addEventListener('dragover', function(e) {
    e.preventDefault(); // Prevent drag-and-drop
});
window.addEventListener('drop', function(e) {
    e.preventDefault(); // Prevent drag-and-drop
});

// Disable mouse right-click context menu
document.addEventListener('contextmenu', function(e) {
    e.preventDefault(); // Prevent default context menu
});

// Disable Ctrl key combinations (e.g., Ctrl + T for new tab, Ctrl + W for close tab)
document.addEventListener('keydown', function(e) {
    if (e.ctrlKey && (e.keyCode === 84 || e.keyCode === 87 || e.keyCode === 76)) {
        e.preventDefault(); // Prevent Ctrl + T, Ctrl + W, Ctrl + L
    }
});

// Disable Alt key combinations (e.g., Alt + Tab for switching windows)
document.addEventListener('keydown', function(e) {
    if (e.altKey && e.keyCode === 9) {
        e.preventDefault(); // Prevent Alt + Tab
    }
});

// Prevent window resizing
window.addEventListener('resize', function() {
    window.resizeTo(screen.width, screen.height); // Keep window size constant
});

// Disable window minimize
window.addEventListener('blur', function() {
    window.focus(); // Keep window focused
});

// Disable window close
window.onbeforeunload = function() {
    return "Are you sure you want to leave the page?";
};
