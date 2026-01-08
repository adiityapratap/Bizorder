	<!-- footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0 text-mute">&copy;
                                BIZADMIN @Maintained by AARIA
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
	<!-- JAVASCRIPT -->
    <script src="<?php echo base_url(""); ?>theme-assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(""); ?>theme-assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?php echo base_url(""); ?>theme-assets/libs/node-waves/waves.min.js"></script>
    <script src="<?php echo base_url(""); ?>theme-assets/libs/feather-icons/feather.min.js"></script>
    <script src="<?php echo base_url(""); ?>theme-assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="<?php echo base_url(""); ?>theme-assets/js/plugins.js"></script>

    <!-- list.js min js -->
    <script src="<?php echo base_url(""); ?>theme-assets/libs/list.js/list.min.js"></script>
    <script src="<?php echo base_url(""); ?>theme-assets/libs/list.pagination.js/list.pagination.min.js"></script>

    <!-- Sweet Alerts js -->
    <script src="<?php echo base_url(""); ?>theme-assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <!-- App js -->
    <script src="<?php echo base_url(""); ?>theme-assets/js/app.js"></script>
    
    <!-- Modal Js -->
    <script src="<?php echo base_url(""); ?>theme-assets/js/pages/modal.init.js"></script>
    
    <!-- Datatable -->
    
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
<script>
   function explode(){
      $('.hideMeAlert').remove();
      <?php 
        $this->session->unset_userdata('sucess_msg');
        $this->session->unset_userdata('error_msg');
        ?>
    }
    setTimeout(explode, 2000);
</script>

</body>
</html>