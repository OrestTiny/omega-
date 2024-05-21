(function ($, window, document, undefined) {
  'use strict';

  new Swiper('.tsigaras-slider-main .swiper', {
    // loop: true,
    spaceBetween: 30,
    slidesPerView: 1,
    // slidesPerGroup: 3,
    // navigation: {
    //   nextEl: '.tsigaras-slider-main .swiper-button-next',
    //   prevEl: '.tsigaras-slider-main .swiper-button-prev',
    // },
    pagination: {
      el: '.tsigaras-slider-main .swiper-pagination',
      clickable: true
    },
    breakpoints: {
      320: {
        slidesPerView: 1,
        // slidesPerGroup: 1,
      },
      577: {
        slidesPerView: 1,
        // slidesPerGroup: 2,
      },
      // 768: {
      //   slidesPerView: 2,
      //   slidesPerGroup: 3,
      // },
      992: {
        slidesPerView: 1,
        // slidesPerGroup: 3,
      },
    },
  })

})(jQuery, window, document);
