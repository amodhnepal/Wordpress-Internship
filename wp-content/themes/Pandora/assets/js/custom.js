document.addEventListener('DOMContentLoaded', function () {
    var splide = new Splide('#product-slider', {
        type: 'slide', // No infinite loop
        perPage: 4, // Number of visible products
        perMove: 1, // Move one at a time
        autoplay: false, // Disable autoplay
        arrows: true, // Enable arrows
        pagination: false, // Hide pagination dots
        breakpoints: {
            1024: { perPage: 3 },
            768: { perPage: 2 },
            480: { perPage: 1 }
        }
    });

    splide.mount();
});
