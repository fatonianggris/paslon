<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Favicon icon -->
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url() . $template[0]->logo_favicon; ?>">
        <title><?php echo ucwords($template[0]->judul_website); ?></title>
        <!-- page css -->
        <link href="<?php echo base_url(); ?>main_assets/admin_asset/assets/dist/css/pages/login-register-lock.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="<?php echo base_url(); ?>main_assets/admin_asset/assets/dist/css/style.min.css" rel="stylesheet">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    </head>

    <body class="skin-red card-no-border">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="loader">
                <div class="loader__figure"></div>
                <p class="loader__label"><?php echo $template[0]->judul_website; ?></p>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Main wrapper - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <section id="wrapper">
            <div class="login-register" style="background-image:url(<?php echo base_url(); ?>main_assets/admin_asset/assets/images/background/bg_cover.jpg);">
                <div class="text-center m-b-20">
                    <img width="250px" src="<?php echo base_url() . $template[0]->logo_website; ?>">
                </div>
                <div class="login-box card">
                    <div class="card-body">
                        <form class="form-horizontal form-material" id="loginform" action="<?php echo base_url(); ?>auth/login" method="post">
                            <h3 class="box-title m-b-20">Log In</h3>
                            <?php echo $this->session->flashdata('flash_message'); ?>
                            <div class="form-group ">
                                <div class="col-xs-12">
                                    <input class="form-control" name="email" type="email" required="true" placeholder="Email">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" name="password" type="password" required="true" placeholder="Password"> 
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck1">
                                        <label class="custom-control-label" for="customCheck1">Remember me</label>
                                        <a href="javascript:void(0)" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> Forgot pwd?</a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <div class="col-xs-12 p-b-20">
                                    <button class="btn btn-block btn-lg btn-rounded" style="background:  <?php echo $template[0]->warna_website; ?>" type="submit">Log In</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- ============================================================== -->
        <!-- End Wrapper -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- All Jquery -->
        <!-- ============================================================== -->
        <script src="<?php echo base_url(); ?>main_assets/admin_asset/assets/node_modules/jquery/jquery-3.2.1.min.js"></script>
        <!-- Bootstrap tether Core JavaScript -->
        <script src="<?php echo base_url(); ?>main_assets/admin_asset/assets/node_modules/popper/popper.min.js"></script>
        <script src="<?php echo base_url(); ?>main_assets/admin_asset/assets/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
        <!--Custom JavaScript -->
        <script type="text/javascript">
            $(function () {
                $(".preloader").fadeOut();
            });
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            });
            // ============================================================== 
            // Login and Recover Password 
            // ============================================================== 
            $('#to-recover').on("click", function () {
                $("#loginform").slideUp();
                $("#recoverform").fadeIn();
            });
        </script>
    </body>

</html>