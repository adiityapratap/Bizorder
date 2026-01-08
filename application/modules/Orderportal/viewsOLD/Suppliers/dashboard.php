<div class="main-content">
<div class="page-content">
                <div class="container-fluid">
                  <div class="row">
                        <div class="col-lg-12">
                            <div class="h-100">
                         <!--dashboard content-->
                         <div class="row">
                            <div class="col-xl-12">
                                <div class="card crm-widget">
                                    <div class="card-body p-0">
                                        <div class="row row-cols-xxl-4 row-cols-md-3 row-cols-1 g-1">
                                           
                                            <div class="col col-md-3 col-lg-3 col-sm-12">
                                                <div class="mt-3 mt-md-0 py-4 px-5 border-bottom">
                                                    <h5 class="text-black text-uppercase fs-12">Weekly Location Budget  <i class="ri-arrow-up-circle-line text-success fs-18 float-end align-middle"></i></h5>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="ri-exchange-dollar-line text-black fs-16"></i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h5 class="mb-0 text-black">$<span class="counter-valuee" data-target="<?php echo (isset($locationBudgetDetails->weeklyLocationBudget) ? $locationBudgetDetails->weeklyLocationBudget : '') ?>"><?php echo (isset($locationBudgetDetails->weeklyLocationBudget) ? number_format($locationBudgetDetails->weeklyLocationBudget, 2, '.', ',') : '') ?></span></h5>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mt-2 mt-md-0 py-3 px-5">
                                                    <h5 class="text-black text-uppercase fs-12">Monthly Location Budget  <i class="ri-arrow-up-circle-line text-success fs-18 float-end align-middle"></i></h5>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="ri-exchange-dollar-line  text-black fs-16 text-danger" ></i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h5 class="mb-0 text-black">$<span class="counter-valuee" data-target="<?php echo (isset($locationBudgetDetails->monthlyLocationBudget) ? $locationBudgetDetails->monthlyLocationBudget : '') ?>"><?php echo (isset($locationBudgetDetails->monthlyLocationBudget) ? number_format($locationBudgetDetails->monthlyLocationBudget, 2, '.', ',') : '') ?></span></h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end col -->
                                            <div class="col col-md-3 col-lg-3 col-sm-12">
                                                <div class="mt-3 mt-md-0 py-4 px-5 border-bottom">
                                                    <h5 class="text-black text-uppercase fs-12">Weekly Spent <i class="ri-arrow-down-circle-line text-danger fs-18 float-end align-middle"></i></h5>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="ri-pulse-line fs-16 text-danger"></i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h5 class="mb-0 text-black"><span class="counter-valuee" data-target="<?php echo number_format($weeklySpent, 2, '.', ','); ?>"><?php echo number_format($weeklySpent, 2, '.', ','); ?></span></h5>
                                                        </div>
                                                    </div>
                                                </div>
                                                 <div class="mt-2 mt-md-0 py-3 px-5">
                                                    <h5 class="text-black text-uppercase fs-12">Monthly Spent  <i class="ri-arrow-down-circle-line text-danger fs-18 float-end align-middle"></i></h5>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="ri-pulse-line text-danger fs-16"></i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h5 class="mb-0 text-black"><span class="counter-valuee" data-target="<?php echo number_format($monthlySpent, 2, '.', ','); ?>"><?php echo number_format($monthlySpent, 2, '.', ','); ?></span></h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end col -->
                                            <div class="col col-md-3 col-lg-3 col-sm-12 ">
                                                <div class="mt-3 mt-lg-0 py-4 px-5 border-bottom">
                                                    <h5 class="text-black text-uppercase fs-12">Weekly Remaining Budget <i class="ri-money-dollar-circle-line text-success fs-18 float-end align-middle"></i></h5>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="ri-money-dollar-circle-line fs-16 text-black"></i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h5 class="mb-0 text-black text-black">$<span class="counter-valuee" data-target="<?php echo number_format($weeklyRemaining, 2, '.', ','); ?>"><?php echo number_format($weeklyRemaining, 2, '.', ','); ?></span></h5>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mt-2 mt-lg-0 py-3 px-5">
                                                    <h5 class="text-black text-uppercase fs-12">Monthly Remaining Budget <i class="ri-money-dollar-circle-line text-success fs-18 float-end align-middle"></i></h5>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="ri-money-dollar-circle-line fs-16 text-danger"></i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h5 class="mb-0 text-black text-black">$<span class="counter-valuee" data-target="<?php echo number_format($monthlyRemaining, 2, '.', ','); ?>"><?php echo number_format($monthlyRemaining, 2, '.', ','); ?></span></h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end col -->
                                            
                                             <div class="col col-md-3 col-lg-3 col-sm-12">
                                                <div class="mt-2 mt-lg-0 py-4 px-5">
                                                     
                                                    <h5 class="text-black text-uppercase fs-12">Order Sent Status </h5>
                                                   
                                                   <div class="d-flex align-items-center mt-4">
                                                        <div class="flex-shrink-0">
                                                            <i class="ri-truck-line fs-18 text-success"></i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                        <h5 class="text-black fs-18"> Sent Orders : <?php echo $thisWeekSentOrders; ?> </h5>
                                                        </div>
                                                    </div>  
                                                  <!--<div class="d-flex align-items-center">-->
                                                  <!--      <div class="flex-shrink-0">-->
                                                  <!-- <i class="ri-calendar-todo-fill fs-18 text-success"></i>        -->
                                                  <!--      </div>-->
                                                  <!--      <div class="flex-grow-1 ms-3">-->
                                                  <!--      <h5 class="text-black text-uppercase fs-13">Spent : $12423 </h5>-->
                                                  <!--      </div>-->
                                                  <!--  </div>-->
                                                    
                                                  <!--  <div class="d-flex align-items-center">-->
                                                  <!--      <div class="flex-shrink-0">-->
                                                  <!--  <i class="ri-calculator-fill fs-18 text-danger"></i>       -->
                                                  <!--      </div>-->
                                                  <!--      <div class="flex-grow-1 ms-3">-->
                                                  <!--      <h5 class="text-black text-uppercase fs-13">Remaining : $12423 </h5>-->
                                                  <!--      </div>-->
                                                  <!--  </div>-->
                                                   
                                                </div>
                                            </div><!-- end col -->
                                            
                                            
                                           
                                            
                                            
                                          
                                        </div><!-- end row -->
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->
                        </div><!-- end row -->

                        <div class="row">
                             <?php
                            //  if(isset($configData['showInternalOrder']) && $configData['showInternalOrder']) { 
                            //  $gridClassname ='col-xxl-6 col-lg-7 col-md-12 col-sm-12';
                            //  }else{
                            //  $gridClassname ='col-xxl-12 col-lg-12 col-md-12 col-sm-12';    
                            //  }
                             ?>
                             
                            <div class="col-xxl-6 col-lg-7 col-md-12 col-sm-12">
                                <div class="card">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1 text-black">Today’s Orders</h4>
                                        
                                    </div><!-- end card header -->
                                    <div class="card-body pb-0">
                                        <ul class="nav nav-pills card-header-pills mb-12 dashboardMandotryTabs" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-bs-toggle="tab" href="#mandatory" role="tab">
                                                        Mandatory Orders 
                                                    </a>
                                                </li>
                                                <!--<li class="nav-item">-->
                                                <!--    <a class="nav-link" data-bs-toggle="tab" href="#nonmandatory" role="tab">-->
                                                <!--        Non-Mandatory Orders -->
                                                <!--    </a>-->
                                                <!--</li>-->
                                                <li class="nav-item">
                                                    <a class="nav-link" data-bs-toggle="tab" href="#allSuppliers" role="tab">
                                                        All Orders 
                                                    </a>
                                                </li>
                                            </ul>
                                            <!-- Tab panes -->
                                        <div class="tab-content text-black">
                                            <div class="tab-pane active" id="mandatory" role="tabpanel">
                                                 <div class="table-responsive table-card dashboardMandotryTable" >
                                            <table class="table table-borderless table-hover table-nowrap align-middle mb-3">

                                                <tbody>
                                                
                                <div id="pagination-list">
                                                <div class="mb-2">
                                                    <input class="form-control searchListKeyword" placeholder="Search" />
                                                </div>
                                                
                                                <div class="mx-n3 searchContainer">
                                                    <ul class="list list-group list-group-flush mb-0 listOfItems">
                                                      <?php if(!empty($mandatoryRecord))foreach($mandatoryRecord as $mandotrySupp) {  
                                                        if(!empty($mandotrySupp['mandatory_days'])){
                                                            $mandatory_days = unserialize($mandotrySupp['mandatory_days']); 
                                                            // echo "<pre>"; print_r($mandotrySupp); exit;
                                                            }else{
                                                                $mandatory_days = [];
                                                            }
                                                           $weekday = date('D',strtotime("now")); 
                                             if(in_array($weekday,$mandatory_days) && $mandotrySupp['last_order_date'] != date('Y-m-d')){
                                                      ?>
                                                        <li class="list-group-item <?php echo $weekday; ?>">
                                                            <div class="d-flex align-items-center pagi-list">
                                                                
                                                                <div class="flex-grow-1 overflow-hidden">
                                                                    <h5 class="fs-13 mb-1"><a href="#" class="link text-dark itemName"><?php echo $mandotrySupp['supplier_name'] ?></a></h5>
                                                                    <p class="born fs-12 timestamp text-black mb-0"> <b>  <?php echo "Cut off time : ".date('h:i A',strtotime($mandotrySupp['cutofftime'])) ?></b></p>
                                                                </div>
                                                                <div class="flex-shrink-0 ms-2">
                         <?php if($mandotrySupp['is_completed'] && !$mandotrySupp['requireMST']) { ?>                                           
                         <a href="<?php echo base_url('Supplier/stockupdate/'.$mandotrySupp['supplier_id'].'_'.$mandotrySupp['requirePL']); ?>" class="btn btn-success btn-sm"><i class=" ri-list-ordered align-bottom"></i>Stock Count Completed</a>           
                        <?php }else if($mandotrySupp['requireMST']){ ?>
                        <?php if($mandotrySupp['is_completed']) { ?> 
                      <a href="<?php echo base_url('Supplier/monthlystock/'.$mandotrySupp['supplier_id'].'_0'); ?>" class="btn btn-success btn-sm"><i class=" ri-list-ordered align-bottom"></i>Monthly Stock Count Completed</a>     
                        <?php }else {  ?>
                        <a href="<?php echo base_url('Supplier/monthlystock/'.$mandotrySupp['supplier_id'].'_0'); ?>" class="btn btn-orange btn-sm"><i class=" ri-list-ordered align-bottom"></i>Monthly Stock Count View</a>
                        <?php } ?>
                                   
                        <?php }else if($mandotrySupp['requireSC']){ ?> 
                        <a href="<?php echo base_url('Supplier/stockupdate/'.$mandotrySupp['supplier_id'].'_'.$mandotrySupp['requirePL']); ?>" class="btn btn-orange btn-sm"><i class=" ri-list-ordered align-bottom"></i>Stock Count Required</a>           
                        <?php } ?>
                        
                        <?php if($mandotrySupp['requireMST']){ ?> 
                         <a href="<?php echo base_url('Supplier/placeOrder/'.$mandotrySupp['supplier_id'].'_'.$mandotrySupp['requirePL'].'_1'); ?>" class="btn btn-blue btn-sm btn-light"><i class="ri-mail-line align-bottom"></i> Order now</a>
                         <?php }else {  ?>
                         <a href="<?php echo base_url('Supplier/placeOrder/'.$mandotrySupp['supplier_id'].'_'.$mandotrySupp['requirePL'].'_0'); ?>" class="btn btn-blue btn-sm btn-light"><i class="ri-mail-line align-bottom"></i> Order now</a>
                          <?php } ?>
                                                             </div>
                                                            </div>
                                                        </li>
                                                      <?php } } ?>
                                                    </ul>
                                                   

                                                </div>
                                            </div>
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                            </div>
                                
                                             <div class="tab-pane" id="allSuppliers" role="tabpanel" >
                                                 <div class="table-responsive table-card dashboardMandotryTable" >
                                            <table class="table table-borderless table-hover table-nowrap align-middle mb-3">

                                                <tbody>
                                                
                                <div id="pagination-list">
                                                <div class="mb-2">
                                                    <input class="searchListKeywordAll form-control" placeholder="Search" />
                                                </div>
                                                
                                                <div class="mx-n3 searchContainer">
                                                     <ul class="list list-group list-group-flush mb-0 listOfItems">
                                                   <?php if(!empty($mandatoryRecord))foreach($mandatoryRecord as $allSuppliers) {   ?>
                                                      
                                                        <li class="list-group-item <?php echo $weekday; ?>">
                                                            <div class="d-flex align-items-center pagi-list">
                                                                <div class="flex-grow-1 overflow-hidden">
                                                                    <h5 class="fs-13 mb-1"><a href="#" class="link text-dark itemName"><?php echo $allSuppliers['supplier_name'] ?></a></h5>
                                                                    <p class="born fs-12 timestamp text-black mb-0"><b>  <?php echo "Cut off time : ".date('h:i A',strtotime($allSuppliers['cutofftime'])) ?></b></p>
                                                                </div>
                                                                <div class="flex-shrink-0 ms-2">
                                                                    
                         <?php if($allSuppliers['is_completed']) { ?>                                           
                         <a href="<?php echo base_url('Supplier/placeOrder/'.$allSuppliers['supplier_id'].'_'.$allSuppliers['requirePL']); ?>" class="btn btn-success btn-sm"><i class=" ri-list-ordered align-bottom"></i>Stock Count Completed</a>           
                         <?php }else if($allSuppliers['requireMST']){ ?> 
                        <a href="<?php echo base_url('Supplier/monthlystock/'.$allSuppliers['supplier_id'].'_0'); ?>" class="btn btn-orange btn-sm"><i class=" ri-list-ordered align-bottom"></i>Monthly Stock Count View</a>           
                         <?php }else if($allSuppliers['requireSC']){ ?> 
                        <a href="<?php echo base_url('Supplier/stockupdate/'.$allSuppliers['supplier_id'].'_'.$allSuppliers['requirePL']); ?>" class="btn btn-orange btn-sm"><i class=" ri-list-ordered align-bottom"></i>Stock Count Required</a>           
                        <?php } ?>
                        
                         <?php if($allSuppliers['requireMST']){ ?> 
                         <a href="<?php echo base_url('Supplier/placeOrder/'.$allSuppliers['supplier_id'].'_'.$allSuppliers['requirePL'].'_1'); ?>" class="btn btn-blue btn-sm btn-light"><i class="ri-mail-line align-bottom"></i> Order now</a>
                         <?php }else {  ?>
                         <a href="<?php echo base_url('Supplier/placeOrder/'.$allSuppliers['supplier_id'].'_'.$allSuppliers['requirePL'].'_0'); ?>" class="btn btn-blue btn-sm btn-light"><i class="ri-mail-line align-bottom"></i> Order now</a>
                          <?php } ?>                                                   
                                                                    
                                                               </div>
                                                            </div>
                                                        </li>
                                                      <?php }   ?>
                                                    <!-- end ul list -->
                                                      </ul>
                                                </div>
                                            </div>
                                                    
                                                </tbody><!-- end tbody -->
                                            </table><!-- end table -->
                                            </div><!-- end table responsive -->
                                            </div>
                                          
                                        </div>
                                    </div>
                                </div><!-- end card -->
                            </div>
                            
                     
                         <div class="col-xxl-6 col-lg-5 col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0 text-black">Internal Orders</h4>
                                </div>
                                <div class="card-body">
                                <div class="table-responsive table-card dashboardMandotryTable" >
                                            <table class="table table-borderless table-hover table-nowrap align-middle mb-3">
                                                <tbody>
                                                
                                <div id="pagination-list">
                                                <div class="mb-2">
                                                    <input class="searchListKeywordAllInternalSubLoc form-control" placeholder="Search" />
                                                </div>
                                                
                                                <div class="mx-n3 searchContainer">
                                                     <ul class="list list-group list-group-flush mb-0 listOfItems">
                                                   <?php if(!empty($subLocationListInternalOrder))foreach($subLocationListInternalOrder as $subLocationList) {   ?>
                                                      
                                                        <li class="list-group-item ">
                                                            <div class="d-flex align-items-center pagi-list">
                                                                <div class="flex-grow-1 overflow-hidden">
                                                                    <h5 class="fs-13 mb-1"><a href="#" class="link text-dark itemName"><?php echo $subLocationList['name'] ?></a></h5>
                                                                   
                                                                </div>
                                                                <div class="flex-shrink-0 ms-2">
                          <?php if($subLocationList['is_kitchen']) { ?> 
                          <a href="<?php echo base_url('Supplier/internalorder/makeOrder'); ?>" class="btn btn-dark btn-sm "><i class="ri-mail-line align-bottom"></i> Make Order</a>
                          <?php }else {  ?>
                         <?php if($subLocationList['last_countedAt'] == date('Y-m-d')) { ?>                                           
                         <a href="<?php echo base_url('Supplier/internalorder/productCount/'.$subLocationList['id']); ?>" class="btn btn-success btn-sm"><i class=" ri-list-ordered align-bottom"></i>Order Placed</a>   
                         <?php }else{ ?> 
                        <a href="<?php echo base_url('Supplier/internalorder/productCount/'.$subLocationList['id']); ?>" class="btn btn-orange btn-sm"><i class=" ri-list-ordered align-bottom"></i>Product Count and Place Order</a>           
                        <?php } ?>
                        <a href="<?php echo base_url('Supplier/internalorder/placeOrder/'.$subLocationList['id']); ?>" class="btn btn-blue btn-sm btn-blue"><i class="ri-mail-line align-bottom"></i> Place Order</a>
                        <?php } ?>
                        
                                                                              
                                                                    
                                                               </div>
                                                            </div>
                                                        </li>
                                                      <?php }   ?>
                                                    <!-- end ul list -->
                                                      </ul>
                                                </div>
                                            </div>
                                                    
                                                </tbody><!-- end tbody -->
                                            </table><!-- end table -->
                                            </div>
                                </div>
                            </div>
                            <!-- end card -->
                        </div>  
                      
                            
                         
                        </div>
                        
                        
                        
                    <div class="row">
                        <?php
                        if($is_production){
                         $classCol = 'col-xxl-6 col-lg-7 col-md-12 col-sm-12';
                        }else{
                         $classCol = 'col-xxl-12 col-lg-12 col-md-12 col-sm-12';   
                        }
                        ?>
                         <!--receive order section -->
                    <div class="<?php echo $classCol; ?>">
                    <div class="card">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1 text-black">Deliveries</h4>
                                        
                                    </div><!-- end card header -->
                                    <div class="card-body pb-0">
                                        <ul class="nav nav-pills card-header-pills mb-12 dashboardMandotryTabs" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-bs-toggle="tab" href="#todayDelivery" role="tab">
                                                        Today’s Deliveries
                                                    </a>
                                                </li>
                                               
                                                <li class="nav-item">
                                                    <a class="nav-link" data-bs-toggle="tab" href="#allDelivery" role="tab">
                                                       All Deliveries
                                                    </a>
                                                </li>
                                            </ul>   
                                             <div class="tab-content text-black">
                                                 <div class="tab-pane active" id="todayDelivery" role="tabpanel">
                                                 <div class="table-responsive table-card dashboardMandotryTable" >
                                                    <table class="table table-bordered table-centered align-middle table-nowrap mb-0">
                                                        <thead class="text-muted table-light">
                                                            <tr>
                                                                <th scope="col">P.O Number</th>
                                                                <th scope="col">Order Date</th>
                                                                 <th scope="col">Delivery Date</th>
                                                                <th scope="col">Supplier Name</th>
                                                              
                                                                <th scope="col"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if(isset($todaysDelivery) && !empty($todaysDelivery)) {  ?>
                                                            <?php foreach($todaysDelivery as $td) { ?>
                                                            <tr>
                                                                <td>
                                                                    <a href="#" class="fw-medium link-primary">#<?php echo $td['id'] ?></a>
                                                                </td>
                                                                <td><?php echo date('d-m-Y',strtotime($td['date_created'])); ?></td>
                                                                <td><?php echo date('d-m-Y',strtotime($td['delivery_date'])); ?></td>
                                                                <td>
                                                                <span class="text-black"><?php echo $td['supplier_name'] ?></span>
                                                                </td>
                                                    <td class="text-center">
                                                      <a href="<?php echo base_url('Supplier/Orders/receiveOrderDetails/'.$td['id']); ?>" type="button" class="btn btn-orange btn-sm shadow-none align-right">
                                                        <i class="ri-file-list-3-line align-right"></i> Receive
                                                    </a>              
                                                     </td>    
                                                                
                                                            </tr>
                                                            
                                                            <?php } ?>
                                                            <?php } ?>
                                                           
                                                        </tbody><!-- end tbody -->
                                                    </table>   
                                                     
                                                     </div>
                                                     </div>
                                                 <div class="tab-pane" id="allDelivery" role="tabpanel" >
                                                 <div class="table-responsive table-card dashboardMandotryTable">
                                                 <table class="table table-bordered table-centered align-middle table-nowrap mb-0">
                                                        <thead class="text-muted table-light">
                                                            <tr>
                                                                <th scope="col">P.O Number</th>
                                                                <th scope="col">Order Date</th>
                                                                <th scope="col">Delivery Date</th>
                                                                <th scope="col">Supplier Name</th>
                                                                <th scope="col"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if(isset($allDeliveries) && !empty($allDeliveries)) {  ?>
                                                            <?php foreach($allDeliveries as $ad) { ?>
                                                            <tr>
                                                                <td>
                                                                    <a href="#" class="fw-medium link-primary">#<?php echo $ad['id'] ?></a>
                                                                </td>
                                                               <td><?php echo date('d-m-Y',strtotime($ad['date_created'])); ?></td>
                                                                <td><?php echo date('d-m-Y',strtotime($ad['delivery_date'])); ?></td>
                                                                <td>
                                                                    <span class="text-black"><?php echo $ad['supplier_name'] ?></span>
                                                                </td>
                                                                <td class="text-center">
                                                      <a href="<?php echo base_url('Supplier/Orders/receiveOrderDetails/'.$ad['id']); ?>" type="button" class="btn btn-orange btn-sm shadow-none align-right">
                                                        <i class="ri-file-list-3-line align-right"></i> Receive
                                                       </a>              
                                                                </td> 
                                                            </tr>
                                                            
                                                            <?php } ?>
                                                            <?php } ?>
                                                           
                                                        </tbody><!-- end tbody -->
                                                    </table>    
                                                     
                                                     </div>
                                                     </div>
                                                     
                        
                        
                        </div>
                        </div>
                                </div><!-- end card -->
                    </div>
                            <!--driver delivery section-->
                   <?php if($is_production) { ?>     
                   <div class="col-xxl-6 col-lg-5 col-md-12 col-sm-12"> 
                    <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0 text-black">Internal Orders Delivery ( <?php echo date('d-m-Y') ?> )</h4>
                                </div>
                                <div class="card-body">
                                <div class="table-responsive table-card dashboardMandotryTable" >
                                            <table class="table table-borderless table-hover table-nowrap align-middle mb-3">
                                                <tbody>
                                                
                                <div id="pagination-list">
                                                <div class="mx-n3 searchContainer">
                                                    
                                                   <?php if(!empty($allSubLocations))foreach($allSubLocations as $subLocationList) {   ?>
                                                       <?php if(!$subLocationList['is_kitchen']) { ?> 
                                                        <div class="row py-2 px-2 subLocList">
                                                        <div class="col">
                                                       <h5 class="fs-13 mb-1"><a href="#" class="link text-dark itemName"><?php echo $subLocationList['name'] ?></a></h5>
                                                       </div>
                                                                <div class="col">
                                                <input type="text" class="form-control comments" placeholder="Enter comments">                    
                                                                </div>
                                                                <div class="col">
                                                <input type="text" class="form-control temp" placeholder="Enter temperature">                    
                                                                </div>
                <div class="col ms-2">
                <i class="ri-attachment-2 align-bottom me-1 mx-3 fs-16 " style="color: red;" onclick="showAttachmentModal(<?php echo $subLocationList['id'] ?>)"></i>    
                  <?php  if($subLocationList['last_deliveryDate'] == date('Y-m-d')) { ?>
                <button class="btn btn-success btn-sm " ><i class="bx bxs-truck"></i> Delivered</button>  
                   <?php }else {  ?>
                <button class="btn btn-orange btn-sm " onclick="markdelivered(this,<?php echo $subLocationList['id'] ?>)"><i class="bx bxs-truck"></i> Deliver</button>   
                  <?php  } ?>
                  </div>
                                                            
                                                        </div>
                                                         <?php } ?>
                                                      <?php }   ?>
                                                    <!-- end ul list -->
                                                     
                                                </div>
                                            </div>
                                                    
                                                </tbody><!-- end tbody -->
                                            </table><!-- end table -->
                                            </div>
                                </div>
                            </div>
                   </div>
                    <?php } ?>
                    </div>     
                        
                     <div class="row">
                       <div class="col-xxl-6 col-lg-7 col-md-12 col-sm-12">
                                <div class="card h-100">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1 text-black">Balance Overview</h4>
                                        <div class="flex-shrink-0">
                                            <div class="dropdown card-header-dropdown">
                                                <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="fw-semibold text-uppercase fs-12">Sort by: </span><span class="text-black">Current Year<i class="mdi mdi-chevron-down ms-1"></i></span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="#">Today</a>
                                                    <a class="dropdown-item" href="#">Last Week</a>
                                                    <a class="dropdown-item" href="#">Last Month</a>
                                                    <a class="dropdown-item" href="#">Current Year</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- end card header -->
                                    <div class="card-body px-0">
                                       

                                        <div id="budget-expenses-charts" data-colors='["--vz-success", "--vz-danger"]' class="apex-charts" dir="ltr"></div>
                                    </div>
                                </div><!-- end card -->
                            </div>
                      <div class="col-xxl-6 col-lg-5 col-md-12 col-sm-12"> 
                                        <div class="card h-100">
                                            <div class="card-header align-items-center d-flex">
                                                <h4 class="card-title mb-0 flex-grow-1 text-black">Focus Suppliers - Weekly</h4>
                                                <div class="flex-shrink-0">
                                               
                                                </div>
                                            </div><!-- end card header -->

                                            <div class="card-body">
                                                <div class="table-responsive table-card">
                                                    <table class="table table-bordered table-centered align-middle table-nowrap mb-0">
                                                        <thead class="text-muted table-light">
                                                            <tr>
                                                                <th scope="col">Supplier Name</th>
                                                                <th scope="col">Budget</th>
                                                                <th scope="col">Spent</th>
                                                                <th scope="col">Remaining</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if(isset($topFiveSuppliers) && !empty($topFiveSuppliers)) {  ?>
                                                            <?php foreach($topFiveSuppliers as $tf) { ?>
                                                            <tr>
    <td>
        <a href="#" class="fw-medium link-primary"><?php echo $tf['supplier_name'] ?></a>
    </td>
    <td>
        <span class="text-black"><?php echo '$' . number_format($tf['weeklyBudget'], 2, '.', ','); ?></span>
    </td>
    <td><?php echo '$' . number_format($tf['totalOrder'], 2, '.', ','); ?></td>
    <td>
        <?php $remaining  =  $tf['weeklyBudget'] - $tf['totalOrder']; ?>
        <span class="badge bg-success-subtle text-success"><?php echo '$' . number_format($remaining, 2, '.', ','); ?></span>
    </td>
</tr>

                                                            
                                                            <?php } ?>
                                                            <?php } ?>
                                                           
                                                        </tbody><!-- end tbody -->
                                                    </table><!-- end table -->
                                                </div>
                                            </div>
                                        </div> <!-- .card-->
                                    </div>
                     </div>
                        <!--    <div class="row">-->
                        <!--         <div class="col-xxl-4 col-lg-4 h-90">-->
                        <!--    <div class="card">-->
                        <!--        <div class="card-header">-->
                        <!--            <h4 class="card-title mb-0 text-black">Budget Info</h4>-->
                        <!--        </div>-->
                        <!--        <div class="card-body">-->
                        <!--            <div id="chart-doughnut" data-colors='["--vz-primary", "--vz-success",  "--vz-danger"]' class="e-charts"></div>-->
                        <!--        </div>-->
                        <!--    </div>-->
                            <!-- end card -->
                        <!--</div>  -->
                        <!--        </div>-->
                            </div> <!-- end .h-100-->

                        </div> <!-- end col -->

                      
                    </div>

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
          
        </div>
        
        <div id="orderAttachmentInfoModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="myModalLabel">Attachments and Comments</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form id="attachmentUploadForm" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                        <div class="file-input-container">
                                                       <input type="file" id="userfile" name="userfile[]" class="form-control-file" multiple>
                                                        </div>
                                                        <input type="text" class="form-control mt-2" name="orderAttachmentComments" placeholder="Comments (Examples: any thing related to this product or order)" />
                                                        <input type="hidden" id="subLocationId" name="subLocationId" value="">
                                                        </div>
                                                      </form>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-success uploadAttachmentButton">Upload</button>
                                                        </div>

                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div>                         
                                            
         <script src="/theme-assets/libs/echarts/echarts.min.js"></script>
          <script src="/theme-assets/js/pages/echarts.init.js"></script>
          <script>
          
          // Balance Overview charts this is not echart, this is apex chart
