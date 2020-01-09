/**
 * Author: CReich
 * Company: Rainbow Unicorn
 * Date: 26.07.2016
 * Created: 11:31
 **/
(function(window){

    AnimationController.prototype.constructor = AnimationController;
    AnimationController.prototype = {
        val0 : '',
        val1 : ''
    };
    
    var ref, controller, $menuItems, $navLanguage, $emailSignup, $socials, $impressum, menuTimeLine,
        $faqContent, $faqTitle, $faqIntro, $faqHeadlineMain, faqTimeLine, $faqHeadlineMainItems, chart_sm_controller,
        $faqHeadlineDetails, $faqHeadlineDetailsItems, $faqBox, frontpageScene,tTimeLine, $galleryTimeline,
        $newsTileWrapper, $newsTiles, $newsTimeline, sm_controller, faqpageScene, frontpageTl, faqpageTl,
        $projectsContent, $projectsTiles, $projectsTitle, $aboutContent, $projectsFilters, $projectsText, $projectsTimeline, $isocontainer, $galleryItems;
    function AnimationController(pController){
        ref = this;
        controller = pController;
    }

    AnimationController.prototype.init = function(){

        //menu items
        $menuItems = $('.main-nav');
        $navLanguage = $('.nav-language');
        $emailSignup = $('.mc_embed_signup','.slidebar');
        $socials = $('.cta-social','.slidebar').find('p');
        $impressum = $('.sidebar-nav','.slidebar');


        /*
        ref.hideMenuContent();
        menuTimeLine = new TimelineMax({delay:0, paused:true})
            .staggerTo($menuItems.find('li'), 0.15, {delay: 0, x:'0%', autoAlpha:1}, 0.1)
            .staggerTo([$navLanguage, $emailSignup, $socials, $impressum], 0.15, {x:'0%', autoAlpha:1}, 0.1);
        */

        //FAQ

        /*
        $faqContent = $('.section-faq-content');
        if($faqContent.length > 0){

            var $panels = $('.accordion-panel.sub');
            var $headlines = $('.accordion-headline.sub');

            //we are on FAQ page
            $faqTitle = $('.page-title',$faqContent);
            $faqIntro = $('.faq-intro',$faqContent);
            $faqHeadlineMain = $('.accordion-headline.main','.accordion-basics');
            $faqHeadlineMainItems = $('.accordion-panel','.accordion-basics');
            $faqHeadlineDetails = $('.accordion-headline.main','.accordion-details');
            $faqHeadlineDetailsItems = $('.accordion-panel','.accordion-details');
            $faqBox = $('.grey',$faqContent);

            faqTimeLine = new TimelineMax({delay:0})
                .set([$faqTitle, $faqIntro, $faqHeadlineMain, $faqHeadlineDetails],{autoAlpha: 0, y: '10%'})
                .set($faqHeadlineMainItems.find('.accordion-headline.sub'),{autoAlpha: 0, y: '10%'})
                .set($faqHeadlineDetailsItems.find('.accordion-headline.sub'),{autoAlpha: 0, y: '10%'})
                .set($faqBox,{autoAlpha: 0})
                .set($faqContent,{autoAlpha: 1})
                .to($faqTitle, 0.2, {y:'0%', autoAlpha:1})
                .to($faqIntro, 0.2, {y:'0%', autoAlpha:1})
                .to($faqHeadlineMain, 0.2, {y:'0%', autoAlpha:1},'headline')
                .to($faqBox, 0.5, {autoAlpha:1, ease: Power2.easeOut},'headline')
                .staggerTo($faqHeadlineMainItems.find('.accordion-headline.sub'), 0.2, {y:'0%', autoAlpha:1}, 0.1)
                .to($faqHeadlineDetails, 0.2, {y:'0%', autoAlpha:1})
                .staggerTo($faqHeadlineDetailsItems.find('.accordion-headline.sub'), 0.2, {y:'0%', autoAlpha:1}, 0.1);

        }
        */


        //ABOUT
        $aboutContent = $('.section-about-content');
        if($aboutContent.length > 0){
            //we are on ABOUT page
            $aboutTitle = $('.page-title',$aboutContent);
            $aboutText = $('.about-content',$aboutContent);
            $aboutAccordion = $('.about-accordion',$aboutContent);

            aboutTimeLine = new TimelineMax({delay:0})
                .set([$aboutTitle, $aboutText],{autoAlpha: 0, y: '10%'})
                .set($aboutAccordion.find('.accordion-headline'),{autoAlpha: 0, y: '10%'})
                .to($aboutTitle, 0.2, {y:'0%', autoAlpha:1})
                .to($aboutText, 0.2, {y:'0%', autoAlpha:1})
                .staggerTo($aboutAccordion.find('.accordion-headline'), 0.2, {y:'0%', autoAlpha:1}, 0.2)
        }

        //NEWS
        $newsTileWrapper = $('.news-tile-wrapper');
        if($newsTileWrapper.length > 0) {

            //we are on NEWS page
            $newsTiles = $('.tile-link',$newsTileWrapper);
            $newsTimeline = new TimelineMax({delay:0})
                .set($newsTiles,{autoAlpha: 0, y: '20%'})
                .staggerTo($newsTiles, 0.5, {y:'0%', autoAlpha:1}, 0.1)
        }

        //PROJECTS
        $projectsContent = $('.section-projects-content');
        if($projectsContent.length > 0) {
            //we are on PROJECTS page
            $projectsTitle = $('.page-title',$projectsContent);
            $projectsFilters = $('.category-filters-wrapper',$projectsContent);
            $projectsTiles = $('.tile-link','.projects-tile-wrapper');
            $projectsTimeline = new TimelineMax({delay:0})
                .set([$projectsTitle, $projectsFilters],{autoAlpha: 0, y: '10%'})
                .set($projectsTiles,{autoAlpha: 0, y: '20%'})
                .to($projectsTitle, 0.2, {y:'0%', autoAlpha:1})
                .to($projectsFilters, 0.2, {y:'0%', autoAlpha:1})
                .staggerTo($projectsTiles, 0.5, {y:'0%', autoAlpha:1}, 0.1)
        }

        //GALLERY
        /*
        $isocontainer = $('.gallery-tile-wrapper');
        if($isocontainer.length > 0){

            $galleryItems = $('.gallery-tile', $isocontainer);
            $galleryTimeline = new TimelineMax({delay:0})
                .set($galleryItems,{autoAlpha: 0, y: '20%'})
                .staggerTo($galleryItems, 0.5, {y:'0%', autoAlpha:1}, 0.1)

        }*/

    };

    AnimationController.prototype.animateInfoBoxes = function(){

        return;


        if(frontpageTl) frontpageTl.seek(0).kill();
        if(faqpageTl) faqpageTl.seek(0).kill();
        if(sm_controller) sm_controller.destroy();

        if(frontpageScene) frontpageScene.destroy();
        if(faqpageScene) faqpageScene.destroy();

        sm_controller = null;
        frontpageScene = null;
        faqpageScene = null;

        var $frontpageInfoBoxRight = $('.frontpage-info-box-right');
        var $faqpageInfoBoxRight = $('.faqpage-info-box-right');

        if($frontpageInfoBoxRight.length > 0){
            TweenMax.set($frontpageInfoBoxRight,{clearProps:"all"});
        }
        if($faqpageInfoBoxRight.length > 0){
            TweenMax.set($faqpageInfoBoxRight,{clearProps:"all"});
        }

        // init scroll magic controller
        sm_controller = new ScrollMagic.Controller({
            globalSceneOptions: {
                triggerHook: 'onEnter'
            }
        });

        if(controller.viewport().width >= 1400){
            return
            /*
            var $frontpageArea = $('.front-content');
            if($frontpageArea.length > 0){
                frontpageTl = new TimelineMax();
                frontpageTl
                    .from('.frontpage-info-box-right', 0.7, {x: '100%', ease: Sine.easeOut})
                    .to('.frontpage-info-box-right', 0.7, {x: '100%', delay:2, ease: Sine.easeOut})

                // Create scene about
                $frontpageArea.each(function() {

                    frontpageScene = new ScrollMagic.Scene({
                        triggerElement: this,
                        triggerHook: 'onLeave',
                        duration: $('.frontpage-upper-wrap').height(),
                        offset: parseInt($(window).height()+$('.frontpage-upper-wrap').height())-200
                    })
                        .setTween(frontpageTl)
                        //.addIndicators({name: "front"})
                        //.loglevel(3)
                        .addTo(sm_controller);

                });
            }
            */

            var $faqpageArea = $('.faqpage-area');
            if($faqpageArea.length > 0){
                faqpageTl = new TimelineMax();
                faqpageTl
                    .from('.faqpage-info-box-right', 0.7, {x: '100%', ease: Sine.easeOut})
                    .to('.faqpage-info-box-right', 0.7, {x: '100%', delay:2, ease: Sine.easeOut})

                // Create scene about
                $faqpageArea.each(function() {

                    faqpageScene = new ScrollMagic.Scene({
                        triggerElement: this,
                        triggerHook: 'onLeave',
                        duration: $(this).height()*0.75,
                        offset: $(window).height()*0.75
                    })
                        .setTween(faqpageTl)
                        //.addIndicators({name: "front"})
                        //.loglevel(3)
                        .addTo(sm_controller);

                });
            }


        }
    };

    AnimationController.prototype.hideMenuContent = function(){
        //TweenMax.set($menuItems.find('li'),{autoAlpha: 0, x: '-20%'});
        //TweenMax.set([$navLanguage, $emailSignup, $socials, $impressum],{autoAlpha: 0, x: '-20%'});
    };

    AnimationController.prototype.animateMenuContent = function(){
        //menuTimeLine.play(0);
    };

    window.AnimationController = AnimationController;

}(window));
