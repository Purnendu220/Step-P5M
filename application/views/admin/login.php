<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Login - srtdash</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url() ?>assets/admin/images/icon/favicon.ico">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/themify-icons.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/metisMenu.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/slicknav.min.css">
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- others css -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/typography.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/default-css.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/styles.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/responsive.css">
    <!-- modernizr css -->
    <script src="<?php echo base_url() ?>assets/admin/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->
    <!-- login area start -->
    <div class="login-area">
        <div class="container">
            <div class="login-box ptb--100">
                 <form id="login-form" method="post">
                    <div class="login-form-head">
                        <h4>Sign In</h4>
                        <p>Hello there, Sign in and start managing your Admin Template</p>
                    </div>
                    <div class="alert alert-danger loginError" style="display: none;">
                      <strong>Error ! </strong> Invalid email ID and Password
                    </div>
                    <div class="login-form-body">
                        <div class="form-gp">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" id="email" name="email" required>
                            <i class="ti-email"></i>
                        </div>
                        <div class="form-gp">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" id="password" name="password" required=>
                            <i class="ti-lock"></i>
                        </div>
                        <!-- <div class="row mb-4 rmber-area">
                            <div class="col-6">
                                <div class="custom-control custom-checkbox mr-sm-2">
                                    <input type="checkbox" class="custom-control-input" id="customControlAutosizing">
                                    <label class="custom-control-label" for="customControlAutosizing">Remember Me</label>
                                </div>
                            </div>
                            <div class="col-6 text-right">
                                <a href="#">Forgot Password?</a>
                            </div>
                        </div> -->
                        <div class="submit-btn-area">
                            <button id="form_submit" type="submit">Submit <i class="ti-arrow-right"></i></button>
                            <div class="login-other row mt-4">
                              <!--   <div class="col-6">
                                    <a class="fb-login" href="#">Log in with <i class="fa fa-facebook"></i></a>
                                </div>
                                <div class="col-6">
                                    <a class="google-login" href="#">Log in with <i class="fa fa-google"></i></a>
                                </div> -->
                            </div>
                        </div>
                        <div class="form-footer text-center mt-5">
                          <!--   <p class="text-muted">Don't have an account? <a href="register.html">Sign up</a></p> -->
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- login area end -->

    <!-- jquery latest version -->
    <script src="<?php echo base_url() ?>assets/admin/js/vendor/jquery-2.2.4.min.js"></script>
    <!-- bootstrap 4 js -->
    <script src="<?php echo base_url() ?>assets/admin/js/popper.min.js"></script>
    <script src="<?php echo base_url() ?>assets/admin/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>assets/admin/js/owl.carousel.min.js"></script>
    <script src="<?php echo base_url() ?>assets/admin/js/metisMenu.min.js"></script>
    <script src="<?php echo base_url() ?>assets/admin/js/jquery.slimscroll.min.js"></script>
    <script src="<?php echo base_url() ?>assets/admin/js/jquery.slicknav.min.js"></script>
    
    <!-- others plugins -->
    <script src="<?php echo base_url() ?>assets/admin/js/plugins.js"></script>
    <script src="<?php echo base_url() ?>assets/admin/js/scripts.js"></script>
</body>

</html>
<script type="text/javascript">
    $('document').ready(function(){
        var base_url = '<?php echo base_url(); ?>';
        $('#login-form').submit(function(event){            
            event.preventDefault();
            $('.loginError').hide();
            if( $('#email').val() != '' && $('#password').val() != '' ){        
                $.ajax({
                        type: "POST",
                        url: base_url+"admin/login/checkLogin", 
                        data: $( this ).serialize(),
                        dataType: "text",  
                        cache:false,
                        success: 
                            function(data)
                            {                                
                                if(data.trim()=="true"){
                                    $('#login-form .alert-error').hide();
                                    window.location.assign(base_url+"admin/dashboard");
                                }else{                                    
                                    $('.loginError').show();
                                    $('body #login-form .alert-error').show();
                                }
                            }
                });
            } 
        });
    });
</script>