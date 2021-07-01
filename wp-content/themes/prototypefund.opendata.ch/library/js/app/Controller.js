(function(window){

    Controller.prototype.constructor = Controller;
    Controller.prototype = {
        deviceType: "", //computer || tablet || phone
        pageId: "", //wordpress page ID
        themePath: "", //path to wordpress theme
        siteURL: "", //path to wordpress site
        languageCode: "", //current language code
        isHome: "", //are we on frontpage? "0" or "1"
        breakpoints:{ // screen resolutions breakpoints
            screen_xs: 0,
            screen_sm: 768,
            screen_md: 1281,
            screen_lg: 1920
        },
        mailchimpId: 'mc-embedded-subscribe-form',
        currentUserCanvasURL:'',
        browser: {},
        infoBoxWidth: 1550
    }

    var ref, paperView, mySlidebars, shownLogo, projectsFilter, projectsManager, mapController, sliderInitialized, mailchimpForms, newsPage, currentViewport, projectsPage, twitterShareController, couplesView,
        headerHeight, $logoLarge, $toggleMenu, $smallP, logoTimeLine, typeLogoTimeLine,
        $toggleSlideMenu, $header, $content, $sideContainer, $slideBar, $btnToTop, $canvasNav, $logo, $featuredTiles, $featuredTilesVideoDoms,
        $resetCanvas, $exportCanvas, $showGallery, $frontpageInfoboxRight, $logoLink, $frontpageArea, $faqpageArea, $faqpageInfoboxRight,
        formController, $mainAccordions, $body, $projectLinks, $mainNav, $canvasMenuItems, stickys, $chart1, $chart2, $chart3, videoPoster, $subAccordions, chartsManager, cookieManager, initialzed, animationController, $isocontainer, currentDropdownId;
    function Controller(jQuery){

        $ = jQuery;
        ref= this;

        Logger.useDefaults();
        Logger.setLevel(Logger.OFF);

        if($('html').hasClass('no-touch')){
            this.deviceType = window.deviceType = 'computer';
        } else {
            this.deviceType = window.deviceType = 'phone';
        }

        ref.browser=ref.getBrowser();

        $('body').addClass(this.deviceType).addClass(ref.browser.name.toLowerCase()).addClass('version-'+ref.browser.version.toLowerCase());;

    }

    Controller.prototype.init = function(){

        this.pageId = window.currentPageId;
        this.themePath = window.themePath;
        this.siteURL = window.siteURL;
        this.languageCode = window.languageCode;
        this.isHome = window.isHome;

        Logger.info("!!!Startup site on -> deviceType: " + this.deviceType + ", on: " + ref.browser.name + " version " + ref.browser.version + " ,pageId: " + this.pageId + " languageCode: " + this.languageCode + ", width: " + ref.viewport().width + ", height: " + ref.viewport().height + ", screensize: " + ref.viewport().screensize);

        var lazyLoadInstance = new LazyLoad({
            elements_selector: ".lazy"
        });

        //$ references
        $toggleSlideMenu = $('.nav-toggle');
        $header = $('.header');
        headerHeight = $header.height()/2;

        $logoLarge = $('.logo-large-wrapper',$header).css('opacity',1);
        $logo = $('.logo',$logoLarge);
        $toggleMenu = $('.toggle-menu');
        $smallP = $('#fixed-logo-p');
        $frontpageInfoboxRight = $('.frontpage-info-box-right');
        $faqpageInfoboxRight = $('.faqpage-info-box-right');
        $logoLink = $('.logo-link');
        $faqpageArea = $('.faqpage-area');
        $frontpageArea = $('.frontpage-area');
        $mainNav = $('.main-nav-wrap');
        $body = $('body');
        $canvasMenuItems = $('.canvas-nav-wrap');

        $chart1 = $('#chart-1');
        $chart2 = $('#chart-2');
        $chart3 = $('#chart-3');

        $featuredTiles = $('.tile-link.featured');
        $featuredTilesVideoDoms = [];
        $featuredTiles.each(function(){
            var $dom = $(this).find('.embed-responsive').find('iframe').clone();
            $featuredTilesVideoDoms.push($dom);
        });

        if($('.ptf-form').length > 0){
            formController = new FormController();
        }

        $('.random-projects-btn').click(function(){
            TweenMax.to($('.random-projects-btn').find('.fas'),0.25,{rotation:"+=360", ease:Sine.easeOut});
            $('.project-link').removeClass('active');
            var $first3 = $('.project-link').slice( 0, 3);
            $first3.appendTo('.header-ctas-inner');
            $('.project-link').slice( 0, 3).addClass('active');
        });

        $('.project-link').click(function(e){
            e.preventDefault();
            window.location.href = $(this).attr('data-href')
        });

        //handles video embeds with poster images
        videoPoster = new VideoPoster();
        projectsFilter = new ProjectsFilter();
        cookieManager = new CookieManager();
        //if(window.showMap) mapController = new MapController(this);

        if($('.charts-wrap').length > 0){
            chartsManager = new ChartsManager(this);
            chartsManager.init();
        }

        $sideContainer = $('#sb-site');
        $slideBar = $('.slidebar');
        $content = $('#content');
        $canvasNav = $('.canvas-nav-wrap');
        $resetCanvas = $('.resetCanvas');
        $exportCanvas = $('.exportCanvas');
        $showGallery = $('.svg-nav-eye');

        if(this.deviceType == 'computer') $showGallery.removeClass('gone');

        $btnToTop = $('.btn-totop');
        $btnToTop.click(function(e){

            //Logger.log("$(window).scrollTop -> " + $(window).scrollTop());

            TweenMax.to($(window), 1, {
                scrollTo:'0px',
                ease:Power3.easeOut
            });
        });

        //social
        ref.initTwitterController();

        //couplesview
        couplesView = new CouplesView(this);
        couplesView.init();

        //newspage controller
        if($('.news-tile-wrapper').length > 0){
            newsPage = new NewsPage();
            newsPage.init();
        }

        //projectspage controller
        if($('.projects-tile-wrapper').length > 0){
            projectsPage = new ProjectsPage(this);
            projectsPage.init();
        }

        //if there a papercanvas we initialize it
        if($('#paper-canvas').length > 0){

            paperView = new PaperView(this);
            paperView.load(ref.themePath +  "/library/images/p.svg");

            $resetCanvas.click(function(){
                paperView.resetToDefault();
            });

            $exportCanvas.click(function(){
                paperView.exportCanvas();
            });

            $('.twitterCanvas').click(function(){
                twitterShareController.tweetText(ref.currentUserCanvasURL + " Mein Prototype #prototypefund");
                paperView.hideSharer();
            });

        }

        // Video
        ref.createVideoPlayer();

        $subAccordions = $(".accordion-headline.sub");
        $subAccordions.click(function(){
            Logger.log("click!!!");
            $(this).next().toggleClass('open')
        });

        //scroll handler
        $(window).scroll(function(e){
            ref.onScroll(e);
        });
        $(window).on( 'DOMMouseScroll mousewheel', function (e) {
            ref.onScroll(e);
        });
        //animations
        //animationController = new AnimationController(this);
        //animationController.init();

        $toggleMenu.click(function(){
            if($mainNav.hasClass('gone')){
                //show menu on mobile
                $mainNav.removeClass('gone');
                $toggleSlideMenu.addClass('active');
                $body.addClass('mobile-menu-open');
            } else {
                //hide menu on mobile
                $mainNav.addClass('gone');
                $toggleSlideMenu.removeClass('active');
                $body.removeClass('mobile-menu-open');
            }
        });

        //main navigation
        $('.main-nav .nav-main-link').mouseenter(function(){
            if($(window).scrollTop() > 0) return;
            var id = $(this).attr('data-id');
            var $dropdown = $(".nav-dropdown[data-id='" + id + "']");
            if($dropdown.length > 0){
                //there is a dropdown to display
                if(currentDropdownId && currentDropdownId != id){
                    //hide open dropdown
                    $(".nav-dropdown[data-id='" + currentDropdownId + "']").removeClass('visible');
                }
                if(!$dropdown.hasClass('visible')){
                    $dropdown.addClass('visible');
                }
                currentDropdownId = id;
            } else {
                //no dropdown for item
                ref.closeDropdown();
            }
        });

        $('.main-nav-outer').mouseleave(function(){
            //no dropdown for item
            ref.closeDropdown();
        });

        $('.collapseomatic').click(function(){
            if(!$(this).hasClass('colomat-close')){
                //open content
                $(this).insertAfter('.collapseomatic_content');
            } else {
                //close content
                $(this).insertBefore('.collapseomatic_content');
            }
        });

        //resize handler
        var delay = (function(){
            var timer = 0;
            return function(callback, ms){
                clearTimeout (timer);
                timer = setTimeout(callback, ms);
            };
        })();

        $(window).resize(function() {
            delay(function(){
                ref.resize();
            }, 50);
        });
        ref.resize();

        //check hash
        $(window).bind('hashchange', function (e) {
            ref.onHashChange(e);
        });
        if(window.location.hash) {
            ref.onHashChange();
        }

        $isocontainer = $('.gallery-tile-wrapper');
        if($isocontainer.length > 0){

            $isocontainer.imagesLoaded( function() {
                var isoLayoutOptions = {
                    transitionDuration: 200,
                    layoutMode: 'masonry',
                    itemSelector: '.gallery-tile',
                    masonry: {
                        columnWidth: $isocontainer.find('.grid-sizer')[0],
                        gutter: $isocontainer.find('.gutter-sizer')[0]
                    }
                };
                $isocontainer.isotope( isoLayoutOptions );
            });

        }

    };

    Controller.prototype.onHashChange = function(e){
        var hash = window.location.hash.slice(1);
        if(projectsFilter) projectsFilter.onHashChange(hash);
    }

    Controller.prototype.closeDropdown = function()
    {
        if(currentDropdownId){
            //hide open dropdown
            $(".nav-dropdown[data-id='" + currentDropdownId + "']").removeClass('visible');
            currentDropdownId = null;
        }
    }

    Controller.prototype.initTwitterController = function()
    {
        if(!twitterShareController){
            twitterShareController = new TwitterShareController();
        }
        twitterShareController.init();
    };

    Controller.prototype.createVideoPlayer  = function()
    {

        $('.embed-responsive').fitVids();

        var plyr_e = document.querySelectorAll('.js-player');
        var $plyr_e = $('.js-player');
        if($plyr_e.length > 0){
            plyr.setup(plyr_e,
                {
                    controls: ['play-large']
                    //,poster:     'http://cdn5.thr.com/sites/default/files/imagecache/scale_crop_768_433/2014/09/too_good_for_grumpy_cat.jpg'
                });
        }
    };

    Controller.prototype.onFormularSend = function()
    {

    };

    Controller.prototype.initSlider = function(){

        Logger.log("initSlider.");

        var $sliders = $('.slider-wrap');
        if($sliders.length > 0){

            $sliders.not('.slick-initialized').slick({
                dots: false,
                infinite: true,
                speed: 300,
                slidesToShow: 3,
                centerMode: true,
                variableWidth: true,
                autoplay: false,
                prevArrow: false,
                nextArrow: false,
                swipeToSlide: false,
                adaptiveHeight: true
            });

            if(!sliderInitialized){
                $('.slick-slide').click(function(){
                    if(sliderInitialized){
                        $sliders.slick('slickNext');
                    }
                }).css('cursor','pointer');
            }

            sliderInitialized = true;

        }

    };

    Controller.prototype.onScroll = function(e)
    {

        var scrollTop = $(document).scrollTop();

        //the logo
        if(ref.deviceType == 'computer' && ref.isHome){

            if(scrollTop >= headerHeight + 150){
                if(!$smallP.hasClass('show')){
                    logoTimeLine = new TimelineMax({delay:0, paused:false })
                        .set($smallP,{className:"+=show"})
                        .to($smallP, 0.1, {autoAlpha:1, ease: Expo.easeOut},'small');
                }
            } else {
                //show big logo
                if($smallP.hasClass('show')){
                    logoTimeLine = new TimelineMax({delay:0, paused:false })
                        .set($smallP,{className:"-=show"})
                        .to($smallP, 0.1, {autoAlpha:0, ease: Expo.easeOut},'big')
                }
            }
        }

        //the scroll back to top button
        if(scrollTop + $(window).height() >= $content.height()) {
            if($btnToTop.hasClass('gone')) $btnToTop.removeClass('gone');
        } else {
            if(!$btnToTop.hasClass('gone')) $btnToTop.addClass('gone');
        }

        if(chartsManager){

            var chart_1_offset = parseInt($chart1.offset().top - $(window).scrollTop()) - parseInt($(window).height());
            var chart_2_offset = parseInt($chart2.offset().top - $(window).scrollTop()) - parseInt($(window).height());
            var chart_3_offset = parseInt($chart3.offset().top - $(window).scrollTop()) - parseInt($(window).height());

            if(!$chart1.hasClass('initialized')){


                if(chart_1_offset < 0){
                    chartsManager.initChart1();
                }
            }

            if(!$chart2.hasClass('initialized')){

                if(chart_2_offset < 0){
                    chartsManager.initChart2();
                }
            }

            if(!$chart3.hasClass('initialized')){

                if(chart_3_offset < 0){
                    chartsManager.initChart3();
                }
            }

        }

        // P canvas navigation
        $canvasMenuItems = $('.canvas-nav-wrap');
        if(scrollTop != 0){
            $canvasMenuItems.addClass('gone');
        } else $canvasMenuItems.removeClass('gone');

    };

    Controller.prototype.resize = function()
    {
        var newViewport = ref.viewport().screensize;
        if(currentViewport != newViewport){
            var viewportChanged = true;
        }
        currentViewport = newViewport;

        ref.resetFeaturedProjects();

        Logger.log("Controller, Resize to " + currentViewport);
        if(newsPage) newsPage.resize(ref.viewport().width);
        if(projectsPage){
            projectsPage.resize(viewportChanged);
        }

        if(paperView){
            if(paperView.initialized){
                paperView.onResize();
            }
        }

        Logger.log("$(window).width() -> " + $(window).width());

        if($(window).width() > 1024){
            //sticky
            stickys = new Sticky('.sticky');
            stickys.update();
            //align single project links
            var h = parseInt($('.page-2020-wrap').css('paddingTop')) + $('.project-single-sticky-inner').height() + $('.project-single-links').height() + 25;
            var pt = $(window).height() - h;
            $('.project-single-links').css('marginTop',pt+'px');
        } else {
            //destroy sticky
            $('.project-single-links').css('marginTop','');
            if(stickys){
                stickys.destroy();
                stickys = null;
            }
        }


        ref.initSlider();
        ref.onScroll();




    };

    Controller.prototype.resetFeaturedProjects = function()
    {
        //reset videoembeds to initial state
        if($featuredTiles.length > 0){
            $featuredTiles.each(function(i){

                var $container = $(this).closest('.isotope-item');
                if($container.is(":visible")){
                    $(this).css('height','');
                    $(this).find('.tile').css('height','');
                    $(this).find('.project-info-wrap').css('height','');
                    Logger.log("$featuredTilesVideoDoms[i]", $featuredTilesVideoDoms[i]);
                    $(this).find('.embed-responsive').empty().append( $featuredTilesVideoDoms[i] );
                }

            });

            $('.embed-responsive').fitVids();

            setTimeout(function(){

                $featuredTiles.each(function(){

                    var $container = $(this).closest('.isotope-item');
                    if($container.is(":visible")){
                        var video_height = $(this).find('.embed-responsive').find('iframe').height();
                        Logger.log("video_height -> " + video_height);
                        if(ref.viewport().width >= 769){
                            $(this).height(video_height);
                            $(this).find('.tile').height(video_height);
                            $(this).find('.project-info-wrap').height(video_height);
                        }
                    }


                });
                if(projectsPage) projectsPage.reLayout();
            }, 100);
        }
    };

    Controller.prototype.showCanvasNav = function()
    {
        if(this.deviceType == 'computer'){
            $exportCanvas.removeClass('gone');
            $resetCanvas.removeClass('gone');
        }

    };

    Controller.prototype.setUserCanvasURL = function(pUrl)
    {
        ref.currentUserCanvasURL = pUrl;
    };

    /*
     *
     * GENERIC HELPERS - GETTER/SETTER FUNCTIONS
     *
     * */

    //this returns the "real" windows width/height as used in media queries (returns Object{ width:x, height:y })
    Controller.prototype.viewport = function()
    {
        var e = window, a = 'inner';
        if (!('innerWidth' in window )) {
            a = 'client';
            e = document.documentElement || document.body;
        }

        var screensize = "screen_xxs";
        if(e[ a+'Width' ] >= ref.breakpoints.screen_xs) screensize = "screen_xs";
        if(e[ a+'Width' ] >= ref.breakpoints.screen_sm) screensize = "screen_sm";
        if(e[ a+'Width' ] >= ref.breakpoints.screen_md) screensize = "screen_md";
        if(e[ a+'Width' ] >= ref.breakpoints.screen_lg) screensize = "screen_lg";

        return { width : e[ a+'Width' ] , height : e[ a+'Height' ], screensize : screensize };
    };

    //this return browser type and version to <html>
    Controller.prototype.getBrowser = function()
    {
        var ua=navigator.userAgent,tem,M=ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];
        if(/trident/i.test(M[1])){
            tem=/\brv[ :]+(\d+)/g.exec(ua) || [];
            return {name:'IE',version:(tem[1]||'')};
        }
        if(M[1]==='Chrome'){
            tem=ua.match(/\bOPR\/(\d+)/)
            if(tem!=null)   {return {name:'Opera', version:tem[1]};}
        }
        M=M[2]? [M[1], M[2]]: [navigator.appName, navigator.appVersion, '-?'];
        if((tem=ua.match(/version\/(\d+)/i))!=null) {M.splice(1,1,tem[1]);}
        return {
            name: M[0],
            version: M[1]
        };
    };

    window.Controller = Controller;

}(window));
