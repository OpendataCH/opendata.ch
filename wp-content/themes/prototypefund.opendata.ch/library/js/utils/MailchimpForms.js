/**
 * Author: CReich
 * Company: Rainbow Unicorn
 * Date: 08.07.2016
 * Created: 16:18
 **/
(function(window){

    MailchimpForms.prototype.constructor = MailchimpForms;
    MailchimpForms.prototype = {
        val0 : '',
        val1 : ''
    };
    
    var ref, $forms;
    function MailchimpForms(){
        ref = this;
    };

    MailchimpForms.prototype.init = function(){

        $forms = $('.mailchimp-form');
        $forms.each(function(){
            var $submitBtn = $(this).find('.mc-embedded-subscribe');
            var $field_email = $(this).find('.mce-EMAIL');
            var $responseText = $(this).find('.mce-response');

            /*
            $submitBtn.click(function(){
                Logger.log("submitting email...");

                var win = window.open('https://prototypefund.us5.list-manage.com/subscribe?u=929f1e07936386d34833e20d1&id=d6f6159664', '_blank');
                win.focus();
                return;

                var btn = $(this);
                btn.addClass('inactive');

                $responseText.css('visibility','hidden').removeClass('error success');

                $.ajax({
                    url: window.themePath + '/library/php/mailchimp/store-address.php',
                    type: 'POST',
                    data: 'lang=' + window.languageCode + '&email=' + $field_email.val(),
                    success: function(result) {

                        Logger.log("result: " + result);

                        var obj = $.parseJSON(result);
                        if(obj.success == true)
                        {
                            //all good

                            $responseText.html(obj.msg).addClass('success').css('visibility','visible');
                            $submitBtn.remove();
                            $field_email.remove();

                        } else
                        {
                            //mailchimp send error
                            Logger.log("error: " + obj.code);

                            $submitBtn.removeClass('inactive');

                            $responseText.html(obj.msg).addClass('error').css('visibility','visible');

                        }

                    }
                });
                return false;
            });
            */

        });

    };

    window.MailchimpForms = MailchimpForms;

}(window));
