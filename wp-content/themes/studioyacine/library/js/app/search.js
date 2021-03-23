class Search {
    constructor() {
        this.isSearchOpen = false;
        this.elOpenButton = $(".Header--search");
        this.elCloseButton = $(".Searchoverlay--close");
        this.elSearch = $(".Searchoverlay");
        this.elOverlay = $(".Search--overlay");
    }

    init() {
        this.setupBindings();
    }

    setupBindings() {
        $(document).keyup((e) => {
            if (e.keyCode === 27 && this.isSearchOpen) {
                this.closeSearch();
                this.isSearchOpen = false;
            }
        });

        this.elOpenButton.on("click", () => {
            this.openSearch();
            this.isSearchOpen = true;
        });

        this.elCloseButton.on("click", () => {
            this.closeSearch();
            this.isSearchOpen = false;
        });

        this.elOverlay.on("click", () => {
            this.closeSearch();
            this.isMenuOpen = false;
        });
    }

    openSearch() {
        this.elSearch.addClass("show");
        this.elSearch.find("input").focus();
    }

    closeSearch() {
        this.elSearch.removeClass("show");
    }
}

export { Search };

const search = new Search();

search.init();
