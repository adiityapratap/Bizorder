<div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">
                        <div class="alert alert-success shadow d-none" role="alert">
                       <strong> Success !</strong> Order deleted succesfully .
                       </div>
      <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div id="customerList">
                                            <div class="row g-4 mb-3">
                                                <div class="col-sm-auto">
                                                    <div>
                                                          <h4 class="card-title mb-0 text-black">Order History</h4>
                                                    </div>
                                                </div>
                                               
                                            </div>
                                            <ul class="nav nav-tabs nav-tabs-custom nav-success mb-3" role="tablist">
                                            
                                            <li class="nav-item">
                                                <a class="nav-link py-3 Delivered active" data-bs-toggle="tab"
                                                    href="#sentOrdersTab" role="tab" aria-selected="false">
                                                    <i class="ri-checkbox-circle-line me-1 align-bottom"></i> Sent Orders
                                                </a>
                                            </li>
                                           
                                           
                                            <li class="nav-item">
                                                <a class="nav-link py-3 Cancelled" data-bs-toggle="tab" 
                                                    href="#receivedOrdersTab" role="tab" aria-selected="false">
                                                    <i class="ri-close-circle-line me-1 align-bottom"></i> Received Orders
                                                </a>
                                            </li>
                                        </ul>  
                                           <div class="tab-content  mb-1">
                                        <div class="tab-pane active show" role="tabpanel"  id="sentOrdersTab">
                                            <div class="mt-3 mb-1">
                                                <table class="table align-middle table-nowrap table-responsive sentOrdersTable">
                                                    <thead class="table-light">
                                                     <tr>
                                                            <th class="sort" data-sort="product_code">PO Number</th>
                                                            <th class="sort" data-sort="product_name">Order Date</th>
                                                            <th class="sort" data-sort="product_name">Delivery Date</th>
                                                            <th class="sort" data-sort="price">Order Total</th>
                                                             <th class="sort" data-sort="price">Supplier Name</th>
                                                            <th class="sort" data-sort="approve">Status</th>
                                                            <th class="no-sort" width="200">Action</th>
                                                            </tr>
                                                    </thead>
                                                     <tbody class="list form-check-all" id="sortable">
                                                        <?php if(!empty($result)) {  ?>
                                                        
                                                        <?php foreach($result as $row){  ?>
                                      <tr id="row_<?php echo  $row['id']; ?>" >
                        <td class="product_code">
                        <?php echo $row['id']; ?>
                        </td>
                         <td class="date_created"><?php echo date('d-m-Y',strtotime($row['date_created'])); ?></td>
                        <?php if(isset($row['delivery_date']) && ($row['delivery_date'] !='' && $row['delivery_date'] !='0000-00-00' && $row['delivery_date'] !='1970-01-01')){ ?>
                        <td class="delivery_date"><?php echo date('d-m-Y',strtotime($row['delivery_date'])); ?></td>
                        <?php } else { ?>
                        <td class="delivery_date"></td>
                        <?php } ?>
                        
                        <td class="price">
                          <?php echo '$'.number_format($row['order_total'],2); ?>                            
                          </td>
                        <td class="supplier_name"><?php echo $row['supplier_name']; ?></td>
                         <td class="status">
                             <?php if($row['status'] == 1){ $badgeClassName = 'bg-secondary-subtle text-secondary'; } if($row['status'] == 2){ $badgeClassName = 'bg-primary-subtle text-primary'; }  if($row['status'] == 3){ $badgeClassName = 'bg-success-subtle text-success'; }  if($row['status'] == 4){ $badgeClassName = 'bg-danger-subtle text-danger'; }  if($row['status'] == 5){ $badgeClassName = 'bg-danger-subtle text-danger'; } ?>
                         <span class="badge <?php echo $badgeClassName; ?>"><?php echo $row['status_name']; ?></span>    
                          </td>
                        
                      
                      <td>
                     <?php
                  
                    //  $paramsToEncrypt = $row['product_id'].'|'.$isPARLevelRequired;
                    //  $encryptedParams = $this->encryption->encrypt($paramsToEncrypt);
                    //  $encodedParams = urlencode($encryptedParams);
                      ?>      
                      <ul class="list-inline hstack gap-2 mb-0">
                        <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
                         <a href="<?php echo base_url('Supplier/Orders/receiveOrderDetails/'.$row['id'].'/view'); ?>" class="text-success d-inline-block">
                         <i class="ri-eye-fill fs-16"></i>
                        </a>
                        </li>
                   
                       <?php if($row['status'] == 1){ ?>
                          <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                         <a href="<?php echo base_url('Supplier/Orders/editOrderDetails/'.$row['supplier_id'].'/'.$row['id']); ?>" class="text-success d-inline-block">
                         <i class="ri-pencil-fill fs-16"></i>
                        </a>
                        </li>
                        
                         <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                          <a class="text-danger d-inline-block remove-item-btn"  href="#deleteOrder" data-rel-id="<?php echo  $row['id']; ?>">
                         <i class="ri-delete-bin-5-fill fs-16"></i>
                         </a>
                         </li>
                          <?php } ?>
                           <?php if($row['status'] != 0 && $row['status'] != 5 && $row['status'] != 6){ ?>    
                         <li class="list-inline-item">
                        <a href="<?php echo base_url('Supplier/Orders/receiveOrderDetails/'.$row['id']); ?>" type="button" class="btn btn-sm btn-soft-danger shadow-none">
                         <i class="ri-file-list-3-line align-right"></i> Receive</a> 
                        </li>
                     <?php } ?>    
                        </ul>
                        </td>    
                          </tr>
                                                        <?php } ?>
                                                          <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            </div>
                                     <div class="tab-pane" role="tabpanel"  id="receivedOrdersTab">
                                        <div class=" mt-3 mb-1">
                                              
                                                <table class="table align-middle table-nowrap table-responsive sentOrdersTable">
                                                    <thead class="table-light">
                                                     <tr>
                                                            <th class="sort" data-sort="product_code">PO Number</th>
                                                            <th class="sort" data-sort="product_name">Order Date</th>
                                                            <th class="sort" data-sort="product_name">Delivery Date</th>
                                                            <th class="sort" data-sort="price">Order Total</th>
                                                             <th class="sort" data-sort="price">Supplier Name</th>
                                                            <th class="sort" data-sort="approve">Status</th>
                                                            <th class="no-sort" width="200">Action</th>
                                                            </tr>
                                                    </thead>
                                                     <tbody class="list form-check-all" id="sortable">
                       <?php if(!empty($receivedOrders)) {  ?>
                        <?php foreach($receivedOrders as $row){  ?>
                        <tr id="row_<?php echo  $row['id']; ?>" >
                        <td class="product_code">
                        <?php echo $row['id']; ?>
                        </td>
                        <td class="date_created"><?php echo date('d-m-Y',strtotime($row['date_created'])); ?></td>
                        <td class="delivery_date"><?php echo date('d-m-Y',strtotime($row['delivery_date'])); ?></td>
                        <td class="price">
                          <?php echo '$'.number_format($row['order_total'],2); ?>                            
                          </td>
                        <td class="product_name"><?php echo $row['supplier_name']; ?></td>
                        <td class="status">
                             <?php if($row['status'] == 1){ $badgeClassName = 'bg-secondary-subtle text-secondary'; } if($row['status'] == 2){ $badgeClassName = 'bg-primary-subtle text-primary'; }  if($row['status'] == 3){ $badgeClassName = 'bg-success-subtle text-success'; }  if($row['status'] == 4){ $badgeClassName = 'bg-danger-subtle text-danger'; } if($row['status'] == 5){ $badgeClassName = 'bg-warning-subtle text-danger'; }  ?>
                         <span class="badge <?php echo $badgeClassName; ?>"><?php echo $row['status_name']; ?></span>    
                          </td>
                        
                      
                      <td>
                     <?php
                  
                    //  $paramsToEncrypt = $row['product_id'].'|'.$isPARLevelRequired;
                    //  $encryptedParams = $this->encryption->encrypt($paramsToEncrypt);
                    //  $encodedParams = urlencode($encryptedParams);
                      ?>      
                      <ul class="list-inline hstack gap-2 mb-0">
                        <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
                         <a href="<?php echo base_url('Supplier/Orders/receiveOrderDetails/'.$row['id'].'/view'); ?>" class="text-success d-inline-block">
                         <i class="ri-eye-fill fs-16"></i>
                        </a>
                        </li>
                        
                    
                        </ul>
                        </td>    
                          </tr>
                                                        <?php } ?>
                                                          <?php } ?>
                                                    </tbody>
                                                </table>
                                               
                                                
                                            </div>
                                           
                                        </div>
                                        </div>
                                        </div>
                                    </div><!-- end card -->
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end col -->
                        </div>
                       

                        

                    </div>
                    <!-- container-fluid -->
                </div>
             
            </div>
          
        <script type="text/javascript">
       
        $(document).ready(function(){
            let supplier_id = "<?php echo $supplier_id; ?>";
           localStorage.removeItem('suppId');
           localStorage.setItem('suppId', supplier_id);
        })
        
        $('.sentOrdersTable').DataTable({
    "bLengthChange": false,
    "pageLength": 100,
    "order": [[0, 'desc']], // Sort the first column (index 0) in descending order
    "lengthMenu": [0, 5, 10, 20, 50, 100, 200, 500],
    "columnDefs": [{
        "targets": 'no-sort',
        "orderable": false
    }]
});

        
         
            $(document).on("click", ".remove-item-btn" , function() {
                var id = $(this).attr('data-rel-id');
            
                    Swal.fire({
                      title: "Are you sure?",
                      icon: "warning",
                      showCancelButton: !0,
                      confirmButtonClass: "btn btn-primary w-xs me-2 mt-2",
                      cancelButtonClass: "btn btn-danger w-xs mt-2",
                      confirmButtonText: "Yes, delete it!",
                      buttonsStyling: !1,
                      showCloseButton: !0,
                  }).then(function (e) {
                      if (e.value) {
                          
                        
                        $.ajax({
                            type: "POST",
                            url: "/Supplier/Orders/orderDelete",
                            data:'order_id='+id,
                            success: function(data){
                               $(".alert-success").removeClass('d-none');
                              $('#row_'+id).remove();
                              
                            }
                        });
                        
                    
                          
                      }
                  })
                
                
            });
            
           
          
            
          
        </script>
 