let budgetExpensesChartsColors = getChartColorsArray("budget-expenses-charts");
let monthlyBudgets = <?php echo json_encode($monthlyBudgets); ?>;
 monthlyBudgets = Object.values(monthlyBudgets);
let monthlySpent = <?php echo json_encode($monthlySpentForGraph); ?>;
 monthlySpent = Object.values(monthlySpent);
 
if (budgetExpensesChartsColors) {
    var options = {
        series: [{
            name: 'Budget',
            data: monthlyBudgets
        }, {
            name: 'Spent',
            data: monthlySpent
        }],
        chart: {
            height: 290,
            type: 'area',
            toolbar: 'false',
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth',
            width: 2,
        },
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        yaxis: {
            labels: {
                formatter: function (value) {
                    return "$" + value;
                }
            },
            tickAmount: 5,
            min: 0,
            max: 260
        },
        colors: budgetExpensesChartsColors,
        fill: {
            opacity: 0.06,
            colors: budgetExpensesChartsColors,
            type: 'solid'
        }
    };
    var chart = new ApexCharts(document.querySelector("#budget-expenses-charts"), options);
    chart.render();
}

function showAttachmentModal(subLocationId){
   
 $("#subLocationId").val(subLocationId);
 $("#orderAttachmentInfoModal").modal('show');
} 
$(".uploadAttachmentButton").on("click", function () {
        var formData = new FormData($("#attachmentUploadForm")[0]);
        $(".uploadAttachmentButton").html("Loading...");
        // Debugging: Output FormData object to console
        console.log(formData);

        $.ajax({
            type: "POST",
            url: "/Supplier/internalorder/uploadOrderAttachment", 
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                $("#orderAttachmentInfoModal").modal('hide');
                $(".uploadAttachmentButton").html("Upload");
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });
    
    function markdelivered(obj,subLocId){
             
               $(obj).html('<i class="bx bx-bowl-rice"></i> In Progress...');
               $(obj).removeClass('btn-orange').addClass('btn-success');
             let temp =  $(obj).parents(".subLocList").find(".temp").val();
              let driversComment =  $(obj).parents(".subLocList").find(".comments").val(); 
              if(temp =='' || driversComment ==''){
                  alert("Enter tempearture and comments");
                  return false;
              }
             
                $.ajax({
                url: "/Supplier/internalorder/markdelivered",
                type: "POST",
                data: {
                subLocId: subLocId,
                temp: temp,
                driversComment: driversComment
                 },
                success: function(response) {
                  $(obj).html('<i class="bx bxs-truck"></i> Delivered');
                },
                error: function() {
        
                    console.log("Error updating order");
                }
            });
            }   

          </script>
         