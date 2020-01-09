/**
 * Author: CReich
 * Company: Rainbow Unicorn
 * Date: 22.06.2016
 * Created: 17:23
 **/
(function(window){

    CookieManager.prototype.constructor = CookieManager;
    CookieManager.prototype = {
        daysTillCookieExpiration: 3650
    };

    var ref, userAcceptedCookies, $, initialized;
    function CookieManager(){
        ref = this;
        $ = window.jQuery;
    };

    CookieManager.prototype.createCookie = function(name,value,days){

        //console.log("Create cookie: " + name + ", value: " + value + ", days: " + days);

        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime()+(days*24*60*60*1000));
            expires = "; expires="+date.toGMTString();
        }

        document.cookie = name+"="+value+expires+"; path=/";
    };

    CookieManager.prototype.readCookie = function (name){
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for(var i=0;i < ca.length;i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1,c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
        }
        return null;
    };

    CookieManager.prototype.eraseCookie = function (name){
        ref.createCookie(name,"",-1);
    };

    window.CookieManager = CookieManager;

}(window));
