/**
 * Author: CReich
 * Company: Rainbow Unicorn
 * Date: 13.07.2016
 * Created: 15:34
 **/
(function(window){

    TwitterShareController.prototype.constructor = TwitterShareController;
    TwitterShareController.prototype = {
        winWidth: "520",
        winHeight: "275"
    };

    var ref;
    function TwitterShareController(){
        ref = this;
    };

    TwitterShareController.prototype.init = function(){

        //setup twitter links for twitter retweets
        $('.twitter-retweet-link').click(function(e){

            var $e = $(this);
            var type = $e.attr('data-type');
            var url = $e.attr('data-href');

            switch(type)
            {
                case 'twitter-related': case 'twitter-ptf':
                //twitter
                ref.retweetURL(url);
                break;
            }

            e.preventDefault();
            return false;
        });

        $('.twitter-tweet-link').click(function(e){

            var $e = $(this);
            var url = $e.attr('href');

            Logger.log("url ------------- > " + url);

            ref.retweetURL(url);

            e.preventDefault();
            return false;

        });

        $('.twitter-follow-link').click(function(e){

            var $e = $(this);
            var url = $e.attr('href');

            Logger.log("url ------------- > " + url);

            ref.retweetURL(url);

            e.preventDefault();
            return false;

        });

    };

    TwitterShareController.prototype.createTweetTextURL = function(text)
    {
        return 'http://twitter.com/share?text=' + encodeURI(text);
    };

    TwitterShareController.prototype.tweetText = function(text)
    {
        Logger.log("tweetText -> " + text);
        if(window.deviceType != 'computer'){
            //just open as link
            window.location.href = ref.createTweetTextURL(text);
        } else {
            //on desktop we open in popup
            window.open(ref.createTweetTextURL(text), 'twitter', ref.createWindowSizeOptions());
        }
    };

    /*********************
    retweets a give url
    *********************/
    TwitterShareController.prototype.retweetURL = function(url)
    {
        Logger.log("retweetURL -> " + url);

        if(window.deviceType != 'computer'){
            //just open as link
            window.location.href = url;
        } else {
            //on desktop we open in popup
            window.open(url, 'twitter', ref.createWindowSizeOptions());
        }

    };


    TwitterShareController.prototype.createWindowSizeOptions = function(){

        var wW = $(window).width();
        var wH = $(window).height();

        var winTop = ($(window).height() / 2) - (ref.winHeight / 2);
        var winLeft = ($(window).width() / 2) - (ref.winWidth / 2);

        var opts   = 'status=1' +
            ',width='  + ref.winWidth  +
            ',height=' + ref.winHeight +
            ',top='    + winTop    +
            ',left='   + winLeft;

        return opts;

    };

    window.TwitterShareController = TwitterShareController;

}(window));
