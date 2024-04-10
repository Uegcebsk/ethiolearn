// testimonials.js

document.addEventListener("DOMContentLoaded", function() {
    const testimonialList = document.querySelector(".testimonial-list");
    const navigationBubbles = document.querySelector(".navigation-bubbles");
    const testimonials = testimonialList.children;

    // Get the number of testimonials
    const numTestimonials = testimonials.length;

    // Generate and append navigation bubbles
    for (let i = 0; i < numTestimonials; i++) {
        const bubble = document.createElement("span");
        bubble.classList.add("bubble");
        bubble.dataset.index = i;
        navigationBubbles.appendChild(bubble);
    }

    // Make the first bubble active initially
    navigationBubbles.children[0].classList.add("active");

    // Add event listener to each bubble for navigation
    navigationBubbles.addEventListener("click", function(event) {
        const bubble = event.target;
        if (bubble.classList.contains("bubble")) {
            // Remove active class from all bubbles
            Array.from(this.children).forEach(bubble => {
                bubble.classList.remove("active");
            });

            // Add active class to the clicked bubble
            bubble.classList.add("active");

            // Scroll to the corresponding testimonial
            const index = parseInt(bubble.dataset.index);
            testimonials[index].scrollIntoView({
                behavior: "smooth",
                block: "start"
            });
        }
    });
});
