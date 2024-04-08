/**
 * Created by User on 23.09.2019.
 */
(function(window){

    ProjectsFilter.prototype.constructor = ProjectsFilter;
    ProjectsFilter.prototype = {
    };

    var ref, controller, $filterBtn, $filterTabs, $projects, $nothingFoundInfo, $projectsList, showFilter, $topicFilterBtns, $topicFilterResetBtn,
        topicsFilterArray, $paginationButtons, $newsFilterResetBtn, $pagination, page_index, $descriptionWrap, $descriptions, $srStatus;
    function ProjectsFilter(pController){
        ref = this;
        controller = pController;
        page_index = 1;

        /*
         var $claims = $('.project-list-item-copy.claim').find('p');
         $claims.each(function(){
         var $content = $(this).html();
         $(this).html('<span class="claim-highlight">' + $content + '</span>');
         });
         */



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
        if($tab.length > 0){
            var $c = $tab.find('.filter-tab-content');
            $tab.addClass('open');
            $tab.find('.filter-tab-header button')[0].setAttribute('aria-expanded', true);
            TweenMax.set($c, {display:"block", height:"auto"});
            var tl = TweenMax.from($c, 0.3, { height: 0, ease: Power3.easeOut }, 0);
            var url = ref.setUrlParameter(window.location.href,'filter',showFilter);
            history.pushState(null, null, url);
        }

        $descriptionWrap = $('.topic-description-wrap');
        $descriptions = $('.topic-description');
        $pagination = $('.projects-pagination');
        $paginationButtons = $('.projects-pagination-btn',$pagination);
        $nothingFoundInfo = $('.nothing-found-info');
        $filterTabs = $('.filter-tab');
        $filterBtn = $('.filter-tab-header button');
        $filterBtn.click(function(e){
            var $tab = $(this).closest('.filter-tab');
            var $content = $tab.find('.filter-tab-content');

            var current = $tab.attr('data-id');

            if(!$tab.hasClass('open')){
                //open

                //close others if open
                $filterTabs.each(function(){
                    var id = $(this).attr('data-id');
                    if(id != $tab.attr('data-id')){
                        if($(this).hasClass('open')){
                            $(this).removeClass('open');
                            var $c = $(this).find('.filter-tab-content');
                            $(this).find('.filter-tab-header button')[0].setAttribute('aria-expanded', false);
                            var tl = TweenMax.to($c, 0.3, { height: 0, display: 'none', ease: Power3.easeOut }, 0);
                        }
                    }
                });

                $tab.addClass('open');

                this.setAttribute('aria-expanded', true);
                TweenMax.set($content, {display:"block", height:"auto"});
                var tl = TweenMax.from($content, 0.3, { height: 0, ease: Power3.easeOut }, 0);

                if(current){
                    var url = ref.setUrlParameter(window.location.href,'filter',current);
                    history.pushState(null, null, url);
                }

            } else {
                //close
                $tab.removeClass('open');
                this.setAttribute('aria-expanded', false);
                var tl = TweenMax.to($content, 0.3, { height: 0, display: 'none', ease: Power3.easeOut }, 0);

                if(current){
                    var url =  ref.setUrlParameter(window.location.href,'filter','');
                    history.pushState(null, null, url);
                }
            }
        });

        $projectsList = $('.projects-list, .posts-list');
        $projects = $('.project-list-item, .post-list-item');
        $srStatus = $('.sr-status');

        //category (topics) filters
        $topicFilterBtns = $('.topics.filter-tab').find('.btn-project-filter');
        $topicFilterBtns.click(function(e){
            e.preventDefault();
            var topic = $(this).attr('data-filter');
            if(!$(this).hasClass('selected')){
                ref.addTopicToFilter(topic);
                $srStatus[0].textContent = 'Filter ' + $(this).text() + ' ausgewählt. Projektliste aktualisiert.';
            } else{
                $srStatus[0].textContent = 'Filter ' + $(this).text() + ' nicht mehr ausgewählt. Projektliste aktualisiert.';
                ref.removeTopicFromFilter(topic);
            }
        }).mouseover(function() {
            var filter = $(this).attr('data-filter');
            ref.showTopicInfo(filter);
        }).mouseout(function() {
            ref.hideTopicInfo();
        });

        $topicFilterResetBtn = $(".btn-filter-reset[data-reset='topic']");
        $topicFilterResetBtn.click(function(e){
            topicsFilterArray = [];
            $topicFilterBtns.removeClass('selected');
            ref.filterProjectsByTopics();
            $srStatus[0].textContent = 'Filter reset';
            e.preventDefault();
        });



        $newsFilterResetBtn = $(".btn-filter-reset[data-reset='news']");
        $newsFilterResetBtn.click(function(e){
            $('.news-tile').removeClass('filtered');
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
            $pagination.addClass('hidden');
        } else {
            TweenMax.to($projectsList,0.5,{autoAlpha:1, ease:Sine.easeOut});
        }


        if($paginationButtons.length > 0){
            $paginationButtons.click(function(e){
                e.preventDefault();
                $paginationButtons.removeClass('active');
                $paginationButtons.attr('aria-pressed',false);

                var page_id = $(this).attr('data-id');
                page_index = page_id;
                $(this).addClass('active');
                $(this).attr('aria-pressed',true);
                $projects.addClass('paginated');
                $projectsList.find("[data-page='" + page_id + "']").removeClass('paginated');
                var eTop = $('.filter-wrap').offset().top; //get the offset top of the element
                $srStatus[0].textContent = 'Projeke: Seite ' + page_id; // TODO: multilang
                $projectsList.focus();
                window.scroll({
                    top: eTop,
                    left: 0,
                    behavior: 'smooth'
                });
            });
        }

    };

    ProjectsFilter.prototype.showTopicInfo = function(filter){
        $descriptions.addClass('hidden');
        var $info = $descriptionWrap.find("[data-slug='" + filter + "']");
        if($info.length > 0){
            //exists
            $info.removeClass('hidden');
            $descriptionWrap.removeClass('hidden');
        } else {
            $descriptionWrap.addClass('hidden');
        }

    };

    ProjectsFilter.prototype.hideTopicInfo = function(){
        $descriptionWrap.addClass('hidden');
        $descriptions.addClass('hidden');
    };

    ProjectsFilter.prototype.addTopicToFilter = function(topic){

        $(".btn-project-filter[data-filter='" + topic +"']").addClass('selected');
        $(".btn-project-filter[data-filter='" + topic +"']").attr('aria-pressed',true);

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
        $(".btn-project-filter[data-filter='" + topic +"']").attr('aria-pressed',false);

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

        $descriptions.addClass('hidden');
        if(topicsFilterArray.length ==0){

            $descriptionWrap.addClass('hidden');
            $topicFilterResetBtn.addClass('hidden');

            //no filter selected, show all, depending on page_index
            $projects.removeClass('filtered').addClass('paginated');
            $projectsList.find("[data-page='" + page_index + "']").removeClass('paginated');
            $pagination.removeClass('hidden');
            $('.news-tile').removeClass('filtered').removeClass('paginated');
            $srStatus[0].textContent = 'Kein Filter ausgewählt.';

        } else {

            $descriptionWrap.removeClass('hidden');
            $topicFilterResetBtn.removeClass('hidden');
            for(var a=0; a<topicsFilterArray.length;++a){
                var topic = topicsFilterArray[a];
                Logger.log("topic -> " + topic);
                $descriptionWrap.find("[data-slug='" + topic + "']").removeClass('hidden');
            }

            $pagination.addClass('hidden');
            $projects.each(function(i){
                var $item = $(this);
                var pF = $(this).attr('data-filter');

                $item.removeClass('paginated');

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
