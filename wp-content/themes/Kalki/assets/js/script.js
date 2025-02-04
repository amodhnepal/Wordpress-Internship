
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

        prevImage.src = slides[prevIndex].querySelector(".testimonial-img img").src;
        nextImage.src = slides[nextIndex].querySelector(".testimonial-img img").src;
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



