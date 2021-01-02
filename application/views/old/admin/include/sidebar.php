
        <!-- main content area start -->
        <div class="main-content">
            <!-- header area start -->
            <div class="header-area">
                <div class="row align-items-center">
                    <!-- nav and search button -->
                    <div class="col-md-6 col-sm-8 clearfix">
                        <div class="nav-btn pull-left">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="search-box pull-left">
                            <!-- <form action="#">
                                <input type="text" name="search" placeholder="Search..." required>
                                <i class="ti-search"></i>
                            </form> -->
                        </div>
                    </div>
                    <!-- profile info & task notification -->
                    <div class="col-sm-6 clearfix">
                        <div class="user-profile pull-right">
                            <?php
                            $is_logged_in = $this->session->userdata('is_logged_in')
                            ?>
                            <img class="avatar user-thumb" src="<?php echo base_url() ?>assets/admin/images/author/avatar.png" alt="avatar">
                            <h4 class="user-name dropdown-toggle" data-toggle="dropdown"><?php echo $is_logged_in->fld_username; ?> <i class="fa fa-angle-down"></i></h4>
                            <div class="dropdown-menu">
                                <!-- <a class="dropdown-item" href="#">Message</a>
                                <a class="dropdown-item" href="#">Settings</a> -->
                                <a class="dropdown-item" href="<?php echo base_url('admin/login/logout'); ?>">Log Out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- header area end -->
            <!-- page title area start -->
            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="breadcrumbs-area clearfix" style="    padding: 15px;">
                            <h4 class="page-title pull-left"><?php echo  $pageName; ?></h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="<?php echo $pageSlug_one_url; ?>"><?php echo $pageSlug_one ?></a></li>
                                <li>
                                    <?php if( $pageSlug_three !='' ) {
                                        ?>
                                        <a href="<?php echo $pageSlug_two_url; ?>"><?php echo $pageSlug_two ?></a>
                                        <?php 
                                    }else{ ?>
                                    <span><?php echo $pageSlug_two ?></span>
                                    <?php } ?>
                                    <?php if( $pageSlug_three !='' ) {
                                        ?>
                                        <li> <span><?php echo $pageSlug_three ?></span></li>
                                        <?php 
                                    }?>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6 clearfix">
                        <!-- <div class="user-profile pull-right">
                            <img class="avatar user-thumb" src="<?php echo base_url() ?>assets/admin/images/author/avatar.png" alt="avatar">
                            <h4 class="user-name dropdown-toggle" data-toggle="dropdown">Kumkum Rai <i class="fa fa-angle-down"></i></h4>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#">Message</a>
                                <a class="dropdown-item" href="#">Settings</a>
                                <a class="dropdown-item" href="#">Log Out</a>
                            </div>
                        </div> -->
                    </div>
                </div>
                <?php
                if( @$this->session->userdata('success-msg') != "" ) {
                    ?>
                    <br>
                    <div class="alert alert-success">
                      <strong>Success!</strong> <?php echo @$this->session->userdata('success-msg');  ?>
                    </div> <?php echo @$this->session->set_userdata('success-msg','');  ?>
                    <?php 
                }
                if( @$this->session->userdata('error-msg') != "" ) {
                    ?>
                    <div class="alert alert-success">
                      <strong>Error!</strong> <?php echo @$this->session->userdata('error-msg');  ?>
                    </div><?php echo @$this->session->set_userdata('error-msg','');  ?>
                    <?php 
                }
                ?>
            </div>
            <!-- page title area end -->