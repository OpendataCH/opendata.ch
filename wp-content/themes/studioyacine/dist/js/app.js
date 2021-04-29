(function () {
  'use strict';

  function _classCallCheck(instance, Constructor) {
    if (!(instance instanceof Constructor)) {
      throw new TypeError("Cannot call a class as a function");
    }
  }

  function _defineProperties(target, props) {
    for (var i = 0; i < props.length; i++) {
      var descriptor = props[i];
      descriptor.enumerable = descriptor.enumerable || false;
      descriptor.configurable = true;
      if ("value" in descriptor) descriptor.writable = true;
      Object.defineProperty(target, descriptor.key, descriptor);
    }
  }

  function _createClass(Constructor, protoProps, staticProps) {
    if (protoProps) _defineProperties(Constructor.prototype, protoProps);
    if (staticProps) _defineProperties(Constructor, staticProps);
    return Constructor;
  }

  var Burger = /*#__PURE__*/function () {
    function Burger() {
      _classCallCheck(this, Burger);

      this.isMenuOpen = false;
      this.elOpenButton = $(".Burger");
      this.elCloseButton = $(".Flyout--close");
      this.elOverlay = $(".Flyout--overlay");
      this.elMenu = $(".Flyout");
      this.elSubNavTrigger = $(".submenu-toggle");
    }

    _createClass(Burger, [{
      key: "init",
      value: function init() {
        this.setupBindings();
      }
    }, {
      key: "setupBindings",
      value: function setupBindings() {
        var _this = this;

        $(document).keyup(function (e) {
          if (e.keyCode === 27 && _this.isMenuOpen) {
            _this.closeMenu();

            _this.isMenuOpen = false;
          }
        });
        this.elSubNavTrigger.on("click", function (e) {
          // this.elMenu.find('.sub-menu.show').removeClass('show');
          $(e.currentTarget).parent('li').toggleClass('show');
        });
        this.elOpenButton.on("click", function () {
          _this.openMenu();

          _this.isMenuOpen = true;
        });
        this.elCloseButton.on("click", function () {
          _this.closeMenu();

          _this.isMenuOpen = false;
        });
        this.elOverlay.on("click", function () {
          _this.closeMenu();

          _this.isMenuOpen = false;
        });
      }
    }, {
      key: "openMenu",
      value: function openMenu() {
        this.elMenu.addClass("show");
        $("html").toggleClass("overlayIsOpen", true);
      }
    }, {
      key: "closeMenu",
      value: function closeMenu() {
        this.elMenu.removeClass("show");
        $("html").toggleClass("overlayIsOpen", false);
      }
    }]);

    return Burger;
  }();
  var burger = new Burger();
  burger.init();

  var Search = /*#__PURE__*/function () {
    function Search() {
      _classCallCheck(this, Search);

      this.isSearchOpen = false;
      this.elOpenButton = $(".Header--search");
      this.elCloseButton = $(".Searchoverlay--close");
      this.elSearch = $(".Searchoverlay");
      this.elOverlay = $(".Search--overlay");
    }

    _createClass(Search, [{
      key: "init",
      value: function init() {
        this.setupBindings();
      }
    }, {
      key: "setupBindings",
      value: function setupBindings() {
        var _this = this;

        $(document).keyup(function (e) {
          if (e.keyCode === 27 && _this.isSearchOpen) {
            _this.closeSearch();

            _this.isSearchOpen = false;
          }
        });
        this.elOpenButton.on("click", function () {
          _this.openSearch();

          _this.isSearchOpen = true;
        });
        this.elCloseButton.on("click", function () {
          _this.closeSearch();

          _this.isSearchOpen = false;
        });
        this.elOverlay.on("click", function () {
          _this.closeSearch();

          _this.isMenuOpen = false;
        });
      }
    }, {
      key: "openSearch",
      value: function openSearch() {
        this.elSearch.addClass("show");
        this.elSearch.find("input").focus();
      }
    }, {
      key: "closeSearch",
      value: function closeSearch() {
        this.elSearch.removeClass("show");
      }
    }]);

    return Search;
  }();
  var search = new Search();
  search.init();

}());
//# sourceMappingURL=app.js.map
