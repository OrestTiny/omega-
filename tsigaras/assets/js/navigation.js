/**
 * Header menu
 */
; (function ($, window, document, undefined) {
  'use strict';

  const mobileMenuBreakpoint = 1023;
  let winW = null;

  function calcWinSizes() {
    winW = window.innerWidth;
  }

  $(window).on('load resize orientationchange', function () {
    calcWinSizes();
  });

  $(window).on('scroll load', function () {
    if ($(this).scrollTop() >= 30) {
      if ($('.tsigaras-header').length) {
        $('.tsigaras-header').addClass('header-scroll');
      }
    } else {
      if ($('.tsigaras-header').length) {
        $('.tsigaras-header').removeClass('header-scroll');
      }
    }
  });

  if ($('.tsigaras-header').length) {

    // Add dropdown arrow to items with childrens
    $('.tsigaras-header .menu-item-has-children > a, .tsigaras-header .menu-item-has-children > .theme-empty-link').after('<span class="dropdown-btn"></span>');

    $('.tsigaras-header').append('<span class="body-overlay"></span>');

    // click menu item
    $('.tsigaras-header').find('.menu-item-has-children .dropdown-btn').on('click', function (e) {
      e.stopPropagation();
      if (winW <= mobileMenuBreakpoint) {
        let parentItems = $(this).parent().parent().parent().parent();

        if (parentItems.hasClass('tsigaras-header__wrap')) {
          $(this).closest('.tsigaras-header__wrap').find('.dropdown-btn').not(this).removeClass('is-active').next('.sub-menu').slideUp();
        }

        $(this).toggleClass('is-active').next('.sub-menu').slideToggle();
      }
    });

    if (!$('.tsigaras-header__wrap').find('.btn-close').length) {
      $('.tsigaras-header__wrap').append(`<div class="btn-close"><svg width="20px" height="20px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" height="800px" width="800px" version="1.1" id="Capa_1" viewBox="0 0 460.775 460.775" xml:space="preserve">
<path d="M285.08,230.397L456.218,59.27c6.076-6.077,6.076-15.911,0-21.986L423.511,4.565c-2.913-2.911-6.866-4.55-10.992-4.55  c-4.127,0-8.08,1.639-10.993,4.55l-171.138,171.14L59.25,4.565c-2.913-2.911-6.866-4.55-10.993-4.55  c-4.126,0-8.08,1.639-10.992,4.55L4.558,37.284c-6.077,6.075-6.077,15.909,0,21.986l171.138,171.128L4.575,401.505  c-6.074,6.077-6.074,15.911,0,21.986l32.709,32.719c2.911,2.911,6.865,4.55,10.992,4.55c4.127,0,8.08-1.639,10.994-4.55  l171.117-171.12l171.118,171.12c2.913,2.911,6.866,4.55,10.993,4.55c4.128,0,8.081-1.639,10.992-4.55l32.709-32.719  c6.074-6.075,6.074-15.909,0-21.986L285.08,230.397z"/>
</svg></div>`);
    }

    // Close click
    $('.btn-close').on('click', function () {

      $('.tsigaras-header__wrap').removeClass('menu-open');
      $('html').removeClass('no-scroll');

      $('body').removeClass('sidebar-open');
      $('.tsigaras-header__mob-nav a').removeClass('active');

    });
  }

  $('.tsigaras-header__mob-nav a').on('click', function (e) {
    e.preventDefault();

    $('body').on('click', function (e) {

      if ($(window).width() < 1200 && $('.tsigaras-header__wrap.menu-open').length && !e.target.closest('.tsigaras-header')) {
        $('.btn-close').trigger('click');
      }
    });

    $(this).toggleClass('active');

    if ($(this).hasClass('active')) {
      $('html').addClass('no-scroll');
      $('body').addClass('sidebar-open');
      $('.tsigaras-header__wrap').addClass('menu-open');
    } else {
      $('html').removeClass('no-scroll');
      $('body').removeClass('sidebar-open');
      $('.tsigaras-header__wrap').removeClass('menu-open');
    }

    let adminBar = 0;

    if ($('#wpadminbar').length) {
      adminBar = $(window).width() > 782 && $('#wpadminbar').length ? 32 : 46;
    }

    $('.tsigaras-header__wrap').css('top', adminBar);

  });

  function resizeMenu() {
    let adminBar = 0;

    if ($('#wpadminbar').length) {
      adminBar = $(window).width() > 782 && $('#wpadminbar').length ? 32 : 46;
    }

    $('.tsigaras-header').css('top', adminBar);

    if ($(window).width() > 1199 && $('html').hasClass('no-scroll')) {
      $('html').removeClass('no-scroll').height('auto');
      $('.tsigaras-header__mob-nav a').toggleClass('active');
    } else {
      let menuHeight = $(window).height() - adminBar;
      $('.tsigaras-header__wrap').outerHeight(menuHeight + 200);
    }
  }

  $(window).on('load resize orientationchange', function () {
    resizeMenu();
  })

})(jQuery, window, document);
