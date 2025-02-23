document.addEventListener("DOMContentLoaded", function () {
    // Hero Slider Initialization
    var heroSwiper = new Swiper(".banner-slider", {
        slidesPerView: 1,
        spaceBetween: 0,
        loop: true,
        speed: 800, // Smooth sliding speed
        autoplay: {
            delay: 3500, // Faster slide changes
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });

    // Logo Slider Initialization with smooth scrolling
    var swiperContainer = document.querySelector(".swiper-wrapper");
    var slides = Array.from(swiperContainer.children);

    // Duplicate slides to create a seamless loop
    slides.forEach((slide) => {
        let clone = slide.cloneNode(true);
        swiperContainer.appendChild(clone);
    });

    var smoothSwiper = new Swiper(".swiper-container", {
        speed: 2000, // Adjust speed for smoother scrolling
        loop: true, // Enable infinite looping
        autoplay: {
            delay: 0, // No delay, continuous scrolling
            disableOnInteraction: false,
        },
        slidesPerView: "auto", // Adjusts to content width
        spaceBetween: 40, // Increased space between logos
        freeMode: true, // Ensures no snapping
        centeredSlides: false, // Ensures smooth scrolling
    });
});
