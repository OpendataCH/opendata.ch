/**
 * Author: CReich
 * Company: Rainbow Unicorn
 * Date: 05.07.2016
 * Created: 19:49
 **/
(function(window){

    ProjectsPage.prototype.constructor = ProjectsPage;
    ProjectsPage.prototype = {
        val0 : '',
        val1 : '',
        layerOpen: false,
        options: {
            multiple: false
        }
    };

    var ref, controller, filterList, final_filters, roundList, $siteWrap, storedSiteTopY, isLoading, nativeUrl, currentUrl,
        $gridsizer, $projectsTileWrapper, $projectsTileTexts, $currentTile, $previousTile, $grid, $tileCloseButtons, $accordionContent, $projectsTileLinks, $tiles,  $tilesClicks, isotopeInitialized, $contentLayer,
        $categoryDescription, defaultCategoryDescription, cookieManager, $noFilterResult;
    function ProjectsPage(pController){
        ref = this;
        controller = pController;
    };

    ProjectsPage.prototype.init = function(){

        Logger.log("Init ProjectsPage.");

        cookieManager = new CookieManager();
        var finalL = cookieManager.readCookie('ptf-final-filters_'+window.languageCode);
        var roundL = cookieManager.readCookie('ptf-rounds_'+window.languageCode);
        var filterL = cookieManager.readCookie('ptf-filters_'+window.languageCode);

        if(roundL){
            roundList = roundL.split();
        } else roundList = [];

        if(filterL){
            filterList = filterL.split();
        } else filterList = [];

        if(finalL){
            final_filters = finalL.split();
        } else final_filters = [];

        Logger.log("init final_filters -> " + final_filters);
        Logger.log("init filterList -> " + filterList);
        Logger.log("init roundList -> " + roundList);

        if(filterList.length > 0){
            for(var a=0; a<filterList.length; a++){
                $("[data-filter='" + filterList[a] + "']").addClass('active');
            }
        }
        if(roundList.length > 0){
            for(a=0; a<roundList.length; a++){
                $("[data-filter='" + roundList[a] + "']").addClass('active');
            }
        }

        nativeUrl = window.location.href;
        Logger.log("nativeURL -> " + nativeUrl);

        $projectsTileWrapper = $('.projects-tile-wrapper');
        $projectsTileTexts = $('.text',$projectsTileWrapper);
        $projectsTileLinks = $('.tile-link',$projectsTileWrapper);
        $tilesClicks = $('.tile-click-area',$projectsTileWrapper);
        $tiles = $('.tile',$projectsTileWrapper);
        $tileCloseButtons = $('.svg-icon-project');
        $siteWrap = $('#sb-site');
        $gridsizer = $('.grid-sizer-projects');
        $categoryDescription = $('.category-description');
        defaultCategoryDescription = $categoryDescription.text();
        $noFilterResult = $('.no-items-in-filter');

        //allow flipping only on desktop computers
        //$tilesClicks.addClass(controller.deviceType);

        $tileCloseButtons.click(function(e){
            var $tile = $(this).closest('.tile');
            if($tile.hasClass('open')){
                ref.closeProject(true);
                e.stopPropagation();
            }
        });

        //setup all linkings for the tiles

        Logger.log("$tiles ----------------> " + $tiles.hasClass('active'));

        if($tiles.hasClass('active')){
            $tilesClicks.click(function(e){

                e.preventDefault();

                if(isLoading) return;

                var $ref = $(this).closest('.tile-link');

                var $tile = $ref.find('.tile');
                var isActive = $tile.hasClass('active');
                var isOpen = $tile.hasClass('open');

                if(isOpen) return;

                Logger.log("click project. isActive -> " +isActive + ", isOpen -> " + isOpen);

                if($currentTile){
                    $previousTile = $currentTile;
                    $previousTile.find('.tile').removeClass('open').addClass('active');
                }
                $currentTile = $ref;

                currentUrl = $currentTile.attr('data-href');
                //window.location = currentUrl;

                window.open(currentUrl, '_blank');

                //$tile.addClass('loading');
                return;

                if(!isActive) return;


                var $img = $tile.find('.project-image');
                var timeline = new TimelineMax({delay:0, paused:false})
                    .set($img, {opacity: 0})
                    .to($img, 0.5, {delay:0.3, opacity:1, ease:Sine.easeOut},'ani');

                var tileHeight = $tile.find('.front').height();
                $tile.height(tileHeight);
                if(controller.viewport().width <= 768){
                    $tile.find('.project-info-wrap').height(tileHeight);
                }

                //mark tile as open
                $tile.removeClass('active').addClass('open loading');

                isLoading = true;

                //close old projects
                if(ref.layerOpen){
                    ref.closeProject(false,true);
                    return;
                }
                if(isActive)

                //////////////
                    ref.openProject();
                //////////////

                return false;


            });
        }

        // filter items when filter link is clicked
        $('.category-filters-items.filters').find('a').click(function(e){

            e.preventDefault();

            ref.closeProject();

            var filter = $(this).attr('data-filter');

            var description = '';
            if(!$(this).hasClass('active')){
                //add filter

                if(!ref.options.multiple){
                    filterList = [];
                    $('.category-filters-items.filters').find('a').removeClass('active');
                }

                description = $(this).attr('data-description');

                ref.addFilterToList(filter);
                $(this).addClass('active');
            } else {
                //remove filter
                ref.removeFilterFromList(filter);
                $(this).removeClass('active');

                description = defaultCategoryDescription;
            }

            //show description of category
            TweenMax.set($categoryDescription,{opacity:0, ease:Sine.easeOut});
            $categoryDescription.text(description);
            var catDescTimeline = new TimelineMax({delay:0, paused:false})
                            .to($categoryDescription, 1, {opacity:1, ease:Sine.easeOut},'ani')

            return false;
        });

        // filter items when round link is clicked
        $('.category-filters-items.rounds').find('a').click(function(e){

            e.preventDefault();

            ref.closeProject();

            var filter = $(this).attr('data-filter');

            if(!$(this).hasClass('active')){
                //add filter

                if(!ref.options.multiple){
                    roundList = [];
                    $('.category-filters-items.rounds').find('a').removeClass('active');
                }

                ref.addRoundToList(filter);
                $(this).addClass('active');
            } else {
                //remove filter
                ref.removeRoundFromList(filter);
                $(this).removeClass('active');
            }

            return false;
        });

        $projectsTileTexts.find('a').click(function(e){
            e.stopPropagation();
        });

    };

    ProjectsPage.prototype.openProject = function(){

        currentUrl = $currentTile.attr('data-href');

        Logger.log("url: " + currentUrl);

        //create contentlayer
        if($contentLayer) $contentLayer.remove();
        $contentLayer = $('.project-content-tile.template').clone();

        Logger.log("$contentLayer: ",$contentLayer);

        //find position to prepend layer to
        var $itemToPrepend = $currentTile;
        var $newItem = ref.findItemToPrependTo();

        if($newItem){
            $contentLayer.insertBefore($newItem);
        } else $contentLayer.insertAfter($itemToPrepend);


        if(isotopeInitialized){
            $projectsTileWrapper.isotope('destroy');
            Logger.log("DESTROY ISOTOPE!!!!");
        }
        $gridsizer.addClass('hidden');
        isotopeInitialized = false;
        $tilesClicks.closest('.tile-link').each(function(){
            $(this).css( "width", "" );
        });

        //store scroll position for closing
        storedSiteTopY = $siteWrap.scrollTop();

        $.ajax({
            type: 'GET',
            url: currentUrl,
            dataType: 'html',
            success: function(data)
            {

                ref.layerOpen = true;
                isLoading = false;

                $currentTile.find('.tile').removeClass('loading');

                history.replaceState(null, null, currentUrl);

                $accordionContent = $(data).find('.project-single').first();

                Logger.log("$currentTile", $currentTile);

                if($currentTile.hasClass('featured')){
                    Logger.log("is featured");
                    //we remove video in loaded content because it is already visible in teaser-tile
                    $accordionContent.find('.project-video').remove();
                }

                var $closeBtn = $accordionContent.find('.close-project');
                $closeBtn.click(function(e){
                    if($currentTile) $currentTile.find('.tile').removeClass('open').addClass('active');
                    ref.closeProject(true);
                });

                $contentLayer.append($accordionContent);

                //if there is a videoplayer, create it
                if($accordionContent.find('.video-wrap').length > 0){
                    controller.createVideoPlayer();
                }

                $('.embed-responsive').fitVids();

                //init social button
                controller.initTwitterController();

                //tween open layer
                var h = $contentLayer.css('height');
                $contentLayer.removeClass('collapse').addClass('collapsing');

                var togoY = $('.project-content-tile').offset().top + $siteWrap.scrollTop();

                var tl = new TimelineMax({delay:0, paused:false})
                    .set($accordionContent,{autoAlpha:0})
                    .to($contentLayer,.3, {delay:0,
                        css:{height:'auto'},
                        onComplete:function($c){
                            $c.removeClass('collapsing').addClass('collapse in');
                            //ref.resize();
                        },
                        onCompleteParams:[$contentLayer]})
                    .to($siteWrap, 0.5, {scrollTo:togoY})
                    .to($accordionContent,.2,{delay:0,autoAlpha:1});

            },
            error: function (request, status, error) {
            }
        });
    };

    ProjectsPage.prototype.findItemToPrependTo = function(){

        var clickedTileY = $currentTile.position().top;
        Logger.log("clickedTileY -> " + clickedTileY);

        var found = false;
        var $itemToPrepend = '';
        var pos = 0;
        $tilesClicks.closest('.tile-link').each(function(){
            var y = $(this).position().top;

            Logger.log("check pos " + pos + ". its y is " + y);

            if(y > clickedTileY){
                if(!found){
                    Logger.log("found y -> " + $(this).position().top + " at pos " + pos);
                    $itemToPrepend = $(this);
                    found = true;
                }
            }
            pos++;
        });

        return $itemToPrepend;

    };

    ProjectsPage.prototype.closeProject = function(reInitialize,reOpen){

        Logger.log("closeProject, reInitialize -> " + reInitialize + ", $contentLayer -> " + $contentLayer);

        //close layer
        if($contentLayer){

            $contentLayer.removeClass('collapse in').addClass('collapsing');

            var tl = new TimelineMax({delay:0, paused:false})
            //.to($accordionContent,.2,{autoAlpha:0})
            .to($contentLayer,0.5, {delay:0,
                css:{height:0},
                onComplete:function($c){

                    setTimeout(function(){
                        ref.layerOpen = false;

                        $c.remove();
                        if(reInitialize){
                            ref.resize();
                        }
                        if(reOpen){
                            ref.openProject();
                        } else {
                            if($currentTile) $currentTile.find('.tile').removeClass('open').addClass('active');
                        }

                        $tiles.find('.tile').css('height','auto');
                    }, timeout);


                },
                onCompleteParams:[$contentLayer]})

            //reset tile
        }

        history.replaceState(null, null, nativeUrl);

    };

    ProjectsPage.prototype.setTileZindex = function($e){
        for(var a=0; a<$tilesClicks.length;++a){
            var $t = $tilesClicks.eq(a).closest('.tile-link');
            if($t == $e){
                $t.css('zIndex',20);
            } else $t.css('zIndex',-1);
        }
    };

    ProjectsPage.prototype.addFilterToList = function(filter){
        //Logger.log("add filter -> " + filter);
        //check if filter is already in list
        var found = false;
        for (var a = 0; a < filterList.length; ++a) {
            var f = filterList[a];
            if(filter == f) found = true;
        }
        if(!found) filterList.push(filter);

        ref.filterList(filterList, roundList);
    };

    ProjectsPage.prototype.addRoundToList = function(filter){
        //Logger.log("add round -> " + filter);
        //check if round is already in list
        var found = false;
        for (var a = 0; a < roundList.length; ++a) {
            var f = roundList[a];
            if(filter == f) found = true;
        }
        if(!found) roundList.push(filter);

        ref.filterList(filterList, roundList);
    };

    ProjectsPage.prototype.removeFilterFromList = function(filter){
        //Logger.log("remove filter -> " + filter);
        //check if filter is already in list
        for (var a = 0; a < filterList.length; ++a) {
            var f = filterList[a];
            if(filter == f)filterList.splice(a, 1);
        }
        ref.filterList(filterList, roundList);
    };

    ProjectsPage.prototype.removeRoundFromList = function(filter){
        //Logger.log("remove round -> " + filter);
        //check if round is already in list
        for (var a = 0; a < roundList.length; ++a) {
            var f = roundList[a];
            if(filter == f)roundList.splice(a, 1);
        }
        ref.filterList(filterList, roundList);
    };

    ProjectsPage.prototype.filterList = function(filters, rounds){

        $noFilterResult.addClass('hidden');

        var temp_filters = filters.join();
        temp_filters = temp_filters.trim();
        if(temp_filters.length > 0){
            temp_filters = temp_filters.split(',');
        } else {
            temp_filters = []
        }

        var temp_rounds = rounds.join();
        temp_rounds = temp_rounds.trim();
        if(temp_rounds.length > 0){
            temp_rounds = temp_rounds.split(',');
        } else {
            temp_rounds = []
        }

        Logger.log("temp_filters -> " + temp_filters);
        Logger.log("temp_rounds -> " + temp_rounds);

        Logger.log("temp_filters.length -> " + temp_filters.length);
        Logger.log("temp_rounds.length -> " + temp_rounds.length);


        final_filters = [];
        if(temp_rounds.length > 0){
            //needs filters by rounds
            if(temp_filters.length > 0){
                for(var a=0;a<temp_rounds.length;++a){
                    var round = temp_rounds[a];
                    for(var b=0; b<temp_filters.length;b++){
                        var filter = temp_filters[b];
                        var str = filter + round;
                        Logger.log("str ---------------> " + str);
                        final_filters.push(str);
                    }
                }
            } else {
                //no filters, only rounds
                final_filters = temp_rounds;
            }

        } else {
            final_filters = temp_filters;
        }

        Logger.log("final_filters -> " + final_filters);

        //save to cookie
        cookieManager.createCookie('ptf-final-filters_'+window.languageCode, final_filters.join(), 1);
        cookieManager.createCookie('ptf-filters_'+window.languageCode, filters.join(), 1);
        cookieManager.createCookie('ptf-rounds_'+window.languageCode, rounds.join(), 1);

        $projectsTileWrapper.isotope({
            filter: final_filters.join()
        });

        isotopeInitialized = false;
        controller.resetFeaturedProjects();
        ref.resize();

        var $visibleTiles = $('.isotope-item:visible');
        Logger.log("$visibleTiles -------------------> "  +$visibleTiles);
        if($visibleTiles.length > 0){
            var timeline = new TimelineMax({delay:0, paused:false})
                .set($visibleTiles, {opacity: 0, y:'5%'})
                .staggerTo($visibleTiles, 0.4, {opacity: 1, y:'0%'}, 0.2);
        }

    };

    ProjectsPage.prototype.reLayout = function(){
        if(isotopeInitialized){
            isotopeInitialized = false;
            ref.resize();
        }
    }

    ProjectsPage.prototype.resize = function(viewportChanged){

        Logger.log("this.layerOpen ---> " + ref.layerOpen);

        $('.project-content-tile').css( "width", "");

        if(this.layerOpen){

            //find position to prepend layer to
            var $itemToPrepend = $currentTile;
            var $newItem = ref.findItemToPrependTo();

            if($newItem){
                $contentLayer.insertBefore($newItem);
            } else $contentLayer.insertAfter($itemToPrepend);

            return;
        }

        $('.isotope-item').each(function(){
            $(this).css( "width", "").width(parseInt($(this).width()));
            $(this).find('.back').height(parseInt($(this).find('.front').height()));
        });

        if($contentLayer){
            if(viewportChanged) ref.closeProject(true);
        }

        if(!isotopeInitialized){

            Logger.log("reinit isotope");

            $gridsizer.removeClass('hidden');

            $grid = $projectsTileWrapper.imagesLoaded().isotope({
                itemSelector: '.isotope-item',
                percentPosition: true,
                hiddenStyle: {
                    opacity: 0
                },
                visibleStyle: {
                    opacity: 1
                },
                animationEngine: 'best-available',
                transitionDuration:0,
                masonry: {
                    // use element for option
                    columnWidth: '.grid-sizer-projects'
                },
                filter: final_filters.join()
            });
            isotopeInitialized = true;

            $grid.on( 'arrangeComplete', function( event, filteredItems ) {
                Logger.log( '++++++++++++++++++++arrangeComplete with ' + filteredItems.length + ' items' );
                if(filteredItems.length == 0) $noFilterResult.removeClass('hidden');
            });

        }

    };

    window.ProjectsPage = ProjectsPage;

}(window));
