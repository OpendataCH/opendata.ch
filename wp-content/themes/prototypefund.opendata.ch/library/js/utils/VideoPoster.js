/**
 * Author: CReich
 * Company: Rainbow Unicorn
 * Date: 14.10.2017
 * Created: 16:33
 **/
(function(window){

    VideoPoster.prototype.constructor = VideoPoster;
    VideoPoster.prototype = {
    };
    
    var ref, $;
    function VideoPoster(){
        ref = this;

        $ = window.jQuery;

        $('.poster-wrap').click(function(ev){
            ev.preventDefault();
            var $poster = $(this);
            var $wrapper = $poster.closest('.js-videoWrapper');
            ref.videoPlay($wrapper);
        });

    };

    VideoPoster.prototype.videoPlay = function($wrapper){

        ref.videoStop();
        var $iframe = $wrapper.find('.js-videoIframe').addClass('clicked');
        var $poster =  $wrapper.find('.poster-wrap').addClass('hidden');
        var src = $iframe.data('src');
        // hide poster
        $wrapper.addClass('videoWrapperActive');
        // add iframe src in, starting the video
        $iframe.attr('src',src);

        Logger.log("videoPlay -> ", $iframe );

    };

    VideoPoster.prototype.videoStop = function($wrapper){
        // if we're stopping all videos on page
        if (!$wrapper) {
            var $wrapper = $('.js-videoWrapper');
            var $iframe = $('.js-videoIframe');
            $('.poster-wrap').removeClass('hidden');
            // if we're stopping a particular video
        } else {
            var $iframe = $wrapper.find('.js-videoIframe');
        }
        // reveal poster
        $wrapper.removeClass('videoWrapperActive');
        // remove youtube link, stopping the video from playing in the background
        $iframe.attr('src','');
    };

    window.VideoPoster = VideoPoster;

}(window));
