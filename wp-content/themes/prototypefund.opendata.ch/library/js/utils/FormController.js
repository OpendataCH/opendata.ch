/**
 * Author: CReich
 * Company: Rainbow Unicorn
 * Date: 27.07.2017
 * Created: 16:23
 **/
(function(window){

    FormController.prototype.constructor = FormController;
    FormController.prototype = {
        val0 : '',
        val1 : ''
    };
    
    var ref, $, controller, $buttonSubmit, $successMessage,
        $form, $formGroups, $alreadyInText, $submitErrorText, $loader;
    function FormController(pController){
        ref = this;
        controller = pController;
        $ = window.jQuery;

        Logger.log("Initialize PTF form");

        $form = $('.ptf-form');
        $formGroups = $('.form-group');
        $alreadyInText = $('.already-in-text');
        $submitErrorText = $('.submit-error-text');
        $loader = $('.loading-spinner');
        $successMessage = $('.success-message');

        $buttonSubmit = $('.button-submit');
        $buttonSubmit.click(function(e){
            ref.validateData();
            e.preventDefault();
        });

    };

    FormController.prototype.validateData = function(){

        Logger.log("validateData");

        ref.removeAllErrors();


        var error = 0;

        // trim values
        $('input',$form).each(function(){
            $(this).val($.trim($(this).val()));
        });

        //check if mandatory fields were filled
        $('input.mandatory',$form).each(function(){
            var value = $(this).val();

            Logger.log("val -> " + value.length);

            if(value.length == 0){
                $(this).closest('.form-group').addClass('error');
                error++;
            }
        });

        //check if email is valid, if its filled
        var $email = $( "input[name='inputEmail']" );
        var $grp = $email.closest('.form-group');
        if($email.val().length > 0){
            var valid = ref.validateEmail($email.val());
            if(!valid){
                error++;
                $grp.addClass('error');
                $grp.find('.error-msg').addClass('error-1');
            }
        }

        if(error == 0){
            //all fine
            ref.submitForm();
        }

    };

    FormController.prototype.submitForm = function(){

        //collect data

        $buttonSubmit.addClass('hidden');
        $form.addClass('locked');
        $loader.removeClass('hidden');

        var data = $form.serializeArray();

        data.push({
            name: "security",
            value: ptf_ajax.security
        });

        data.push({
            name: "action",
            value: "store_participant"
        });

        data.push({
            name: "event",
            value: $form.attr('data-event')
        });

        data = $.param(data);

        Logger.log("Collected values to submit to " + $form.attr('action') + ":\n" + data);

        $.post(ptf_ajax.ajaxurl, data, function(response) {

            Logger.log("data -> " + response);

            $loader.addClass('hidden');

            if(response == 'success'){

                //erase cookies
                $form.addClass('hidden')
                $successMessage.removeClass('hidden');


            } else if(response == 'error') {

                $submitErrorText.removeClass('hidden');
                $buttonSubmit.removeClass('hidden');
                $form.removeClass('locked');
                $loader.addClass('hidden');

            } else if(response == 'already_in'){

                $buttonSubmit.removeClass('hidden');
                $alreadyInText.removeClass('hidden');
                $form.removeClass('locked');
                $loader.addClass('hidden');

            }

        });

    };

    FormController.prototype.validateEmail = function(email){
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    };

    FormController.prototype.removeAllErrors = function(){
        $formGroups.removeClass('error');
        $alreadyInText.addClass('hidden');
        $submitErrorText.addClass('hidden');
        $formGroups.find('.error-msg').removeClass('error-0 error-1');
    };

    window.FormController = FormController;

}(window));
