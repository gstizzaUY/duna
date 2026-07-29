jQuery(document).ready(function ($) {
  $(window).on("scroll", function () {
    if ($(this).scrollTop() > 100) {
      $(".back-to-top a").fadeIn();
    } else {
      $(".back-to-top a").fadeOut();
    }
  });

  $(".back-to-top a").on("click", function (e) {
    e.preventDefault();
    $("html, body").animate({ scrollTop: 0 }, 800);
  });

  $('.banner-right-col .owl-carousel').owlCarousel({
    loop: true,
    margin: 0,
    nav: true,
    dots: false,
    rtl: false,
    autoplay: false,
    items: 1,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
  });

 
  $('.prod-sec-left-col-main .owl-carousel').owlCarousel({
    loop: true,
    margin: 0,
    nav: false,
    dots: true,
    rtl: false,
    items: 1,
    autoplay: false
  });
  
});