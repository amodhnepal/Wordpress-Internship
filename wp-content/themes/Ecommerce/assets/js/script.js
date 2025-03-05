var swiper = new Swiper(".mySwiper", {
    loop:true,
    // autoplay: {
    //                 delay: 0,
    //                 disableOnInteraction: false,
    //             },
    speed:4000,
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
      
    },
  });
document.addEventListener('DOMContentLoaded', function () {
    new Splide('#logo-slider', {
      type   : 'loop', // Infinite Loop
      perPage: 5, // Number of logos visible at a time
      perMove: 1, // Move one item at a time
      autoplay: true, // Auto-scroll
      interval: 0, // Delay between slides
      pauseOnHover: false, // Keep playing on hover
      arrows: false, // Hide arrows
      pagination: false, // Hide dots
      speed: 20000, // Transition speed
      easing: 'linear', // Built-in easing function
      breakpoints: {
        1024: { perPage: 4 },
        768: { perPage: 3 },
        480: { perPage: 2 }
        }
    }).mount();
});

  


    
