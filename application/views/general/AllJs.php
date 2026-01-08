   <!-- Few JS and CSS are in header.php file also under view/ on root -->
   
   <script src="<?php echo base_url(""); ?>theme-assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(""); ?>theme-assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?php echo base_url(""); ?>theme-assets/libs/node-waves/waves.min.js"></script>
    <script src="<?php echo base_url(""); ?>theme-assets/libs/feather-icons/feather.min.js"></script>
    <script src="<?php echo base_url(""); ?>theme-assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="<?php echo base_url(""); ?>theme-assets/js/plugins.js"></script>
    <script src="<?php echo base_url(""); ?>theme-assets/js/layout.js"></script>
    <script src="<?php echo base_url(""); ?>theme-assets/libs/prismjs/prism.js"></script>
   
    
     <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.0/html2canvas.min.js"></script>
     <script src="<?php echo base_url(""); ?>theme-assets/js/pages/form-validation.init.js"></script>
       <script src="<?php echo base_url(""); ?>theme-assets/js/pages/password-addon.init.js"></script>
       
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="<?php echo base_url(""); ?>theme-assets/js/pages/select2.init.js"></script>


 
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    

    <!-- list.js min js -->
    <script src="<?php echo base_url(""); ?>theme-assets/libs/list.js/list.min.js"></script>
    <script src="<?php echo base_url(""); ?>theme-assets/libs/list.pagination.js/list.pagination.min.js"></script>
     <script src="<?php echo base_url(""); ?>theme-assets/js/pages/listjs.init.js"></script>
     

    <!-- Sweet Alerts js -->
    
    <script src="<?php echo base_url(""); ?>theme-assets/libs/sweetalert2/sweetalert2.min.js"></script>

  
    
    <!-- Modal Js -->
    <script src="<?php echo base_url(""); ?>theme-assets/js/pages/modal.init.js"></script>
     
      <script src="<?php echo base_url(""); ?>theme-assets/js/app.js"></script>
      
      
      
    
    <script src="<?php echo base_url(""); ?>theme-assets/libs/nouislider/nouislider.min.js"></script>
    <script src="<?php echo base_url(""); ?>theme-assets/libs/wnumb/wNumb.min.js"></script>
    <!-- range slider init -->
    <script src="<?php echo base_url(""); ?>theme-assets/js/pages/range-sliders.init.js"></script>
    
<script src="<?php echo base_url(""); ?>theme-assets/libs/swiper/swiper-bundle.min.js"></script>
<script src="<?php echo base_url(""); ?>theme-assets/js/pages/swiper.init.js"></script>
                              
   

<link href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css" rel="stylesheet" type="text/css" />
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
 <script src="<?php echo base_url(""); ?>theme-assets/js/pages/ecommerce-product-checkout.init.js"></script>

<script>
   function explode(){
      $('.hideMeAlert').remove();
      <?php 
        $this->session->unset_userdata('sucess_msg');
        $this->session->unset_userdata('error_msg');
        ?>
    }
    setTimeout(explode, 2000);
    
 function goBack() {
    window.history.back();
}   

         $('.JUItimepicker').timepicker({
           timeFormat: 'h:mm p',
           interval: 30,
           dynamic: true,
           dropdown: true,
           scrollbar: true
           });
           
          $(document).on('focus', '.JUItimepicker', function() {
          $(this).timepicker();
         })
         
    
</script>