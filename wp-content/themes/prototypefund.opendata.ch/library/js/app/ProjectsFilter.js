/**
 * Created by User on 23.09.2019.
 */
(function(window){

    ProjectsFilter.prototype.constructor = ProjectsFilter;
    ProjectsFilter.prototype = {
    };
    
    var ref, controller, $filterBtn, $filterTabs, $projects, $nothingFoundInfo, $projectsList, showFilter, $topicFilterBtns, $topicFilterResetBtn,
        topicsFilterArray;
    function ProjectsFilter(pController){
        ref = this;
        controller = pController;

        Array.prototype.diff = function(arr2) {
            var ret = [];
            this.sort();
            arr2.sort();
            for(var i = 0; i < this.length; i += 1) {
                if(arr2.indexOf(this[i]) > -1){
                    ret.push(this[i]);
                }
            }
            return ret;
        };

        topicsFilterArray = [];

        showFilter = $('.filter-wrap').attr('data-filter');
        var $tab = $(".filter-tab[data-id='" + showFilter +"']");
        Logger.log("$tab -> " + $tab.length);
        if($tab.length > 0){
            var $c = $tab.find('.filter-tab-content');
            $tab.addClass('open');
            TweenMax.set($c, {display:"block", height:"auto"});
            var tl = TweenMax.from($c, 0.3, { height: 0, ease: Power3.easeOut }, 0);
        }

        $nothingFoundInfo = $('.nothing-found-info');
        $filterTabs = $('.filter-tab');
        $filterBtn = $('.filter-tab-header');
        $filterBtn.click(function(e){
            var $tab = $(this).parent();
            var $content = $(this).next();
            if(!$tab.hasClass('open')){
                //open

                var current = $tab.attr('data-id');

                //close others if open
                $filterTabs.each(function(){
                    var id = $(this).attr('data-id');
                    if(id != $tab.attr('data-id')){
                        if($(this).hasClass('open')){
                            $(this).removeClass('open');
                            var $c = $(this).find('.filter-tab-content');
                            var tl = TweenMax.to($c, 0.3, { height: 0, ease: Power3.easeOut }, 0);
                        }
                    }
                });

                $tab.addClass('open');
                TweenMax.set($content, {display:"block", height:"auto"});
                var tl = TweenMax.from($content, 0.3, { height: 0, ease: Power3.easeOut }, 0);
                var url = ref.setUrlParameter(window.location.href,'filter',current);
                history.pushState(null, null, url);

            } else {
                //close
                $tab.removeClass('open');
                var tl = TweenMax.to($content, 0.3, { height: 0, ease: Power3.easeOut }, 0);
                var url =  ref.setUrlParameter(window.location.href,'filter','');
                history.pushState(null, null, url);
            }
        });

        $projectsList = $('.projects-list, .posts-list');
        $projects = $('.project-list-item, .post-list-item');

        //category (topics) filters
        $topicFilterBtns = $('.topics.filter-tab').find('.btn-project-filter');
        $topicFilterBtns.click(function(e){
            e.preventDefault();
            var topic = $(this).attr('data-filter');
            if(!$(this).hasClass('selected')){
                ref.addTopicToFilter(topic);
            } else{
                ref.removeTopicFromFilter(topic);
            }

        });
        $topicFilterResetBtn = $('.topics.filter-tab').find('.btn-filter-reset');
        $topicFilterResetBtn.click(function(e){
            topicsFilterArray = [];
            $topicFilterBtns.removeClass('selected');
            ref.filterProjectsByTopics();
            e.preventDefault();
        });

        var initialTopics = ref.getUrlParameter(window.location.href,'topics');
        if(initialTopics.length > 0){
            var initTopics = initialTopics.split(',');
            Logger.log("initTopics", initTopics);
            for(var a=0;a<initTopics.length;++a){
                ref.addTopicToFilter(initTopics[a]);
            }
        } else {
            TweenMax.to($projectsList,0.5,{autoAlpha:1, ease:Sine.easeOut});
        }
    };

    ProjectsFilter.prototype.addTopicToFilter = function(topic){

        $(".btn-project-filter[data-filter='" + topic +"']").addClass('selected');

        var found = false;
        for(var a=0; a<topicsFilterArray.length;++a){
            var t = topicsFilterArray[a];
            if(t == topic) found = true;
        }
        if(!found){
            topicsFilterArray.push(topic);
            ref.filterProjectsByTopics();
        }
    };

    ProjectsFilter.prototype.removeTopicFromFilter = function(topic){

        $(".btn-project-filter[data-filter='" + topic +"']").removeClass('selected');

        for(var a=0; a<topicsFilterArray.length;++a){
            var t = topicsFilterArray[a];
            if(t == topic){
                topicsFilterArray.splice(a, 1);
            }
        }
        ref.filterProjectsByTopics();
    };

    ProjectsFilter.prototype.filterProjectsByTopics = function(){
        Logger.log("filterProjectsByTopics -> " + topicsFilterArray);

        var url = ref.setUrlParameter(window.location.href ,'topics',topicsFilterArray.join());
        history.pushState(null, null, url);
        Logger.log("url -> " + url);

        if(topicsFilterArray.length ==0){
            //no filter selected, show all
            $projects.removeClass('filtered');
        } else {
            $projects.each(function(i){
                var $item = $(this);
                var pF = $(this).attr('data-filter');

                var projectTopicsArray = pF.split(",");
                var res = projectTopicsArray.diff(topicsFilterArray);
                if(res == 0){
                    $item.addClass('filtered')
                } else $item.removeClass('filtered');
            });

            var currentlyVisible = $projects.not(".filtered").length;
            if(currentlyVisible == 0){
                //nothing was found: display "not found" message
                $nothingFoundInfo.removeClass('hidden');
            } else $nothingFoundInfo.addClass('hidden');

        }

        TweenMax.set($projectsList,{autoAlpha:0, ease:Sine.easeOut});
        TweenMax.to($projectsList,0.5,{autoAlpha:1, ease:Sine.easeOut});

    };

    ProjectsFilter.prototype.arrayDiff = function(arr1, arr2){

    };

    ProjectsFilter.prototype.setUrlParameter = function(url, key, value){
        var key = encodeURIComponent(key),
            value = encodeURIComponent(value);

        var baseUrl = url.split('?')[0],
            newParam = key + '=' + value,
            params = '?' + newParam;

        if (url.split('?')[1] === undefined){ // if there are no query strings, make urlQueryString empty
            urlQueryString = '';
        } else {
            urlQueryString = '?' + url.split('?')[1];
        }

        // If the "search" string exists, then build params from it
        if (urlQueryString) {
            var updateRegex = new RegExp('([\?&])' + key + '[^&]*');
            var removeRegex = new RegExp('([\?&])' + key + '=[^&;]+[&;]?');

            if (value === undefined || value === null || value === '') { // Remove param if value is empty
                params = urlQueryString.replace(removeRegex, "$1");
                params = params.replace(/[&;]$/, "");

            } else if (urlQueryString.match(updateRegex) !== null) { // If param exists already, update it
                params = urlQueryString.replace(updateRegex, "$1" + newParam);

            } else if (urlQueryString == '') { // If there are no query strings
                params = '?' + newParam;
            } else { // Otherwise, add it to end of query string
                params = urlQueryString + '&' + newParam;
            }
        }

        // no parameter was set so we don't need the question mark
        params = params === '?' ? '' : params;

        return baseUrl + params;
    };

    ProjectsFilter.prototype.getUrlParameter = function(url, parameter){
        parameter = parameter.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
        var regex = new RegExp('[\\?|&]' + parameter.toLowerCase() + '=([^&#]*)');
        var results = regex.exec('?' + url.toLowerCase().split('?')[1]);
        return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    };

    window.ProjectsFilter = ProjectsFilter;

}(window));
