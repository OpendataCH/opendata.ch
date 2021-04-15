class Burger {
    constructor() {
        this.isMenuOpen = false;
        this.elOpenButton = $(".Burger");
        this.elCloseButton = $(".Flyout--close");
        this.elOverlay = $(".Flyout--overlay");
        this.elMenu = $(".Flyout");
    }

    init() {
        this.setupBindings();
    }

    setupBindings() {
        $(document).keyup((e) => {
            if (e.keyCode === 27 && this.isMenuOpen) {
                this.closeMenu();
                this.isMenuOpen = false;
            }
        });

        this.elOpenButton.on("click", () => {
            this.openMenu();
            this.isMenuOpen = true;
        });

        this.elCloseButton.on("click", () => {
            this.closeMenu();
            this.isMenuOpen = false;
        });

        this.elOverlay.on("click", () => {
            this.closeMenu();
            this.isMenuOpen = false;
        });
    }

    openMenu() {
        this.elMenu.addClass("show");
        $("html").toggleClass("overlayIsOpen", true);
    }

    closeMenu() {
        this.elMenu.removeClass("show");
        $("html").toggleClass("overlayIsOpen", false);
    }
}

export { Burger };

const burger = new Burger();

burger.init();