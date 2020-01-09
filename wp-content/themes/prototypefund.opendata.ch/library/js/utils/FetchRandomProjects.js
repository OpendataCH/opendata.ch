/**
 * Created by User on 29.10.2019.
 */
jQuery(document).ready(function($) {

    return
    $fetchButton = $('.random-projects-btn');
    $fetchButton.click(function(){
        $fetchButton.find('.fas').addClass('rotating');
        var data = {
            action: 'fetch_random_projects',
            security : ptf_ajax.security
        };

        $.post(ptf_ajax.ajaxurl, data, function(response) {

            var items = JSON.parse(response);
            console.log(items);
            if(items.length > 0){
                items.forEach(function(item, index){
                    var $link = $('.project-link').eq(index);
                    $link.attr('href',item.permalink);
                    $link.find('span').html(item.post_title);
                });
            }
            $fetchButton.find('.fas').removeClass('rotating');
        });
    })



});