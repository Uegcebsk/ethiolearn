  document.addEventListener("DOMContentLoaded", function() {
        // Select all dropdown toggles and menus
        var dropdownToggles = document.querySelectorAll('.dropdown-toggle');
        var dropdownMenus = document.querySelectorAll('.dropdown-menu');

        // Function to open dropdown
        function openDropdown(index) {
            dropdownMenus[index].style.display = 'block';
        }

        // Function to close dropdown
        function closeDropdown(index) {
            dropdownMenus[index].style.display = 'none';
        }

        // Add event listeners for each dropdown
        dropdownToggles.forEach(function(toggle, index) {
            var menu = dropdownMenus[index];

            toggle.addEventListener('mouseenter', function() {
                openDropdown(index);
            });

            toggle.addEventListener('mouseleave', function() {
                closeDropdown(index);
            });

            menu.addEventListener('mouseenter', function() {
                openDropdown(index);
            });

            menu.addEventListener('mouseleave', function() {
                closeDropdown(index);
            });
        });
    });
