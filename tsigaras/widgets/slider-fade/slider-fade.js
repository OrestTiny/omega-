(function ($, window, document, undefined) {
  'use strict';

  const sliderSection = $(".tsigaras-slider-fade");
  let delay = sliderSection.attr('data-delay');
  let speed = sliderSection.attr('data-speed');

  let options = {
    fadeEffect: { crossFade: true },
    effect: 'fade',
    slidersPerView: 1,
    virtualTranslate: true,
    autoplay: {
      delay: 3500,
      disableOnInteraction: true,
    },
    speed: 300,
    allowTouchMove: false,
    loop: true,

  }

  if (delay) {
    options.autoplay.delay = delay;
  }

  if (speed) {
    options.speed = speed;
  }

  new Swiper('.tsigaras-slider-fade .swiper', options);

})(jQuery, window, document);
