(function ($, window, document, undefined) {
  'use strict';



  if ($('[data-fancybox="video"]').length) {
    $('[data-fancybox="video"]').fancybox({
      afterShow: function (instance, current) {
        var video = current.$content.find('video')[0];
        if (video) {
          video.play();
          if (window.innerWidth < 768 && !video.fullscreenElement) {
            video.requestFullscreen();
          }
        }
      },
    });
  }
})(jQuery, window, document);
