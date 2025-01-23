// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function () {
    scrollFunction()
};

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("movetop").style.display = "block";
    } else {
        document.getElementById("movetop").style.display = "none";
    }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}

$(document).ready(function () {
    $('.owl-three').owlCarousel({
        loop: true,
        stagePadding: 20,
        margin: 20,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplaySpeed: 1000,
        autoplayHoverPause: false,
        nav: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            991: {
                items: 3
            },
            1200: {
                items: 4
            }
        }
    })
});


$(window).on("scroll", function () {
    var scroll = $(window).scrollTop();

    if (scroll >= 80) {
        $("#site-header").addClass("nav-fixed");
    } else {
        $("#site-header").removeClass("nav-fixed");
    }
});

//Main navigation Active Class Add Remove
$(".navbar-toggler").on("click", function () {
    $("header").toggleClass("active");
});
$(document).on("ready", function () {
    if ($(window).width() > 991) {
        $("header").removeClass("active");
    }
    $(window).on("resize", function () {
        if ($(window).width() > 991) {
            $("header").removeClass("active");
        }
    });
});



$(window).on("scroll", function () {
    var scroll = $(window).scrollTop();

    if (scroll >= 80) {
        $("#site-header").addClass("nav-fixed");
    } else {
        $("#site-header").removeClass("nav-fixed");
    }
});

//Main navigation Active Class Add Remove
$(".navbar-toggler").on("click", function () {
    $("header").toggleClass("active");
});
$(document).on("ready", function () {
    if ($(window).width() > 991) {
        $("header").removeClass("active");
    }
    $(window).on("resize", function () {
        if ($(window).width() > 991) {
            $("header").removeClass("active");
        }
    });
});

//whenever we load the page, always display the first slide
var currentSlide = 0

//here we set how many slides we have using the .length property
//this is useful because we can use it as our max slide value
var totalSlides = $('.holder div').length


// 1. a function that deals with taking us to the next slide
var nextSlide = function(){
// increment our currentSlide value by reassigning it and increlenting 	   it by 1
  currentSlide = currentSlide + 1

  //a continuacion ponemos este codigo para que nuestras slides y numeros no sigan avanzando cuando lleguen a la 4ta
  //
  if(currentSlide >= totalSlides){
    currentSlide = 0
  }
// we are going to turn our currentSlide value into a negative vw unit
  var leftPosition = (-currentSlide * 100)  + 'vw'
// here we add the 'vw' unit into the end

// pass the vw unit into our css method below
//here we grab the holder and change it to the second slide
  $('.holder').css('left', leftPosition)

var slideNumber = currentSlide + 1
// here we set the text for the steps using currentSlide and total nubmer
$('.steps').text(slideNumber + ' / ' + totalSlides)
}

//2. a function that deals with taking us to the previous slide

var previousSlide = function(){
 //this is identical to our nextSlide function, apart from that we are decrementing the currentSlide value (taking us back rather than fowards)
  currentSlide = currentSlide - 1

 //a continuacion ponemos este codigo para que nuestras slides y numeros no sigan retrocediendo cuando lleguen al 0
 //
 if(currentSlide < 0){
    currentSlide = totalSlides - 1
 }

  var leftPosition = (-currentSlide * 100)  + 'vw'
  $('.holder').css('left', leftPosition)

var slideNumber = currentSlide + 1
// here we set the text for the steps using currentSlide and total nubmer
$('.steps').text(slideNumber + ' / ' + totalSlides)
}

//setInterval allows us to run a function every x amount of time
var autoSlide = setInterval(function(){
// here our nextSlide function will be run
nextSlide()
// runs every 3seconds (3000ms)
}, 3000)

//we also have setTimeout, wich is the same, but runs only once

$('.next').on('click', function(){
  //this is going to cancel our autoSlide interval function
  //as the user has taken over control of the slideshow
  clearInterval(autoSlide)
  // here we call the nextSlide function and fo to the next slide
  nextSlide()
})


$('.prev').on('click', function(){
  clearInterval(autoSlide)
  previousSlide()
})

$('body').on('keydown', function(event){
  var keyCode = event.keyCode
  if(keyCode ==37){
    clearInterval(autoSlide)
    previousSlide()
  }
   if(keyCode ==39){
    clearInterval(autoSlide)
    nextSlide()
   }
})
