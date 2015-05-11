<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/themes/default/css/normalize.css">

        <meta name="robots" content="noindex">
        
        <!-- JQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

        <!--Bootstrap-->
        <link href="<?php echo base_url(); ?>assets/themes/default/css/bootstrap.css" rel="stylesheet" type="text/css" />

        <?php require 'head.php'; ?>

        <script src="<?php echo base_url(); ?>assets/themes/default/js/login.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"> 

        <!--Custom styling-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/themes/default/css/main.css">
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/themes/default/js/tinymce/tinymce.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/themes/default/js/tinymce/placeholder/plugin.js"></script>
        <script type="text/javascript">
            tinymce.init({
                selector: "textarea",
                plugins: [
                    "placeholder"
                ],
                toolbar: "bold italic"

            });</script>




    </head>
    <body>

        <!-- Navigation -->

        <nav class="navbar navbar-default navbar-fixed-top">
            <a class="navbar-brand page-scroll" style="margin-left: 20px;" href="<?php echo base_url(); ?>#page-top">
                <!--            <div style="position:fixed; z-index: 5000; margin:-5px;">-->
                <img src="<?php echo base_url(); ?>assets/themes/default/images/logo200x67.png" alt="Robios" height="30">
                <!--            </div>-->
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
                            <a class="page-scroll" href="<?php echo base_url(); ?>#intro">About</a>
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
        <?php require APPPATH.'views/partials/footer.php';  ?> ?>

        <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-sign-in"></i> Sign In</h4>
                    </div>

                    <form id="frm-login" action="<?php echo base_url() ?>auth/validate" method="POST">
                        <div class="modal-body">

                            <div id="login-fail-errormsg" class="alert alert-danger hidden" role="alert">Incorrect username and/or password. Please try again.</div>
                            <div id="email-exists-errormsg" class="alert alert-danger hidden" role="alert">This email already exists.</div>
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
    </body>
</html>