    <!-- footer content -->
    <footer>
      <div class="pull-right">

      </div>
      <div class="clearfix"></div>
    </footer>
    <!-- /footer content -->

    </div>

    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>assets/template/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo base_url(); ?>assets/template/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url(); ?>assets/template/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?php echo base_url(); ?>assets/template/nprogress/nprogress.js"></script>

    <!-- DataTables-->
    <script src="<?php echo base_url(); ?>assets/template/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/template/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <!-- Data Tables export -->
    <script src="<?php echo base_url(); ?>assets/template/datatables-export/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/template/datatables-export/js/buttons.flash.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/template/datatables-export/js/buttons.html5.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/template/datatables-export/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/template/datatables-export/js/jszip.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/template/datatables-export/js/vfs_fonts.js"></script>
    <script src="<?php echo base_url(); ?>assets/template/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/template/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>

    <!-- Sweet Alert -->
    <script src="<?php echo base_url(); ?>assets/template/sweetalert2/sweetalert2.all.min.js"></script>
    <!-- Chartjs -->
    <script src="<?php echo base_url(); ?>assets/template/chartjs/dist/Chart.min.js"></script>

    <!-- Jquery Print, sirve para imprimir -->
    <script src="<?php echo base_url(); ?>assets/template/jquery-print/jquery.print.js"></script>
    <!-- iCheck -->
    <script src="<?php echo base_url(); ?>assets/template/iCheck/icheck.min.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="<?php echo base_url(); ?>assets/template/build/js/custom.min.js"></script>

    <input type="hidden" value="<?php echo base_url() ?>" id="base_url">

    <?php
    if (isset($pagina)) { ?>
      <script type="text/javascript" src="<?php echo base_url(); ?>assets/JavaScript/Js<?php echo $pagina; ?>.js"></script>
    <?php
    }
    ?>
    <script>
      var base_url = $("#base_url").val();

      function mayus(e) {
        e.value = e.value.toUpperCase();
      }
    </script>

    </body>

    </html>