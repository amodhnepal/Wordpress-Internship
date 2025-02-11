
const slider = document.querySelector('.slider');
const prevBtn = document.getElementById('prev');
const nextBtn = document.getElementById('next');
let scrollAmount = 0;

nextBtn.addEventListener('click', () => {
    scrollAmount += slider.children[0].offsetWidth + 20;
    if (scrollAmount >= slider.scrollWidth - slider.offsetWidth) {
        scrollAmount = 0;
    }
    slider.style.transform = `translateX(-${scrollAmount}px)`;
});

prevBtn.addEventListener('click', () => {
    scrollAmount -= slider.children[0].offsetWidth + 20;
    if (scrollAmount < 0) {
        scrollAmount = slider.scrollWidth - slider.offsetWidth;
    }
    slider.style.transform = `translateX(-${scrollAmount}px)`;
});


// Testimonial
document.addEventListener("DOMContentLoaded", function () {
    const slides = document.querySelectorAll(".testimonial-slide");
    const prevBtn = document.getElementById("prevTestimonial");
    const nextBtn = document.getElementById("nextTestimonial");
    const prevImage = document.getElementById("prevImage");
    const nextImage = document.getElementById("nextImage");

    let currentIndex = 0;
    function updateSlider() {
        slides.forEach((slide, index) => {
            slide.style.transform = `translateX(-${currentIndex * 100}%)`;
        });
    
        const prevIndex = (currentIndex - 1 + slides.length) % slides.length;
        const nextIndex = (currentIndex + 1) % slides.length;
    
        // Ensure prevImage and nextImage exist before updating src
        if (prevImage && nextImage) {
            prevImage.src = slides[prevIndex].querySelector(".testimonial-img img").src;
            nextImage.src = slides[nextIndex].querySelector(".testimonial-img img").src;
        }
    }
    prevBtn.addEventListener("click", function () {
        currentIndex = (currentIndex - 1 + slides.length) % slides.length;
        updateSlider();
    });

    nextBtn.addEventListener("click", function () {
        currentIndex = (currentIndex + 1) % slides.length;
        updateSlider();
    });

    updateSlider();
});






// foooter js

document.addEventListener("DOMContentLoaded", function () {
    const scrollToTop = document.createElement("button");
    scrollToTop.innerText = "↑";
    scrollToTop.id = "scrollToTop";
    document.body.appendChild(scrollToTop);

    window.addEventListener("scroll", function () {
        if (window.scrollY > 200) {
            scrollToTop.style.display = "block";
        } else {
            scrollToTop.style.display = "none";
        }
    });

    scrollToTop.addEventListener("click", function () {
        window.scrollTo({ top: 0, behavior: "smooth" });
    });
});



// About us page slider
document.addEventListener("DOMContentLoaded", function () {
    const teamContainer = document.querySelector(".team-container");
    if (!teamContainer) return;

    let teamMembers = teamContainer.querySelectorAll(".team-member-large");
    let teamTexts = teamContainer.querySelectorAll(".team-member-text");
    let teamThumbnails = teamContainer.querySelectorAll(".team-thumb");
    let prevTeamBtn = teamContainer.querySelector("#prev-btn");
    let nextTeamBtn = teamContainer.querySelector("#next-btn");

    let teamCurrentIndex = 0;

    function updateActiveTeamMember(index) {
        teamMembers.forEach(member => member.classList.remove("active"));
        teamTexts.forEach(text => text.classList.remove("active"));
        teamThumbnails.forEach(thumb => thumb.classList.remove("selected"));

        teamMembers[index]?.classList.add("active");
        teamTexts[index]?.classList.add("active");
        teamThumbnails[index]?.classList.add("selected");
    }

    // Handle Thumbnail Clicks
    teamThumbnails.forEach((thumb, index) => {
        thumb.addEventListener("click", function () {
            teamCurrentIndex = index; 
            updateActiveTeamMember(teamCurrentIndex);
        });
    });

    // ✅ Ensure `prevTeamBtn` and `nextTeamBtn` exist before adding event listeners
    if (prevTeamBtn && nextTeamBtn) {
        prevTeamBtn.addEventListener("click", function () {
            teamCurrentIndex = (teamCurrentIndex - 1 + teamMembers.length) % teamMembers.length;
            updateActiveTeamMember(teamCurrentIndex);
        });

        nextTeamBtn.addEventListener("click", function () {
            teamCurrentIndex = (teamCurrentIndex + 1) % teamMembers.length;
            updateActiveTeamMember(teamCurrentIndex);
        });
    }

    updateActiveTeamMember(teamCurrentIndex);
});