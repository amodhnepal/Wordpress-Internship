
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
document.addEventListener('DOMContentLoaded', function () {
    const prevButton = document.querySelector('.prev-slide');
    const nextButton = document.querySelector('.next-slide');
    const slider = document.querySelector('.team-member-display');
    const slides = document.querySelectorAll('.team-member');

    // Debugging statements to check if elements are selected correctly
    console.log('prevButton:', prevButton);
    console.log('nextButton:', nextButton);
    console.log('slider:', slider);
    console.log('slides:', slides);

    if (!prevButton || !nextButton || !slider || slides.length === 0) {
        console.error('One or more elements are missing. Slider functionality will not work.');
        return;
    }

    let currentIndex = 0;

    function showSlide(index) {
        console.log('Showing slide:', index); // Debugging statement
        slides.forEach((slide, i) => {
            slide.classList.toggle('active', i === index);
        });
    }

    prevButton.addEventListener('click', function () {
        console.log('Previous button clicked'); // Debugging statement
        currentIndex = (currentIndex > 0) ? currentIndex - 1 : slides.length - 1;
        showSlide(currentIndex);
    });

    nextButton.addEventListener('click', function () {
        console.log('Next button clicked'); // Debugging statement
        currentIndex = (currentIndex < slides.length - 1) ? currentIndex + 1 : 0;
        showSlide(currentIndex);
    });

    // Initialize the first slide
    showSlide(currentIndex);
});