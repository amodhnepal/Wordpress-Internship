document.addEventListener("DOMContentLoaded", function () {
    var swiperContainer = document.querySelector(".swiper-container");
    if (swiperContainer) {
        var swiper = new Swiper(".swiper-container", {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            effect: "slide",
            speed: 500,
        });
    }
});

// Testimonial Slider
document.addEventListener("DOMContentLoaded", function () {
    const slides = document.querySelectorAll(".testimonial-slide");
    const prevBtn = document.getElementById("prevTestimonial");
    const nextBtn = document.getElementById("nextTestimonial");
    const prevImage = document.getElementById("prevImage");
    const nextImage = document.getElementById("nextImage");

    if (slides.length === 0 || !prevBtn || !nextBtn || !prevImage || !nextImage) return;

    let currentIndex = 0;

    function updateSlider() {
        slides.forEach((slide, index) => {
            slide.style.transform = `translateX(-${currentIndex * 100}%)`;
        });

        const prevIndex = (currentIndex - 1 + slides.length) % slides.length;
        const nextIndex = (currentIndex + 1) % slides.length;

        if (slides[prevIndex] && slides[nextIndex]) {
            prevImage.src = slides[prevIndex].querySelector(".testimonial-img img")?.src || "";
            nextImage.src = slides[nextIndex].querySelector(".testimonial-img img")?.src || "";
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

// About Us Page Slider
document.addEventListener("DOMContentLoaded", function () {
    let thumbnails = document.querySelectorAll(".thumbnail");
    let mainImage = document.getElementById("mainImage");
    let mainTitle = document.querySelector(".director-content-container h1");
    let mainDesc = document.querySelector(".director-content-container p:first-of-type");
    let mainContent = document.querySelector(".director-content-container p:last-of-type");
    let prevBtn = document.querySelector(".prev-btn");
    let nextBtn = document.querySelector(".next-btn");

    if (!thumbnails.length || !mainImage || !mainTitle || !mainDesc || !mainContent || !prevBtn || !nextBtn) return;

    let data = [];
    thumbnails.forEach((thumb, index) => {
        data.push({
            imgSrc: thumb.getAttribute("data-img"),
            title: thumb.getAttribute("data-title"),
            description: thumb.getAttribute("data-desc"),
            content: thumb.getAttribute("data-content"),
        });

        thumb.addEventListener("click", function () {
            updateMainContent(index);
        });
    });

    let currentIndex = 0;

    function updateMainContent(index) {
        if (data[index]) {
            mainImage.src = data[index].imgSrc || "";
            mainTitle.textContent = data[index].title || "";
            mainDesc.textContent = data[index].description || "";
            mainContent.textContent = data[index].content || "";

            thumbnails.forEach((img) => img.classList.remove("active"));
            thumbnails[index].classList.add("active");
            currentIndex = index;
        }
    }

    prevBtn.addEventListener("click", function () {
        let newIndex = (currentIndex - 1 + data.length) % data.length;
        updateMainContent(newIndex);
    });

    nextBtn.addEventListener("click", function () {
        let newIndex = (currentIndex + 1) % data.length;
        updateMainContent(newIndex);
    });

    updateMainContent(0);
    
});

document.addEventListener("DOMContentLoaded", function () {
    function animateCounter(element, target) {
        let start = 0;
        let duration = 2000; // Animation duration in milliseconds
        let stepTime = Math.abs(Math.floor(duration / target));

        let counter = setInterval(() => {
            start += 1;
            element.querySelector(".counter-number").textContent = start; // Update only the number
            if (start >= target) {
                clearInterval(counter);
            }
        }, stepTime);
    }

    function startCounters() {
        document.querySelectorAll(".counter-box h2").forEach(counter => {
            let fullText = counter.innerHTML.trim(); // Get full text
            let targetValue = parseInt(fullText.replace(/\D/g, ""), 10); // Extract only numbers

            // Wrap the number inside a span for easy targeting
            counter.innerHTML = fullText.replace(targetValue, `<span class="counter-number">${targetValue}</span>`);
            
            animateCounter(counter, targetValue);
        });
    }

    // Intersection Observer to detect when the counter section is in view
    let counterSection = document.querySelector(".counter-section");
    let observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                startCounters();
                observer.unobserve(entry.target); // Run only once
            }
        });
    }, { threshold: 0.5 });

    if (counterSection) {
        observer.observe(counterSection);
    }
});

