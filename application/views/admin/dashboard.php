
            <div class="main-content-inner">
                 <div class="sales-report-area mt-5 mb-5">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="single-report mb-xs-30">
                                <div class="s-report-inner pr--20 pt--30 mb-3">
                                    <div class="icon"><i class="fa fa-user"></i></div>
                                    <div class="s-report-title d-flex justify-content-between">
                                        <h4 class="header-title mb-0">Total Users</h4>
                                    </div>
                                    <?php $totaluser = $this->db->get('tbl_user')->result(); ?>
                                    <div class="d-flex justify-content-between pb-2">
                                        <h2><?php echo count($totaluser); ?></h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="single-report mb-xs-30">
                                <div class="s-report-inner pr--20 pt--30 mb-3">
                                    <div class="icon"><i class="fa fa-clock-o"></i></div>
                                    <div class="s-report-title d-flex justify-content-between">
                                        <h4 class="header-title mb-0">Total Time ( Minutes )</h4>
                                    </div>
                                    <?php
                                    $totalArray                         =       getTotalTimeArray();
                                    $total_time                         =       getTotalTime( $totalArray );
                                    $total_TimeMinit                    =       gettotalTimeMinit($total_time);
                                    $oneSurgerieTime                    =       getTimeFromSurgerie();
                                    $totalSurgeries                     =       gettotalSurgeries($oneSurgerieTime,$total_TimeMinit);
                                    ?>
                                    <div class="d-flex justify-content-between pb-2">
                                        <h2><?php echo $total_TimeMinit; ?> ( Minutes )</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="single-report">
                                <div class="s-report-inner pr--20 pt--30 mb-3">
                                    <div class="icon"><i class="fa fa-heartbeat"></i></div>
                                    <div class="s-report-title d-flex justify-content-between">
                                        <h4 class="header-title mb-0">Total Surgery</h4>
                                    </div>
                                    <div class="d-flex justify-content-between pb-2">
                                        <h2><?php echo $totalSurgeries; ?></h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- overview area start -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="header-title mb-0">Overview</h4>
                                </div>
                                <!-- <div id="verview-shart"></div> -->
                                <canvas id="canvas_new"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
               <!--  <div class="row">
                    <div class="col-xl-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="header-title mb-0">Overview</h4>
                                </div>
                                <div id="verview-shart"></div>
                            </div>
                        </div>
                    </div>
                </div> -->
                <!-- overview area end -->
               
            </div>
        </div>
        <!-- main content area end -->
        <!-- footer area start-->
       