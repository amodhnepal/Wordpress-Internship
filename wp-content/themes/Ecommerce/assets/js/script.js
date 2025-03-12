var swiper = new Swiper(".mySwiper", {
    loop:true,
    // autoplay: {
    //                 delay: 0,
    //                 disableOnInteraction: false,
    //             },
    speed:2000,
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
      
    },
  });


  // Splide scroll
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

  


jQuery(document).ready(function ($) {
  $(".add-to-cart-btn").on("click", function (e) {
      e.preventDefault();

      var product_id = $(this).attr("data-product-id");
      var button = $(this);

      $.ajax({
          type: "POST",
          url: wc_add_to_cart_params.ajax_url,
          data: {
              action: "woocommerce_ajax_add_to_cart",
              product_id: product_id,
          },
          beforeSend: function () {
              button.text("Adding...");
          },
          success: function (response) {
              if (response.success) {
                  button.text("Added ✓").prop("disabled", true);
                  $(".cart-count").text(response.cart_count); // Update cart count
              } else {
                  button.text("Failed ❌");
              }
          },
      });
  });
});

