<style>
input[type=checkbox], input[type=radio] {
    margin: 9px 10px 9px 0;
}
</style>
<div class="main-content">

    <div class="page-content">
                
    <div class="container-fluid">
         <h4 class="text-black">All Floors</h4>
     <div class="row">
        <div class="col-lg-6">
            <div class="page-content-inner">
                <div class="card" id="userList">
                  
                    <div class="card-header border-bottom-dashed">

                       <div class="row g-4 align-items-center">
                            <div class="col-sm">
                                <div>
                                    <h5 class="card-title mb-0 text-black">Production Form   <?php echo date('d-m-Y') ?></h5>
                                </div>
                            </div>
                            <div class="col-sm-auto">
                              <div class="flex-shrink-0 me-2">
            <button class="btn btn-md btn-success btn-sm" onclick="window.print();">Print</button>
        </div>
                            </div>
                        </div>
                    </div>
                    
                   
                    
                    <div class="card-body">
                        
                  <div class="row">
                    
                   
                   <table class="table table-responsive table-bordered table-striped mt-3">
                    <thead class="table-dark">
                        <tr>
                           <th>Menu Name</th>
                            <th>Qty</th>
                            <th>Action</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        
              <?php if(isset($orderDataRows) && !empty($orderDataRows)) {  ?>
              <?php foreach($orderDataRows as $categoryName => $orderMenuInfo){ ?>
                  <tr>
                  <th colspan="3" class="text-black w-100" style="background-color: #dff0fa;"><b><?php echo $categoryName; ?></b> 
                  </th>
                  </tr>
                        <?php foreach($orderMenuInfo as $orderMenu){ ?>
                       <tr class="ordertableRow">
                         <td><?php echo $orderMenu['name'] ?></td>   
                         <td><?php echo $orderMenu['qty'] ?></td>   
                         <?php if($orderMenu['status'] == 1) {  ?>
                         <td><a href="#" class="btn btn-danger btn-sm mt-2 mt-sm-0 shadow-none "><i class="bx bxs-bowl-hot align-middle me-1"></i> Completed</a></td>
                         <?php } else { ?>
                         <td><a href="javascript:void(0);" class="btn btn-success completedButton btn-sm mt-2 mt-sm-0 shadow-none" onclick="markCompleted(this,<?php echo $orderMenu['order_id'] ?>,<?php echo $orderMenu['menu_id'] ?>)"><i class="mdi mdi-coffee-maker-check align-middle me-1"></i> Complete</a></td>
                         <?php }  ?>
                        </tr>    
                        <?php }  } ?>
                         <?php }   ?>
                          
                    </tbody>
                </table> 

                    </div>
                 </div>
                 
                </div>
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="page-content-inner">
                <div class="card" id="userList">
                  
                    <div class="card-header border-bottom-dashed">

                       <div class="row g-4 align-items-center">
                            <div class="col-sm">
                                <div>
                                    <h5 class="card-title mb-0 text-black">Order Notes</h5>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                    
                   
                    
                    <div class="card-body">
                        
                  <div class="row">
                    
                   
                   <table class="table table-responsive table-bordered table-striped mt-3">
                    <thead class="table-dark">
                        <tr>
                           <th>Floor</th>
                            <th>Bed No</th>
                            <th>Order Notes</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        
              <?php if(isset($orderWithNotes) && !empty($orderWithNotes)) {  ?>
              <?php foreach($orderWithNotes as $orderWithNote){ ?>
                       <tr class="ordernotetableRow">
                         <td><?php echo $orderWithNote['floor'] ?></td>   
                         <td><?php echo $orderWithNote['bed_no'] ?></td>   
                         <td><?php echo $orderWithNote['order_comment'] ?></td>   
                        </tr>    
                        <?php   } ?>
                         <?php }   ?>
                          
                    </tbody>
                </table> 

                    </div>
                 </div>
                 
                </div>
            </div>
        </div>
            <!--end col-->
     </div>
        <!--end row-->
       
        
        
    </div>
            <!-- container-fluid -->
    </div>
        <!-- End Page-content -->

        
    </div>
    <!-- end main content-->
</div>
<!-- END layout-wrapper -->



<script type="text/javascript">

	

 function markCompleted(obj,order_id,menu_id){
         
          $(obj).html("Loading...");
    $.ajax({
        url: '<?= base_url("Orderportal/Order/markFoodCompleted") ?>',
        type: 'POST',
        data: {
            order_id: order_id,
            menu_id: menu_id
        },
        success: function(response) {
            let res = JSON.parse(response)
          
            if (res.status == 'success') {
               $(obj).removeAttr('onclick');
                $(obj).html('<i class="bx bxs-bowl-hot label-icon align-middle fs-12 me-2"></i>Completed');
                $(obj).parents(".ordertableRow").find(".completedButton").removeClass("btn-success").addClass("btn-danger")
            } else {
                 $(obj).html('<i class="bx bxs-bowl-hot label-icon align-middle fs-12 me-2"></i>Completed');
                alert(response.message);
            }
        },
        error: function() {
            alert('An error occurred while saving the menu.');
        }
    }); 
      } 	

    
</script>