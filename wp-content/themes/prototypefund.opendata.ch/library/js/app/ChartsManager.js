/**
 * Author: CReich
 * Company: Rainbow Unicorn
 * Date: 19.10.2017
 * Created: 12:25
 **/
(function(window){

    ChartsManager.prototype.constructor = ChartsManager;
    ChartsManager.prototype = {
        val0 : '',
        val1 : ''
    };
    
    var ref, options, controller, doughnutChart1, doughnutChart2, doughnutChart3, prefersReducedMotion;
    function ChartsManager(pController){
        ref = this;
        controller = pController;

        Chart.defaults.global.animation.onComplete = ref.onComplete;
        prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    };

    ChartsManager.prototype.init = function(){
        Logger.log("ChartsManager!!! init");
        ref.initBgs();

        //ref.initChart1();
        //ref.initChart2();
        //ref.initChart3();
    };

    ChartsManager.prototype.initBgs = function(){
        var config = {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [100],
                    backgroundColor: [
                        'rgb(179, 224, 240)'
                    ],
                    borderWidth: 0
                }]
            },
            options: options = {
                maintainAspectRatio : false,
                tooltips: {
                    enabled: false
                },
                responsive: true,
                animation: {
                    animateScale: false,
                    animateRotate: false,
                    onComplete: null
                },
                cutoutPercentage: 85
            }
        };

        var bg1 = new Chart($('#chart-1-bg'), config);

    }

    ChartsManager.prototype.initChart1 = function(){
        var config = {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [
                        parseInt(window.fillPercentage),
                        parseInt(100-parseInt(window.fillPercentage))
                    ],
                    backgroundColor: [
                        'rgb(0, 154, 206)',
                        'transparent'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                maintainAspectRatio : false,
                tooltips: {
                    enabled: false
                },
                responsive: true,
                animation: {
                    duration: 0,
                    easing: 'easeOutCubic',
                    animateScale: false,
                    animateRotate: false
                },
                cutoutPercentage: 85
            }
        };
        if(prefersReducedMotion) config.options.animation = false;


        doughnutChart1 = new Chart($('#chart-1'), config);
        $('#chart-1').addClass('initialized');
    };

    ChartsManager.prototype.initChart2 = function(){
        var config = {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: ref.getEqualPieParts(parseInt(window.totalProject)),
                    backgroundColor: ref.getColorsChart2(parseInt(window.totalProject)),
                    borderWidth: 0
                }]
            },
            options: {
                maintainAspectRatio : false,
                tooltips: {
                    enabled: false
                },
                responsive: true,
                animation: false,
                cutoutPercentage: 85
            }
        };
        if(prefersReducedMotion) config.options.animation = false;


        // And for a doughnut chart
        doughnutChart2 = new Chart($('#chart-2'), config);
        $('#chart-2').addClass('initialized');
    };

    ChartsManager.prototype.initChart3 = function(){
        var config = {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [
                        100
                    ],
                    backgroundColor: [
                        'rgb(25, 0, 139)'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                maintainAspectRatio : false,
                tooltips: {
                    enabled: false
                },
                responsive: true,
                animation: {
                    duration: 1500,
                    easing: 'easeOutCubic',
                    animateScale: false,
                    animateRotate: true
                },
                cutoutPercentage: 85
            }
        };
        if(prefersReducedMotion) config.options.animation = false;

        // And for a doughnut chart
        doughnutChart3 = new Chart($('#chart-3'), config);
        $('#chart-3').addClass('initialized');
    };

    ChartsManager.prototype.onComplete = function($param){
        var id = $param.chart.id;
        var $text = $('.chart-text.t'+id);
        $text.removeClass('gone');
    };

    ChartsManager.prototype.getEqualPieParts = function(count){
        var perc = 100/count;
        var array = [];
        for(var a= 0;a<count;++a){
            array.push(perc);
        }
        return array;
    };

    ChartsManager.prototype.getColorsChart2 = function(count){
        var colorArray = ['rgb(255, 0, 155)','rgb(255, 128, 205)','rgb(255, 51, 175)'];
        var index = 0;
        var array = [];
        for(var a= 0;a<count;++a){
            var color = colorArray[index];
            array.push(color);
            if(index < colorArray.length-1){
                index++;
            } else index = 0;
        }
        return array;
    };


    window.ChartsManager = ChartsManager;

}(window));
