/**
 * Created by User on 29.10.2019.
 */
jQuery(document).ready(function($) {


    $('.random-projects-btn').click(function(e){
        var data = {
            action: 'fetch_random_projects',
            security : MyAjax.security
        };
    });



    // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
    $.post(MyAjax.ajaxurl, data, function(response) {
        alert('Got this from the server: ' + response);
    });
});
