/**
 * Author: CReich
 * Company: Rainbow Unicorn
 * Date: 05.07.2016
 * Created: 19:49
 **/
(function(window){

    NewsPage.prototype.constructor = NewsPage;
    NewsPage.prototype = {
        val0 : '',
        val1 : ''
    };

    var ref, controller,
        $newsTileWrapper, $newsTileTexts, $newsTileLinks, $tiles, isotopeInitialized;
    function NewsPage(pController){
        ref = this;
        controller = pController;
    };

    NewsPage.prototype.init = function(){

        Logger.log("Init NewsPage.");

        $newsTileWrapper = $('.news-tile-wrapper');
        $newsTileTexts = $('.text',$newsTileWrapper);
        $newsTileLinks = $('.tile-link',$newsTileWrapper);
        $tiles = $('.tile-link',$newsTileWrapper);

        //setup all linkings for the tiles
        $newsTileLinks.click(function(e){

            e.preventDefault();

            var $e = $(this);
            var type = $e.attr('data-type');
            var url = $e.attr('data-href');

            Logger.log("type: " + type + ", url: " + url);

            switch(type)
            {
                case 'wp-blogpost':
                    //wordpress
                    window.location.href = url;
                break;

            }


            return false;
        });

        $newsTileTexts.find('a').click(function(e){
            e.stopPropagation();
        });

    };

    NewsPage.prototype.resize = function(w){
        ref.calculateNewsTileTextSizes();

        if(w >= 1024){

            $tiles.each(function(){
                $(this).css( "width", "").width(parseInt($(this).width()));
            });

            if(!isotopeInitialized){

                $newsTileWrapper.imagesLoaded().isotope({
                    itemSelector: '.tile-link',
                    percentPosition: true,
                    //sortBy: 'original-order',
                    masonry: {
                        // use element for option
                        columnWidth: '.grid-sizer'
                    }
                });
                isotopeInitialized = true;
            }

        } else {
            //destroy isotope
            if(isotopeInitialized){
                $newsTileWrapper.isotope('destroy');
                isotopeInitialized = false;
                $tiles.each(function(){
                    $(this).css( "width", "" );
                });
            }

        }

    };

    NewsPage.prototype.calculateNewsTileTextSizes = function()
    {
        $newsTileTexts.each(function(){
            var $e = $(this);
            $e.removeClass('size-0-20 size-20-50 size-50-80 size-80-100 size-100-120 size-120-140');
            var l = $e.text().trim().length;
            if(l>=0 && l < 20){
                $e.addClass('size-0-20');
            } else if(l>=20 && l < 50){
                $e.addClass('size-20-50');
            } else if(l>=50 && l < 80){
                $e.addClass('size-50-80');
            } else if(l>=80 && l < 100){
                $e.addClass('size-80-100');
            } else if(l>=100 && l < 120){
                $e.addClass('size-100-120');
            } else if(l>=120){
                $e.addClass('size-120-140');
            }
        });
    };

    window.NewsPage = NewsPage;

}(window));
