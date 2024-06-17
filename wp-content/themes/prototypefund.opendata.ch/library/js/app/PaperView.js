/**
 * Author: CReich
 * Company: Rainbow Unicorn
 * Date: 07.06.2016
 * Created: 11:44
 **/
(function(window){

    PaperView.prototype.constructor = PaperView;
    PaperView.prototype = {
        initialized: false,
        isDragging: false,
        grey: '#FF1414',
        bg_grey: '#f7f7f7',
        primary: '#006EFA',
        secondary: '#FF1414',
        strokeColor: '#FF1414',
        selectedColor: '#ff3350',
        char_move_ease: 15,
        char_move_offset: 35,
        anim_step_speed: 0.2,
        anim_reset_speed: 0.75,
        p_path_outer : 'M52.6-189.9l43.8,5.6L150-93.5L96.6,2L14,23.3h-52.5V158l53,17.4L13.4,190l-86-1.1l-75.8,1.1l-1.6-14.6l42.8-17.4v-318.5l-42.8-14.8l1.6-14.6L52.6-189.9z',
        p_path_inner : 'M-38.5-4l39,7.8l75.9-50.7l19-40.8l-19-39.2l-71-39.4l-43.8,3.8L-38.5-4z'
    };

    var ref, controller, tools, $canvas, tl_user_p, tl_outer_yellow, tl_inner_yellow, tl_outer_red, tl_inner_red, tl_reset,
        layer_1, path_y_outer, path_y_inner, path_y_outer_segments, path_y_inner_segments, smooth, firstDrag,
        path_user_outer, path_user_inner, path_r_outer, path_r_inner, path_r_outer_segments, path_r_inner_segments,
        groupBatch, groupY, groupR, groupUser, backgroundShape, groupPaths, container, pWrapper, type, containerInitX, containerInitY, speed,
        mousePercX, mousePercY, mouseMoveActive,hitOptions, clicked_segment, pathArrayOuter, pathArrayInner,
        cookieManager, animationSeen, $uploader, $uploaderSpin, $sharer, $exportCanvas, $uploaderBG, freezed,prefersReducedMotion;
    function PaperView(pController){
        ref = this;
        controller = pController;

        hitOptions = {
            segments: true,
            stroke: true,
            fill: true,
            tolerance: 30
        };

        //setup paper to global scope
        paper.install(window);

        //setup paper.js
        paper.setup('paper-canvas');

        mousePercX = mousePercY = 0;

        //cookie
        cookieManager = new CookieManager();

        //debug
        //cookieManager.eraseCookie('ptf-animation-seen');

        animationSeen = cookieManager.readCookie('ptf-animation-seen');
        prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        // prefersReducedMotion = true;
        
        Logger.log("Read cookie: animationSeen, value: " + animationSeen);

    };

    PaperView.prototype.load = function(pPath){

        var SVGoptions = { expandShapes : true ,
            onLoad: function (){
                ref.loadChBatch();
            }};

        if(!pPath) pPath = controller.themePath +  "/library/images/p.svg";

        Logger.log("PaperView, load: " + pPath);

        project.importSVG(pPath , SVGoptions );

    };

    PaperView.prototype.loadChBatch = function(pPath){

        var pPath = controller.themePath +  "/library/images/p-ch.svg";
        var SVGoptions = { expandShapes : true ,
            onLoad: function (item){
                groupBatch = item;
                groupBatch.opacity = 0;
                groupBatch.strokeWidth = 0; 
                ref.init();
            }};

        Logger.log("PaperView, loadChBatch: " + pPath);
        project.importSVG(pPath , SVGoptions );
    };

    PaperView.prototype.init = function(){

        Logger.log("project.activeLayer.children.p -> " + project.activeLayer.children.p);

        var svg = project.activeLayer.children.p;
        var path_outer = svg.children.outer.segments;
        var path_inner = svg.children.inner.segments;

        Logger.log("path_outer.length -> " + path_outer.length);
        Logger.log("path_inner.length -> " + path_inner.length);

        $canvas = $('#paperCanvas');
        $exportCanvas = $('.exportCanvas');
        $uploader = $('.uploader');
        $uploaderBG = $('.uploader-background');
        $uploaderBG.click(function(){
            TweenMax.to($uploader, 0.5, {autoAlpha: 0});
        });

        $uploaderSpin = $('.uploader-spin');
        $sharer = $('.sharer-prompt');

        TweenMax.set($uploader, {autoAlpha: 0});
        TweenMax.set($sharer, {autoAlpha: 0});

        //ref.showSharer();

        layer_1 = new Layer();
        layer_1.name = 'layer_1';
        layer_1.activate();

        if(container) container.removeChildren();

        //blue
        var pathData = ref.p_path_outer;
        path_y_outer = new Path(path_outer);
        path_y_outer.fillColor = ref.primary;

        pathData = ref.p_path_inner;
        path_y_inner = new Path(path_inner);
        path_y_inner.fillColor = ref.bg_grey;

        //grey
        pathData = ref.p_path_outer;
        path_r_outer = new Path(path_outer);
        path_r_outer.fillColor = ref.grey;

        pathData = ref.p_path_inner;
        path_r_inner = new Path(path_inner);
        path_r_inner.fillColor = ref.bg_grey;

        //user red
        pathData = ref.p_path_outer;
        path_user_outer = new Path(path_outer);
        path_user_outer.fillColor = ref.secondary;
        path_user_outer.closed = true;

        pathData = ref.p_path_inner;
        path_user_inner = new Path(path_inner);
        path_user_inner.fillColor = ref.bg_grey;
        path_user_inner.closed = true;

        svg.remove();

        groupBatch.position.x = 45;
        groupBatch.position.y = 155;
        groupBatch.blendMode = 'multiply';

        // BLUE P
        // Create a group from the two paths:
        groupY = new Group([path_y_outer, path_y_inner, groupBatch]);
        groupY.name = 'groupY';
        groupY.nativeX = 0;
        groupY.nativeY = 0;

        groupR = new Group([path_r_outer, path_r_inner]);
        groupR.name = 'groupR';
        groupR.nativeX = 0;
        groupR.nativeY = 0;
        groupR.position.x = groupR.nativeX;
        groupR.position.y = groupR.nativeY;
        groupR.blendMode = 'saturation';
        groupR.opacity = 0;

        groupUser = new Group([path_user_outer, path_user_inner]);
        groupUser.name = 'groupUser';
        groupUser.nativeX = 0;
        groupUser.nativeY = 0;
        groupUser.position.x = groupUser.nativeX;
        groupUser.position.y = groupUser.nativeY;
        groupUser.blendMode = 'multiply';
        groupUser.opacity = 0;

        pWrapper = new Group([groupY, groupR, groupUser]);
        container = new Group([pWrapper]);
        pWrapper.scale(0.5);

        ref.resizeLogoToWindowSize();

        //Logger.log("containerInitX -> " + containerInitX);
        //Logger.log("containerInitY -> " + containerInitY);

        containerInitX = pWrapper.position.x;
        containerInitY = pWrapper.position.y;

        pathArrayOuter = [];
        pathArrayInner = [];

        for(var c=0;c < path_y_outer_segments.length; ++c){
            var path = new Path.Line({
                from: [path_r_outer_segments[c].point.x, path_r_outer_segments[c].point.y],
                to: [path_y_outer_segments[c].point.x, path_y_outer_segments[c].point.y],
                strokeColor:ref.strokeColor
            });
            path.blendMode = 'multiply';
            pathArrayOuter.push(path);
        }
        for(var c=0;c < path_y_inner_segments.length; ++c){
            var path = new Path.Line({
                from: [path_r_inner_segments[c].point.x, path_r_inner_segments[c].point.y],
                to: [path_y_inner_segments[c].point.x, path_y_inner_segments[c].point.y],
                strokeColor: ref.strokeColor
            });
            //path.blendMode = 'multiply';
            pathArrayInner.push(path);
        }

        groupPaths = new Group();
        groupPaths.name = 'groupPaths';
        groupPaths.opacity = 0;
        groupPaths.addChildren(pathArrayOuter);
        groupPaths.addChildren(pathArrayInner);

        pWrapper.insertChild(1,groupPaths);

        //expand outer area to full window size

        if((animationSeen != 'true') && !prefersReducedMotion){
            var area = Math.floor(path_y_outer.segments.length/4);
            var index = 0;
            var block = 0;

            for(var a=0; a< path_y_outer.segments.length; ++a){
                if(index < area){

                    var seg = path_y_outer.segments[a];

                    //Logger.log("a -> " + a + ", index -> " + index + ", block -> " + block);

                    if(block == 0){
                        //top
                        seg.point = new Point(index*(view.bounds.width/area),0);

                        //Logger.log(seg.point + ", top");

                    } else if(block == 1){
                        //right
                        seg.point = new Point(view.bounds.width,index*(view.bounds.height/area));

                        //Logger.log(seg.point + ", right");

                    } else if(block == 2){
                        //bottom
                        seg.point = new Point((area-index)*(view.bounds.width/area),view.bounds.height);

                        //Logger.log(seg.point + ", bottom");

                    } else if(block == 3){
                        //left
                        //Logger.log("left " + a);
                        seg.point = new Point(0,(area-index)*(view.bounds.height/area));


                    } else {
                        //offet
                        //Logger.log("offset " + a);
                        seg.point = new Point(0,(area-index)*(view.bounds.height/area));
                    }


                    index++;
                    if(index==area){
                        block++;
                        index=0;
                    }

                }

            }

            //shrink inner yellow to center
            for(a=0; a< path_y_inner.segments.length; ++a){
                seg = path_y_inner.segments[a];
                seg.point = view.center;
            }

            //shrink inner red to center
            for(a=0; a< path_r_inner.segments.length; ++a){
                seg = path_r_inner.segments[a];
                seg.point = view.center;
            }

            //expand outer red to full window size
            area = Math.floor(path_r_outer.segments.length/4);
            index = 0;
            block = 0;

            for(a=0; a< path_r_outer.segments.length; ++a){
                if(index < area){

                    var seg = path_r_outer.segments[a];

                    //Logger.log("a -> " + a + ", index -> " + index + ", block -> " + block);

                    if(block == 0){
                        //top
                        seg.point = new Point(index*(view.bounds.width/4),0);

                        //Logger.log(seg.point + ", top");

                    } else if(block == 1){
                        //right
                        seg.point = new Point(view.bounds.width,index*(view.bounds.height/4));

                        //Logger.log(seg.point + ", right");

                    } else if(block == 2){
                        //bottom
                        seg.point = new Point((area-index)*(view.bounds.width/4),view.bounds.height);

                        //Logger.log(seg.point + ", bottom");

                    } else if(block == 3){
                        //left
                        //Logger.log("left " + a);
                        seg.point = new Point(0,(area-index)*(view.bounds.height/4));


                    } else {
                        //offet
                        Logger.log("offset " + a);
                    }


                    index++;
                    if(index==area){
                        block++;
                        index=0;
                    }

                }

            }
        }

        //render
        view.onFrame = function(event) {

            if(!freezed && !prefersReducedMotion){
                if(mouseMoveActive){

                    var yellow_endX = (containerInitX + groupY.nativeX) + (mousePercX*ref.char_move_offset);
                    var yellow_endY = (containerInitY + groupY.nativeY) + (mousePercY*ref.char_move_offset);

                    var red_endX = (containerInitX + groupUser.nativeX) + (mousePercX*ref.char_move_offset)*-1;
                    var red_endY = (containerInitY + groupUser.nativeY) + (mousePercY*ref.char_move_offset)*-1;

                    groupY.position.x += (yellow_endX-groupY.position.x)/ref.char_move_ease;
                    groupY.position.y += (yellow_endY-groupY.position.y)/ref.char_move_ease;

                    groupUser.position.x += (red_endX-groupUser.position.x)/ref.char_move_ease;
                    groupUser.position.y += (red_endY-groupUser.position.y)/ref.char_move_ease;

                }


            }

            for(var a=0; a< pathArrayOuter.length; ++a){

                pathArrayOuter[a].segments[0].point.x = path_user_outer.segments[a].point.x;
                pathArrayOuter[a].segments[0].point.y = path_user_outer.segments[a].point.y;

                pathArrayOuter[a].segments[1].point.x = path_y_outer.segments[a].point.x;
                pathArrayOuter[a].segments[1].point.y = path_y_outer.segments[a].point.y;

                if (smooth)
                    pathArrayOuter[a].smooth({ type: 'continuous' });

            }

            for(var a=0; a< pathArrayInner.length; ++a){

                pathArrayInner[a].segments[0].point.x = path_user_inner.segments[a].point.x;
                pathArrayInner[a].segments[0].point.y = path_user_inner.segments[a].point.y;

                pathArrayInner[a].segments[1].point.x = path_y_inner.segments[a].point.x;
                pathArrayInner[a].segments[1].point.y = path_y_inner.segments[a].point.y;

            }


        };

        //need to be added manually
        view.onResize = function(event) {
            ref.onResize();
        };

        speed = 0.2;

        tl_outer_yellow = new TimelineMax({delay:0.25, paused:true, onComplete:ref.onPathYellowOuterComplete});
        for(a=0;a < path_y_outer.segments.length; ++a){
            tl_outer_yellow.add(TweenMax.to(path_y_outer.segments[a].point, ref.anim_step_speed, {x:path_y_outer_segments[a].point.x, y:path_y_outer_segments[a].point.y, ease:Sine.easeOut}),'-=0.1');
        }

        tl_inner_yellow = new TimelineMax({delay:0, paused:true, onComplete:ref.onPathYellowInnerComplete})
        for(a=0;a < path_y_inner.segments.length; ++a){
            if(a==0){
                tl_inner_yellow.add(TweenMax.to(path_y_inner.segments[a].point, ref.anim_step_speed, {delay:0.5, x:path_y_inner_segments[a].point.x, y:path_y_inner_segments[a].point.y, ease:Sine.easeOut}));
            } else tl_inner_yellow.add(TweenMax.to(path_y_inner.segments[a].point, ref.anim_step_speed, {x:path_y_inner_segments[a].point.x, y:path_y_inner_segments[a].point.y, ease:Sine.easeOut},'-=0.1'));
        }

        tl_outer_red = new TimelineMax({delay:0.25, paused:true, onComplete:ref.onPathRedOuterComplete});
        for(a=0;a < path_r_outer.segments.length; ++a){
            tl_outer_red.add(TweenMax.to(path_r_outer.segments[a].point, ref.anim_step_speed, {x:path_r_outer_segments[a].point.x, y:path_r_outer_segments[a].point.y, ease:Sine.easeOut}),'-=0.1');
        }


        tl_inner_red = new TimelineMax({delay:0, paused:true, onComplete:ref.onPathRedInnerComplete})
            .set($canvas,{autoAlpha:0})
            .to($canvas, 0.25, {autoAlpha:1, ease:Sine.easeOut});
        for(a=0;a < path_r_inner.segments.length; ++a){
            if(a==0){
                tl_inner_red.add(TweenMax.to(path_r_inner.segments[a].point, ref.anim_step_speed, {delay:0.5, x:path_r_inner_segments[a].point.x, y:path_r_inner_segments[a].point.y, ease:Sine.easeOut}));
            } else tl_inner_red.add(TweenMax.to(path_r_inner.segments[a].point, ref.anim_step_speed, {x:path_r_inner_segments[a].point.x, y:path_r_inner_segments[a].point.y, ease:Sine.easeOut},'-=0.1'));
        }

        tl_user_p = new TimelineMax({delay:0, paused:true, onComplete:ref.onPathUserComplete})
            .to(groupBatch, 1, {opacity:1, ease:Power1.easeOut},'showBatch')
            .to(groupR.position, 0.3, {x:groupR.position.x, y:groupR.position.y, ease:Power1.easeIn},'fadeOutGrey')
            .to(groupR, .3, {opacity:0, ease:Power1.easeIn},'fadeOutGrey')
            .to(groupUser, 1, {opacity:0.85, ease:Power1.easeOut},'userAni')
            .to(groupUser.position,2, {x:container.position.x-30, y:container.position.y+30, ease:Elastic.easeOut},'userAni')


        if(animationSeen != 'true' && !prefersReducedMotion){
            tl_inner_yellow.play();
            tl_inner_red.play();
        } else {
            //skip
            if(prefersReducedMotion) {
                tl_user_p.progress(1,false);
            } else {
                tl_user_p.play();
            }
        }

    };

    PaperView.prototype.onResize = function(){
        ref.createBackgroundShape();
        ref.resizeLogoToWindowSize();

        pWrapper.position = view.center;

        if(!ref.initialized){
            TweenMax.killAll();
            ref.load();
        }
    };

    PaperView.prototype.resizeLogoToWindowSize = function(){
        Logger.log("resizeLogoToWindowSize");

        var wW = view.bounds.width;
        var wH = view.bounds.height;


        //less that 481
        var targetH = wH*0.5;
        ref.char_move_offset = 15;

        if(controller.viewport().width >= 481 && controller.viewport().width < 768){

            targetH = wH*0.55;

        } else if(controller.viewport().width >= 768 && controller.viewport().width < 1030){

            targetH = wH*0.65;
            ref.char_move_offset = 15;

        } else if(controller.viewport().width >= 1030){

            targetH = wH*0.7;
            ref.char_move_offset = 35;

        }

        var scale;

        Logger.log("wW -> " + wW + " wH -> " + wH);

        if(wW > wH){
            //landscape
            scale = (targetH/pWrapper.bounds.height)*0.8;

        } else {
            //portrait
            var targetW = wW*0.5;
            scale = targetW/pWrapper.bounds.width;
        }

        groupR.scale(scale);
        groupUser.scale(scale);
        groupY.scale(scale);

        Logger.log("New logo scale -> " + scale);

        pWrapper.position = view.center;

        ref.calculateCoordinates();

        containerInitX = pWrapper.position.x;
        containerInitY = pWrapper.position.y;


    };

    PaperView.prototype.calculateCoordinates = function(){

        //clone segments outer
        path_y_outer_segments = [];
        for(var a=0; a< path_y_outer.segments.length; ++a){
            var s = new Segment();
            s.point = new Point(path_y_outer.segments[a].point.x,path_y_outer.segments[a].point.y)
            s.handleIn = new Point(path_y_outer.segments[a].handleIn.x,path_y_outer.segments[a].handleIn.y)
            path_y_outer_segments.push(s);
        }

        //clone segments inner
        path_y_inner_segments = [];
        for(a=0; a< path_y_inner.segments.length; ++a){
            s = new Segment();
            s.point = new Point(path_y_inner.segments[a].point.x,path_y_inner.segments[a].point.y)
            s.handleIn = new Point(path_y_inner.segments[a].handleIn.x,path_y_inner.segments[a].handleIn.y)
            path_y_inner_segments.push(s);
        }

        //clone segments outer
        path_r_outer_segments = [];
        for(a=0; a< path_r_outer.segments.length; ++a){
            s = new Segment();
            s.point = new Point(path_r_outer.segments[a].point.x,path_r_outer.segments[a].point.y)
            s.handleIn = new Point(path_r_outer.segments[a].handleIn.x,path_r_outer.segments[a].handleIn.y)
            path_r_outer_segments.push(s);
        }

        //clone segments inner
        path_r_inner_segments = [];
        for(a=0; a< path_r_inner.segments.length; ++a){
            s = new Segment();
            s.point = new Point(path_r_inner.segments[a].point.x,path_r_inner.segments[a].point.y)
            s.handleIn = new Point(path_r_inner.segments[a].handleIn.x,path_r_inner.segments[a].handleIn.y)
            path_r_inner_segments.push(s);
        }

        /*
        Logger.log("path_y_outer_segments -> " + path_y_outer_segments.length);
        Logger.log("path_y_inner_segments -> " + path_y_inner_segments.length);
        Logger.log("path_r_outer_segments -> " + path_r_outer_segments.length);
        Logger.log("path_r_inner_segments -> " + path_r_inner_segments.length);
        */

    };

    PaperView.prototype.onPathYellowOuterComplete = function(){
        //Logger.log("onPathYellowOuterComplete");
        tl_user_p.play();
    };

    PaperView.prototype.onPathUserComplete = function(){
        //Logger.log("onPathUserComplete");
        groupR.remove();

        ref.createBackgroundShape();

        cookieManager.createCookie('ptf-animation-seen','true', 3650);

        ref.initialized = true;

        setTimeout(function(){
            ref.createMouseEventListeners();
        }, 300);


    };

    PaperView.prototype.createBackgroundShape = function(){

        //return;
        if(backgroundShape) backgroundShape.remove();
        backgroundShape = new Shape.Rectangle(new Point(0, 0),
            new Size(view.bounds.width, view.bounds.height));
        backgroundShape.fillColor = ref.bg_grey;
        container.insertChild(0,backgroundShape);
    };

    PaperView.prototype.onPathYellowInnerComplete = function(){
        //Logger.log("onPathYellowInnerComplete");

    };

    PaperView.prototype.onPathRedOuterComplete = function(){
        //Logger.log("onPathRedOuterComplete");
    };

    PaperView.prototype.onPathRedInnerComplete = function(){
        //Logger.log("onPathRedInnerComplete");
        tl_outer_red.play();
        tl_outer_yellow.play();
    };

    PaperView.prototype.onMouseDrag = function(event){
        if (clicked_segment) {

            //Logger.log("clicked_segment.point -> " + clicked_segment.point + ", event.delta -> " + event.delta);

            clicked_segment.point.x += event.delta.x;
            clicked_segment.point.y += event.delta.y;
        }
    };

    PaperView.prototype.createMouseEventListeners = function(){
        //Logger.log("createMouseEventListeners");

        //we select red P on startup
        groupUser.fullySelected = true;
        groupUser.selectedColor = ref.selectedColor;

        if(controller.deviceType == 'computer') {
            //add mouse events for Red P
            view.onMouseDown = function(event){
                clicked_segment = null;
                var hitResult = groupUser.hitTest(event.point, hitOptions);
                //Logger.log("hitResul Red -> " + hitResult);
                //if (!hitResult) return;
                if(hitResult){
                    if (hitResult.type == 'segment') {
                        ref.isDragging = true;
                        Logger.log("Start Dragging");
                        clicked_segment = hitResult.segment;
                    }
                } else {
                    if(!freezed){
                        freezed = true;
                    } else {
                        freezed = false;
                    }
                }


            };

            container.onMouseDrag = ref.onMouseDrag;

        }

        if(controller.deviceType == 'computer') {
            view.onMouseUp = function(event){

                if(ref.isDragging){
                    setTimeout(function(){
                        ref.isDragging = false;
                        Logger.log("Stop Dragging");

                        if(!firstDrag){
                            controller.showCanvasNav();
                            firstDrag = true;
                        }

                    }, 100);

                }

            }

        }


        view.onMouseMove = function(event) {

            var x = event.point.x;
            var y = event.point.y;

            var centerX = view.center.x;
            var centerY = view.center.y;

            var diffX = centerX - x;
            var diffY = centerY - y;

            mousePercX = diffX/view.center.x;
            mousePercY = diffY/view.center.y;

            //Logger.log("mousePercX -> " + mousePercX + ", mousePercX -> " + mousePercX );

        };

        mouseMoveActive = true;

    };

    PaperView.prototype.resetToDefault = function(){

        mouseMoveActive = false;
        for(var a=0; a<path_user_outer.segments.length;++a){
            TweenMax.to(path_user_outer.segments[a].point, ref.anim_reset_speed, {x:path_r_outer_segments[a].point.x, y:path_r_outer_segments[a].point.y, ease:Elastic.easeOut})
        }
        for(a=0; a<path_user_inner.segments.length;++a){
            TweenMax.to(path_user_inner.segments[a].point, ref.anim_reset_speed, {x:path_r_inner_segments[a].point.x, y:path_r_inner_segments[a].point.y, ease:Elastic.easeOut})
        }

        TweenMax.to(groupR.position, ref.anim_reset_speed, {x:view.center.x+containerInitX, y:view.center.y+containerInitY, ease:Sine.easeOut, onComplete: ref.onResetComplete});

    };

    PaperView.prototype.onResetComplete = function(){
        mouseMoveActive = true;
    };

    PaperView.prototype.exportCanvas = function(){


        if(backgroundShape){
            backgroundShape.remove();
            backgroundShape = null;
        }

        TweenMax.set($uploaderSpin, {autoAlpha: 1});
        TweenMax.set($sharer, {autoAlpha: 0});
        TweenMax.to($uploader, 0.5, {autoAlpha: 1});

        setTimeout(function(){
            if(groupBatch){
                groupBatch.remove();
                groupBatch = null;
            }

            //create SVG
            var svg = paper.project.exportSVG({ asString: true });
            // SVG cleanup
            $svg = $(svg);

            var pathY_1 = $svg.find('#groupY path:first-of-type ').attr('d');
            var pathY_2 = $svg.find('#groupY path:last-of-type ').attr('d');

            $svg.find('#groupY path:first-of-type ').attr('d',pathY_1 + ' ' + pathY_2);
            $svg.find('#groupY path:last-of-type ').remove();

            var pathU_1 = $svg.find('#groupUser path:first-of-type ').attr('d');
            var pathU_2 = $svg.find('#groupUser path:last-of-type ').attr('d');

            $svg.find('#groupUser path:first-of-type ').attr('d',pathU_1 + ' ' + pathU_2);
            $svg.find('#groupUser path:last-of-type ').remove();

            svg = $svg[0].outerHTML;

            // calculating the viewBox
            // min-x min-y width heigth
            var containerWidth = Math.ceil(container.bounds.width);
            var containerHeight = Math.ceil(container.bounds.height);
            var containerX = Math.floor(container.position.x - (containerWidth/2));
            var containerY = Math.floor(container.position.y - (containerHeight/2));
            var viewBoxCords = containerX  + ' ' + containerY + ' ' + containerWidth + ' ' + containerHeight;
            var blendStyle = '<style type="text/css">#groupUser{mix-blend-mode: multiply;}</style>';

            svg = '<svg width="' + containerWidth + '" height="' + containerHeight +'" viewBox="' + viewBoxCords + '" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">' + blendStyle + svg + '</svg>';

            var data = {
                svg: ref.b64EncodeUnicode(svg)
            };

            ref.createBackgroundShape();

            data = JSON.stringify(data);

            Logger.log("data -> " + data);

            $.ajax({
                type: 'POST',
                url: controller.siteURL + '/wp-json/ptf/v1/create-submission',
                data: data,
                dataType: 'json',
                contentType: "application/json",
                success: function(data)
                {

                    //recreate background
                    Logger.log("status -> " + data.status + ", url -> " + data.url);
                    if(data.status == 'success'){
                        //all good
                        controller.setUserCanvasURL(data.url);
                        $('.user-canvas').attr('src',data.filename);
                        ref.showSharer();

                    } else {
                        //error uploading file
                        TweenMax.to($uploader, 0.5, {autoAlpha: 0});
                    }

                    TweenMax.to($exportCanvas, 0.5, {autoAlpha: 0, onComplete:ref.hideUploadButton});


                },
                error: function (request, status, error) {

                    Logger.log("error.");
                    Logger.log("request: " + request);
                    Logger.log("status: " + status);
                    Logger.log("error: " + error);

                }
            });

        }, 500);






    };

    PaperView.prototype.showSharer = function(){
        TweenMax.set($uploader, {autoAlpha: 1});
        var sharerTl = new TimelineMax({delay:0, paused:false})
            .to($uploaderSpin, 0.5, {autoAlpha: 0})
            .to($sharer, 0.5, {autoAlpha: 1});
    };

    PaperView.prototype.hideSharer = function(){
        var sharerTl = new TimelineMax({delay:0, paused:false})
            .to($sharer, 0.25, {autoAlpha: 0})
            .to($uploader, 0.5, {autoAlpha: 0});
    };

    PaperView.prototype.hideUploadButton = function(){
        $exportCanvas.remove();
    };

    PaperView.prototype.downloadDataUri = function(options){
        if (!options.url)
            options.url = "http://download-data-uri.appspot.com/";
        $('<form method="post" action="' + options.url
        + '" style="display:none"><input type="hidden" name="filename" value="'
        + options.filename + '"/><input type="hidden" name="data" value="'
        + options.data + '"/></form>').appendTo('body').submit().remove();
    };

    PaperView.prototype.b64EncodeUnicode = function(str){
        return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g, function(match, p1) {
            return String.fromCharCode('0x' + p1);
        }));
    };


    window.PaperView = PaperView;

}(window));
