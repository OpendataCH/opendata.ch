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
        $newsTileWrapper, $newsTileTexts, $newsTileLinks, $tiles, isotopeInitialized, $newsTileInner,touchtime;
    function NewsPage(pController){
        ref = this;
        controller = pController;
        touchtime = 0;
    };

    NewsPage.prototype.init = function(){

        Logger.log("Init NewsPage.");
        $newsTileWrapper = $('.news-tile-wrapper');
        $newsTileInner = $('.news-tile-inner');

        //hover on mobile
        if($('html').hasClass('touch')){

            /*
            $newsTileInner.bind('touchstart touchend', function(e) {
               //e.preventDefault();
                $(this).toggleClass('hover-mobile');
            });
            */

            /*
            $newsTileInner.click(function(e){
                e.preventDefault();
            }).on('touchstart', function(){
                if(!$(this).hasClass('hover-mobile')){
                    var index = $(this).attr('data-index');
                    //first touch
                    //reset all other tiles
                    $newsTileInner.each(function(i){
                        if(i != index){
                            //remove all hovers
                            $(this).removeClass('hover-mobile');

                        } else {
                            var touched = $(this).attr('data-touched');

                            console.log("touched -> " + touched);

                            if(parseInt(touched) == 0){
                                //first touch
                                $(this).attr('data-touched',1);
                            } else if(parseInt(touched) == 1){
                                $(this).attr('data-touched',2);
                            }
                        }
                    });
                } else {
                }
            }).on('touchend', function(){
                var touched = $(this).attr('data-touched');
                if(parseInt(touched) == 2){
                    alert('go to page!');
                }
            });
            */
        }

    };

    NewsPage.prototype.resize = function(w){

    };

    window.NewsPage = NewsPage;

}(window));
