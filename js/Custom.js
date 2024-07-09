document.addEventListener('DOMContentLoaded', () => {
    // Show/hide FAQ
    const faqs = document.querySelectorAll('.faq');
    faqs.forEach(faq => {
        faq.addEventListener('click', () => {
            faq.classList.toggle('open');
            // Change icon
            const icon = faq.querySelector('.faq__icon i');
            if (icon.className === 'uil uil-plus') {
                icon.className = 'uil uil-minus';
            } else {
                icon.className = 'uil uil-plus';
            }
        });
    });

    // Instructor/Admin login toggle
    const showInstructorLoginBtn = document.getElementById('show-instructor-login');
    const showAdminLoginBtn = document.getElementById('show-admin-login');
    const container = document.querySelector('.container');

    showInstructorLoginBtn.addEventListener('click', () => {
        container.classList.remove('right-panel-active');
    });

    showAdminLoginBtn.addEventListener('click', () => {
        container.classList.add('right-panel-active');
    });

    // Email Check
    $(document).ready(function() {
        $('.checking_email').keyup(function(e) {
            var email = $('.checking_email').val();

            $.ajax({
                type: "POST",
                url: "DB_Files/EmailChecking.php",
                data: {
                    "check_submit_btn": 1,
                    "email_id": email,
                },
                success: function(response) {
                    $('.error_email').text(response);
                }
            });
        });
    });
});
