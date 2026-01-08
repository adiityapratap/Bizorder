<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="light" data-sidebar="dark" data-sidebar-size="sm-hover-active" data-sidebar-image="none" data-preloader="disable">

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Bizadmin</title>
  <link rel="shortcut icon" href="<?php echo base_url();?>login-assets/img/favicon.jpeg" />
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('application/modules/Supplier/assets/css/custom.css');?>" />
  
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
   <meta charset="utf-8">
    <?php 
 // we have a common header to import all css for all the Apps like HR, Cash , Supplier etc so that css and js can be reused across all aps using common file
     $common_view_path = APPPATH . 'views/general/header.php';
     include($common_view_path);
?>
   


</head>
<body data-base-url="<?php echo base_url(); ?>">


    <div id="layout-wrapper">

        <?php $this->load->view('partials/menu'); ?>
        
        

       
      
       
      