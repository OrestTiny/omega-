; (function ($, window, document, undefined) {
  'use strict';

  $(window).on('load', function () {
    if ($('.tsigaras-preloader').length) {
      $('.tsigaras-preloader').fadeOut(50);
    }
  });
  //
  // function calcPaddingMainWrapper() {
  //
  //     if ($('.tsigaras-header').length) {
  //         let header = $('.tsigaras-header');
  //         let paddValue = header.outerHeight();
  //
  //         header.bind('heightChange', function () {
  //             $('body').css('padding-top', paddValue);
  //         });
  //
  //         header.trigger('heightChange');
  //     }
  //
  //     if ($('.tsigaras-footer').length) {
  //         let footer = $('.tsigaras-footer');
  //         let paddValue = footer.outerHeight();
  //
  //         footer.bind('heightChange', function () {
  //             $('body').css('padding-bottom', paddValue);
  //         });
  //
  //         footer.trigger('heightChange');
  //     }
  // }

  function adminBarPositionFix() {
    if ($('#wpadminbar').length) {
      $('#wpadminbar').css('position', 'fixed');
    }
  }


  $(window).on('load resize orientationchange', function () {
    // calcPaddingMainWrapper();
    adminBarPositionFix();
  });

  document.addEventListener("DOMContentLoaded", function () {
    window.scrollTo(window.scrollX, window.scrollY - 1);
    window.scrollTo(window.scrollX, window.scrollY + 1);
  });




  const swiperTestimonials = new Swiper('.tsigaras-footer__form-testimonials .swiper', {
    scrollbar: {
      el: '.tsigaras-footer__form-testimonials .swiper-scrollbar',
      draggable: true,
    },
    autoplay: {
      delay: 3500,
      disableOnInteraction: false,
    },
  });

  if ($(".tsigaras-newsletter")) {
    $(".tsigaras-newsletter").is(function () {
      const th = $(this);
      const btn = $(".tsigaras-newsletter-close", th);
      const days = th.attr('data-days');

      btn.click(function () {
        setCookie("notification", "false", days);
        th.hide();
        isHeadingSpace();
      });
    });
  }

  function setCookie(name, value, days) {
    var expires = "";
    if (days) {
      var date = new Date();
      date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
      expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
  }

  if ($('.menu-image.menu-image-title-after')) {
    $('.menu-image.menu-image-title-after').each(function () {
      const div = $('<div></div>');

      $(this).before(div);
      $(this).appendTo(div);
    })
  }

  if ($('[data-gp-an="fade"]')) {
    $('[data-gp-an="fade"]').each(function () {
      $(this).addClass('isLoad');
    })
  }

  // if ($('.tsigaras-header .menu>.menu-item')) {
  //   $('.tsigaras-header .menu>.menu-item').each(function (index, element) {
  //     setTimeout(() => {
  //       $(this).addClass('isLoad');
  //     }, index * 200);
  //   })
  // }

  if ($('[data-an-fadeup]')) {
    $(window).scroll(function () {
      $('[data-an-fadeup]:not(.isAnimation)').each(function (i) {
        const th = $(this);
        const thSpace = th.offset().top;
        const thHeight = + th.outerHeight();
        const windowSpace = $(window).scrollTop();
        const windowHeight = $(window).height();

        if (windowSpace + windowHeight >= thSpace && thHeight + thSpace >= windowSpace) {
          th.addClass('isAnimation');
        }

      });
    });
  }


  $("#tsigaras-copy-post").click(function (e) {
    e.preventDefault();
    const link = $(this).attr("href");
    if (navigator.clipboard) {
      navigator.clipboard.writeText(link)
        .then(function () {
          console.log('Link copied to clipboard');
        })
        .catch(function (error) {
          console.error('Failed to copy link: ', error);
        });
    } else {
      var tempInput = $("<textarea>");
      $("body").append(tempInput);
      tempInput.val(link).select();
      document.execCommand("copy");
      tempInput.remove();
    }
  });



  if ($('.tsigaras-post__slider')) {
    new Swiper('.tsigaras-post__slider .swiper', {
      breakpoints: {
        360: {
          slidesPerView: 1,
          spaceBetween: 15,
        },
        567: {
          slidesPerView: 2,
          spaceBetween: 15,
        },
        769: {
          slidesPerView: 3,
          spaceBetween: 15,
        },
        992: {
          slidesPerView: 3,
          spaceBetween: 30,
        },
      },
    });
  }



  $(document).on('click', '.tsigaras-header__wrap-inner a', function (e) {
    e.preventDefault();

    const th = $(this);
    const thAttr = th.attr('href');


    $('html, body').animate({
      scrollTop: $(`${thAttr}`).offset().top
    }, 500);
  });


})(jQuery, window, document);
