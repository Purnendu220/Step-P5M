 <footer>
            <div class="footer-area">
                <p>© Copyright <?php echo date('Y'); ?>. All right reserved. Template by <a href="https://www.emstell.com/" target='_blank' >Emstell</a>.</p>
            </div>
        </footer>
        <!-- footer area end-->
    </div>
    <!-- page container area end -->
    
    <!-- jquery latest version -->
    <script src="<?php echo base_url() ?>assets/admin/js/vendor/jquery-2.2.4.min.js"></script>
    <!-- bootstrap 4 js -->
    <script src="<?php echo base_url() ?>assets/admin/js/popper.min.js"></script>
    <script src="<?php echo base_url() ?>assets/admin/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>assets/admin/js/owl.carousel.min.js"></script>
    <script src="<?php echo base_url() ?>assets/admin/js/metisMenu.min.js"></script>
    <script src="<?php echo base_url() ?>assets/admin/js/jquery.slimscroll.min.js"></script>
    <script src="<?php echo base_url() ?>assets/admin/js/jquery.slicknav.min.js"></script>
    <!-- Start datatable js -->
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
    <!-- start chart js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    <!-- start highcharts js -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <!-- start zingchart js -->
    <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
    <script>
    zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
    ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9", "ee6b7db5b51705a13dc2339db3edaf6d"];
    </script>
    <!-- all line chart activation -->
    <script src="<?php echo base_url() ?>assets/admin/js/line-chart.js"></script>
    <!-- all pie chart -->
    <script src="<?php echo base_url() ?>assets/admin/js/pie-chart.js"></script>
    <!-- others plugins -->
    <script src="<?php echo base_url() ?>assets/admin/js/plugins.js"></script>
    <script src="<?php echo base_url() ?>assets/admin/js/scripts.js"></script>

</body>

</html>
<script type="text/javascript">
    $(".data-trash").click(function(){
        var id  = $(this).data('id');
        var url = $(this).data('url');
        url = url+id;
        if( confirm("Are you sure you want to delete this data !") ){
            window.location = url;
        }
    });
</script>