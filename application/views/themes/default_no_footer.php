<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="all, index, follow"/>
        <meta name="googlebot" content="all, index, follow" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/themes/default/css/normalize.css">
        <!-- JQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <!--Bootstrap-->
        <link href="<?php echo base_url(); ?>assets/themes/default/css/bootstrap.css" rel="stylesheet" type="text/css" />
        <?php require 'head.php'; ?>
        <link href="<?php echo base_url(); ?>assets/themes/default/css/layerslider.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/themes/default/css/layerslider.transitiongallery.css" rel="stylesheet" type="text/css" />

        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"> 

        <!--Custom styling-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/themes/default/css/main.css">
        <script src="<?php echo base_url(); ?>assets/themes/default/js/login.js"></script>
    </head>
    <body>
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-fixed-top">
            <a class="navbar-brand page-scroll" style="margin-left: 20px;" href="<?php echo base_url(); ?>#page-top">
                <img src="<?php echo base_url(); ?>assets/themes/default/images/logo200x67.png" alt="Robios" height="30">
            </a>
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header page-scroll">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="hidden">
                            <a href="#page-top"></a>
                        </li>
                        <li>
                            <a class="page-scroll" class="active" href="<?php echo base_url(); ?>#intro">About</a>
                        </li>
                        <li>
                            <a class="page-scroll" href="<?php echo base_url(); ?>#pricing">Pricing</a>
                        </li>
                        <li>
                            <a class="page-scroll" href="<?php echo base_url(); ?>#services">Why Us</a>
                        </li>
                        <li>
                            <a class="page-scroll" href="<?php echo base_url(); ?>#contact">Contact</a>
                        </li>
                        <?php if ($this->session->userdata('is_logged_in')): ?> 
                            <li>
                                <a href="<?php echo base_url(); ?>dashboard">Dashboard</a>
                            </li>
                            <?php if ($this->session->userdata('user_role') === "Super Admin"): ?>   
                                <li>
                                    <a class="page-scroll" href="<?php echo base_url(); ?>admin">Admin</a>
                                </li>
                            <?php endif; ?>
                            <li>
                                <a href="<?php echo site_url('auth/logout'); ?>">Sign out</a>
                            </li>
                        <?php else: ?>
                            <li>
                                <a href="#" data-toggle="modal"
                                   data-target="#loginModal">Sign In</a>
                            </li>

                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
        <?php echo $output; ?>
        <div class="modal fade" id="enquiryModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
            <div class="modal-dialog">
                <div id="enquiry-content" class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="enquiry-title"></h4>
                    </div>
                    <form id="frm-enquiry" action="<?php echo base_url() ?>site/ajax_send_enquiry" method="POST">
                        <div class="modal-body">
                            <div id="login-fail-errormsg" class="alert alert-danger hidden" role="alert">Incorrect username and/or password. Please try again.</div>
                            <p id="enquiry-blurb">Thanks for your interest! Please leave your email and an optional message to kick things off and we will be in touch shortly.</p>
                            <div class="form-group">
                                <label for="enquiry-name">Name</label>
                                <input class="form-control" type="enquiry-name" name="enquiry-name" placeholder="Please enter your name" required/>    
                            </div>
                            <div class="form-group">
                                <label for="enquiry-email">Email</label>
                                <input class="form-control" type="email" name="enquiry-email" placeholder="Please enter your email" required/>    
                            </div>
                            <div class="form-group">
                                <label for="enquiry-message">Message</label>
                                <textarea id="enquiry-message" class="form-control" name="enquiry-message" rows="8" placeholder="Please add a message here to introduce your requirements"></textarea>
                            </div>
                            <input id="enquiry-type" type="hidden" name="enquiry-type"/>    
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit"  class="btn btn-primary">Send Enquiry</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-sign-in"></i> Sign In</h4>
                    </div>
                    <form id="frm-login" action="<?php echo base_url() ?>auth/validate" method="POST">
                        <div class="modal-body">

                            <div id="login-fail-errmsg" class="alert alert-danger hidden" role="alert">Incorrect username and/or password. Please try again.</div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email-tb" class="form-control" type="email" name="email" required/>    
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input id="password-tb" class="form-control" name="password" type="password" required/>
                            </div>
                            <?php echo "Don't have an account? " . anchor('auth/signup', "Create an account."); ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit"  class="btn btn-primary">Sign In</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function ($) {
                if (window.location.href.indexOf("#") === -1) {
                    setTimeout(function () {
 //                        $("#main-content").animate({top: $("#layerslider_29").height()}, 800);
                        $("#main-content").animate({top: 715}, 800);
                    }, 1000);
                } else {
                    $("#main-content").css({top: $("#main-img").height() + 45});
                }
                var lsjQuery = jQuery;
                var curSkin = 'v5';
                lsjQuery(document).ready(function () {
                    if (typeof lsjQuery.fn.layerSlider == "undefined") {
                        lsShowNotice('layerslider_29', 'jquery');
                    } else {
                        lsjQuery("#layerslider_29").layerSlider({startInViewport: false, pauseOnHover: false, forceLoopNum: false, autoPlayVideos: false, skinsPath: 'http://kreaturamedia.com/wp-content/plugins/LayerSlider/static/skins/', skin: 'v5', thumbnailNavigation: 'hover'})
                    }
                });
                var controller = new ScrollMagic();

                //SCROLLMAGIC PINNING//
                // build scene
                var scene1 = new ScrollScene({triggerElement: ".arrow-right", duration: 650})
                        .setPin(".arrow-right")
                        .addTo(controller);
                var scene2 = new ScrollScene({triggerElement: ".arrow-left", duration: 650})
                        .setPin(".arrow-left")
                        .addTo(controller);

                //SCROLLMAGIC IMAGE SEQUENCE//
                // define images
                var images = [
                    "<?php echo base_url(); ?>assets/themes/default/images/lollipop-57.PNG",
                    "<?php echo base_url(); ?>assets/themes/default/images/lollipop-58.PNG",
                    "<?php echo base_url(); ?>assets/themes/default/images/lollipop-59.PNG",
                    "<?php echo base_url(); ?>assets/themes/default/images/lollipop-100.PNG",
                    "<?php echo base_url(); ?>assets/themes/default/images/lollipop-101.PNG",
                    "<?php echo base_url(); ?>assets/themes/default/images/lollipop-102.PNG",
                    "<?php echo base_url(); ?>assets/themes/default/images/lollipop-103.PNG",
                    "<?php echo base_url(); ?>assets/themes/default/images/lollipop-104.PNG",
                    "<?php echo base_url(); ?>assets/themes/default/images/lollipop-105.PNG",
                    "<?php echo base_url(); ?>assets/themes/default/images/lollipop-106.PNG",
                    "<?php echo base_url(); ?>assets/themes/default/images/lollipop-107.PNG",
                    "<?php echo base_url(); ?>assets/themes/default/images/lollipop-108.PNG",
                ];
                // TweenMax can tween any property of any object. We use this object to cycle through the array
                var obj = {curImg: 0};
                // create tween
                var tween = TweenMax.to(obj, 0.5,
                        {
                            curImg: images.length - 1, // animate propery curImg to number of images
                            roundProps: "curImg", // only integers so it can be used as an array index
                            //repeat: 1, // repeat 3 times
                            immediateRender: true, // load first image automatically
                            ease: Linear.easeNone, // show every image the same ammount of time
                            onUpdate: function () {
                                $("#lollipop-img").attr("src", images[obj.curImg]); // set the image source
                            }
                        }
                );
                // build scene
                var scene = new ScrollScene({triggerElement: "#lollipop-img", duration: 500})
                        .setTween(tween)
                        .addTo(controller);
                // handle form change
                $("form.move input[name=duration]:radio").change(function () {
                    scene.duration($(this).val());
                });
            });</script>
    </body>
</html>