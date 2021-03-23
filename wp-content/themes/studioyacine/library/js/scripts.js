
(function(window, $) {
  var $window = $(window);
  var viewport = updateViewportDimensions();
  var timeToWaitForLast = 100;

  function init() {
    Menu.init();
    // imageGallery();
  }

  // function imageGallery(){
  //   Chocolat(document.querySelectorAll('.wp-block-gallery .blocks-gallery-item a,.wp-block-image a'), {})
  // }

  Menu = (function () {
    var settings = {
      isMenuOpen: false,
      elOpenButton: $(".Burger"),
      elCloseButton: $(".Header--flyout--close"),
      elOverlay: $(".Header--close-overlay"),
      elMenu: $(".Header--flyout")
    };

    _init = function () {
      setupBindings();
    };

    function setupBindings() {
      $(document).keyup(function (e) {
        if (e.keyCode === 27 && settings.isMenuOpen) {
          closeMenu();
          settings.isMenuOpen = false;
        }
      });

      settings.elOpenButton.on("click", function () {
        openMenu();
        settings.isMenuOpen = true;
      });

      settings.elCloseButton.on("click", function () {
          closeMenu();
          settings.isMenuOpen = false;
      });

      settings.elOverlay.on("click", function () {
        closeMenu();
        settings.isMenuOpen = false;
      });     
    }

    function toggleState(){
      settings.isMenuOpen = settings.isMenuOpen ? false : true;
      $("html").toggleClass("overlayIsOpen", settings.isMenuOpen);      
    }

    function openMenu() {
      settings.elMenu.show();
      settings.elOverlay.show();
      toggleState();
    }

    function closeMenu() {
      settings.elMenu.hide();
      settings.elOverlay.hide();
      toggleState();
    }

    return {
      init: _init
    };

  })();  

  function updateViewportDimensions() {
    var w = window,
      d = document,
      e = d.documentElement,
      g = d.getElementsByTagName("body")[0],
      x = w.innerWidth || e.clientWidth || g.clientWidth,
      y = w.innerHeight || e.clientHeight || g.clientHeight;
    return { width: x, height: y };
  }

  var waitForFinalEvent = (function() {
    var timers = {};
    return function(callback, ms, uniqueId) {
      if (!uniqueId) {
        uniqueId = "Don't call this twice without a uniqueId";
      }
      if (timers[uniqueId]) {
        clearTimeout(timers[uniqueId]);
      }
      timers[uniqueId] = setTimeout(callback, ms);
    };
  })();

  window.Application = {
    init: init
  };
})(window, jQuery); // Self execute

Application.init();
