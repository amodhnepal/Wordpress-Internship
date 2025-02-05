
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






// jQuery(document).ready(function($) {
//     var upload_button;
    
//     $(".z_upload_image_button").on('click', function(event) {
//         upload_button = $(this);
//         var frame;
//         if (zci_config.wordpress_ver >= "3.5") {
//             event.preventDefault();
//             if (frame) {
//                 frame.open();
//                 return;
//             }
//             frame = wp.media();
//             frame.on( "select", function() {
//                 // Grab the selected attachment.
//                 var attachment = frame.state().get("selection").first();
//                 var attachmentUrl = attachment.attributes.url;
//                 var attachmentId = attachment.attributes.id;
//                 attachmentUrl = attachmentUrl.replace('-scaled.', '.');

//                 frame.close();
//                 $(".zci-taxonomy-image").attr("src", attachmentUrl);
//                 if (upload_button.parent().prev().children().hasClass("tax_list")) {
//                     upload_button.parent().prev().children().val(attachmentUrl);
//                     upload_button.parent().prev().prev().children().attr("src", attachmentUrl);
//                     upload_button.parent().next().children().val(attachmentId);
//                 }
//                 else {
//                     $("#zci_taxonomy_image").val(attachmentUrl);
//                     $("#zci_taxonomy_image_id").val(attachmentId);
//                 }
//             });
//             frame.open();
//         }
//         else {
//             tb_show("", "media-upload.php?type=image&amp;TB_iframe=true");
//             return false;
//         }
//     });
    
//     $(".z_remove_image_button").on('click', function() {
//         $(".zci-taxonomy-image").attr("src", zci_config.placeholder);
//         $("#zci_taxonomy_image").val("");
//         $(this).parent().siblings(".title").children("img").attr("src", zci_config.placeholder);
//         $(".inline-edit-col :input[name='zci_taxonomy_image']").val("");
//         return false;
//     });
    
//     if (zci_config.wordpress_ver < "3.5") {
//         window.send_to_editor = function(html) {
//             imgurl = $("img",html).attr("src");
//             if (upload_button.parent().prev().children().hasClass("tax_list")) {
//                 upload_button.parent().prev().children().val(imgurl);
//                 upload_button.parent().prev().prev().children().attr("src", imgurl);
//             }
//             else
//                 $("#zci_taxonomy_image").val(imgurl);
//             tb_remove();
//         }
//     }
    
//     $(".editinline").on('click', function() {
//         var tax_id = $(this).parents("tr").attr("id").substr(4);
//         var thumb = $("#tag-"+tax_id+" .thumb img").attr("src");

//         // To Do: fix image input url in quick mode
//         /*if (thumb != zci_config.placeholder) {
//             $(".inline-edit-col :input[name='zci_taxonomy_image']").val(thumb);
//         } else {
//             $(".inline-edit-col :input[name='zci_taxonomy_image']").val("");
//         }*/
        
//         $(".inline-edit-col .title img").attr("src",thumb);
//     });
// });

