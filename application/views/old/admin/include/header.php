<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Steps :: Admin :: CMS </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url() ?>assets/admin/images/icon/favicon.ico">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/themify-icons.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/metisMenu.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/slicknav.min.css">
    <!-- Start datatable css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
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
    <!-- page container area start -->
    <div class="page-container">

        <!-- sidebar menu area start -->
        <div class="sidebar-menu">
            <div class="sidebar-header">
                <div class="logo">
                    <!-- <a href="index.html"><img src="<?php echo base_url() ?>assets/admin/images/icon/logo.png" alt="logo"></a> -->
                    <p style="color: #fff;font-size: 43px;font-weight: 900;margin-top: 10px;"><i>Steps</i></p>
                </div>
            </div>
            <div class="main-menu">
                <div class="menu-inner">
                    <nav>
                        <ul class="metismenu" id="menu">
                            <li class=" <?php if( $this->uri->segment(2)=="dashboard" || $this->uri->segment(2)=="" ){echo 'active';} ?>">
                                <a href="<?php echo base_url('admin/dashboard'); ?>" aria-expanded="true"><i class="ti-dashboard"></i><span>Dashboard</span></a>
                            </li>
                            <li  class=" <?php if($this->uri->segment(2)=="info"){echo 'active';} ?>">
                                <a href="<?php echo base_url('admin/info'); ?>" aria-expanded="true"><i class="ti-info"></i><span>Info</span></a>
                            </li>
                            <li class=" <?php if($this->uri->segment(2)=="location"){echo 'active';} ?>">
                                <a href="<?php echo base_url('admin/location'); ?>" aria-expanded="true"><i class="ti-user"></i><span>Location</span></a>
                            </li>
                           
                            <li class=" <?php if($this->uri->segment(2)=="config"){echo 'active';} ?>">
                                <a href="<?php echo base_url('admin/config'); ?>" aria-expanded="true"><i class="ti-settings"></i><span>Config</span></a>
                            </li>
                             <li class=" <?php if($this->uri->segment(2)=="user"){echo 'active';} ?>">
                                <a href="<?php echo base_url('admin/user'); ?>" aria-expanded="true"><i class="ti-user"></i><span>Users</span></a>
                            </li>
                            <li class="">
                                <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-table"></i><span>Report</span></a>
                            </li>
                            
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- sidebar menu area end -->