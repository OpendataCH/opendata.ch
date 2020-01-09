/**
 * Author: CReich
 * Company: Rainbow Unicorn
 * Date: 02.02.2016
 * Created: 16:38
 **/
 (function(window){

    MapController.prototype.constructor = MapController;
    
    MapController.prototype = {
        image_base_url: '',
        map: '',
        map_item_json:'',
        mapbox_access_token : "pk.eyJ1IjoicmFpbmJvd3VuaWNvcm4iLCJhIjoiY2sxZ2dkdWJlMDI0YzNkbnIxMnZsdnZ0ZSJ9.P9t83fxQIfKeSUr8PjF-1Q",
        mapbox_project_id : "rrainbowunicorn.cjnk56noc0h5z2qmw1rs5yccr-3bnap"
    };
    
    var ref, controller, options, domId,
    MapMarker,  projectMarkers, eventMarkers, endpoint;
    
    function MapController(pController){
        ref = this;
        controller = pController;
        ref.image_base_url = window.themePath + '/library/images/map/';

        domId = 'map';
        ref.init();
    }

    MapController.prototype.init = function(pJson){

        //create map
        var screensize = controller.viewport().screensize;
        var zoom  = 5; // xxs
        if(screensize == "screen_xs")    zoom = 6;
        if(screensize == "screen_sm")    zoom = 6;
        if(screensize == "screen_md")    zoom = 6;
        if(screensize == "screen_lg")    zoom = 6;

        // set up and init the map
        options = {
            center: [52.5345947, 13.3955538],
            zoom: zoom,
            scrollWheelZoom: false,
            type: 'home',
            endpoint: 'http://prototypefund.local/site/wp-json/map/'
        };

        ref.map = L.map(domId, options);
        ref.map.attributionControl.setPrefix("");
        ref.map.scrollWheelZoom.disable();
        //ref.map.once('focus', function() { ref.map.scrollWheelZoom.enable(); });

        L.tileLayer('https://api.mapbox.com/styles/v1/rainbowunicorn/ck1ggh47t25el1ct986yvjp6x/tiles/256/{z}/{x}/{y}@2x?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
            maxZoom: 18,
            accessToken: ref.mapbox_access_token
        }).addTo(ref.map);

        ref.updateMap('all');
    };

    MapController.prototype.updateMarkers = function(map_item_json){
        Logger.log("createMarkers -> ", map_item_json);

        projectMarkers = L.markerClusterGroup();

        //create markers

            Logger.log("ref.image_base_url -> " +ref.image_base_url);

        for(var a=0;a<map_item_json.length;++a){
            var obj = map_item_json[a];


            var BaseIcon = L.Icon.extend({
                options: {
                    shadowUrl: '',
                    iconSize:     [50, 50],
                    shadowSize:   [0, 0],
                    iconAnchor:   [10, 50],
                    shadowAnchor: [0, 0],
                    popupAnchor:  [15, -50]
                }
            });
            var iconUrl = ref.image_base_url + 'ptf-icon.svg';
            if(obj.post_thumbnail) iconUrl = obj.post_thumbnail;
            var projectIcon = new BaseIcon({iconUrl: iconUrl});

            if( typeof obj.geolocation.lat == 'undefined' || typeof obj.geolocation.lng == 'undefined' ) {
                Logger.log('Notice: Post with missing lat / lng, skipping... ');
            } else {
                var marker = L.marker([parseFloat(obj.geolocation.lat), parseFloat(obj.geolocation.lng)], {
                    icon: projectIcon,
                    title: obj.post_title
                });

                var popUpInner = '<div class="leaflet-project-layer"><h3 class="leaflet-project-title uppercase">'+ obj.post_title +'</h3><div class="leaflet-project-link"><a href="' + obj.post_link + '" class="svg-arrow-2020-right svg-arrow-2020-right-dims arrow-right"></a></div></div>';

                marker.bindPopup(popUpInner);
                projectMarkers.addLayer(marker);

            }

        }

        ref.map.addLayer(projectMarkers);



    };

    MapController.prototype.updateMap = function( queryParam ) {


        var url = options.endpoint + options.type + "/" + queryParam;
        $('.map-loading').addClass('on');
        // console.log(url);

        $.ajax({
         url: url,
         type: 'get',
         success: function( data ) {

            if( typeof projectMarkers != 'undefined') {
                ref.map.removeLayer(projectMarkers);
            }

            // is there actually anything to show ?
            if( data ) {
                ref.updateMarkers(data);
            }

            $('.map-loading').removeClass('on');

        }
    });
        
    };

    window.MapController = MapController;

}(window));
