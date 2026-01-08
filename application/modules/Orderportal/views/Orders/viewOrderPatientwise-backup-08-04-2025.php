<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<style>
input[type=checkbox], input[type=radio] {
    margin: 9px 10px 9px 0;
}
</style>
<div class="main-content">

    <div class="page-content">
                
    <div class="container-fluid">
         <h4 class="text-black"><?php echo  $department_name=  fetchDepartmentNameFromId($this->tenantDb, $deptId); ?></h4>
     <div class="row">
        <div class="col-lg-12">
            <div class="page-content-inner">
                <div class="card" id="userList">
                  
                    <div class="card-header border-bottom-dashed">

                       <div class="row g-4 align-items-center">
                            <div class="col-sm">
                                <div>
                                    <h5 class="card-title mb-0 text-black">Date : <?php echo date('d-m-Y',strtotime($date)); ?></h5>
                                </div>
                            </div>
                            <div class="col-sm-auto">
          <div class="flex-shrink-0 me-2">
           <a class="btn btn-danger btn-sm" onclick="window.history.back()">Go Back</a>
           <!--<a href="<?php echo base_url('Orderportal/Order/viewInvoice/'.$orderId); ?>" class="btn btn-success btn-sm"><i class="ri-download-2-fill align-middle me-1"></i>Download Invoice</a>-->
           <!--<a data-bs-toggle="modal" data-bs-target="#sendInvoiceModal" class="btn btn-danger btn-sm"><i class="bx bx-mail-send align-middle me-1"></i>Send Invoice</a>-->
        </div>
                            </div>
                        </div>
                    </div>
                    
                  
                   
                    
                    
                    <div class="card-body">
                        
                  <div class="row table-responsive">
                    
                   
                   <table class="table table-nowrap table-bordered table-striped mt-3">
                    <thead class="table-dark">
                        <tr>
                          
                          
                            <th>Bed No</th>
                            <?php if(isset($categoryListData) && !empty($categoryListData)) {  ?>
                            <?php foreach($categoryListData as $categoryList){ ?>
                            <th><?php echo $categoryList['name'] ?></th>
                             <?php }  } ?>
                            <th>Notes/Allergens</th>
                        
                        </tr>
                    </thead>
                    <tbody>
                        
                       
                        
                        
                         <?php if(isset($bedLists) && !empty($bedLists)) {  ?>
                        
                        <?php foreach($bedLists as $bedList){ ?>
                        
                        <tr>
                          <td><?php echo $bedList['bed_no']; ?><?php echo !empty($bedList['ward_no']) ? '<br>Ward No: ' . $bedList['ward_no'] : ''; ?></td>
                        <?php if(isset($categoryListData) && !empty($categoryListData)) {  ?>
                        <?php foreach($categoryListData as $categoryList){ ?>
                            <td>
                            <?php foreach($menuLists as $menu){ ?>
                            <?php if($menu['category'] == $categoryList['id']  && in_array($menu['id'], $savedMenus)) {  ?>
                            
                      <?php
                      $nameIndex = $bedList['id'] . '_' . $categoryList['id'];
                      if(isset($patientOrderData) && !empty($patientOrderData)){
                      $currentPatientOrderData = $patientOrderData[$nameIndex];
                      if (in_array($menu['id'], $currentPatientOrderData)){ $checked = 'checked';   }else{ $checked =''; }    
                      }else{
                       $checked ='';   
                      }
                      ?>   
                      <?php if($checked !='') {  ?>
     <div class="form-check form-check-success fs-12 <?php echo $nameIndex; ?>">
    <input class="form-check-input" type="checkbox" <?php echo $checked; ?> id="menu_<?php echo $bedList['id'].''.$menu['id']; ?>" value="<?php echo $menu['id']; ?>" name="<?php echo $nameIndex . '[]'; ?>">
    <label class="form-check-label" for="menu_<?php echo $bedList['id'].''.$menu['id']; ?>"> <?php echo $menu['name']; ?></label>
    </div>
    <?php }   ?>
                            <?php } }  ?>
                            </td>
                            
                        <?php }  } ?>
                             
                             
                          
                          
                              <td><textarea class="form-input" name="note_<?php echo $bedList['id']; ?>"><?php echo (isset($orderCommentBedWise[$bedList['id']]) ? $orderCommentBedWise[$bedList['id']] : '') ?></textarea></td>
                          
                        </tr>  
                        
                        <?php }  } ?>
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


<div class="modal fade" id="sendInvoiceModal" tabindex="-1" aria-labelledby="sendInvoiceModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalgridLabel">Send Invoice</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="javascript:void(0);">
                                                            <div class="row g-3">
                                                                <div class="">
                                                                    <label for="emailInput" class="form-label">Email</label>
                                                                    <input type="email" class="form-control" id="emailInput" placeholder="Enter email to send invoice to">
                                                                </div>
                                                             
                                                                <div class="col-lg-12">
                                                                    <div class="hstack gap-2 justify-content-end">
                                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                                        <a class="btn btn-success"><i class="ri-mail-check-line"></i> Send Email</a>
                                                                    </div>
                                                                </div>
                                                                <!--end col-->
                                                            </div>
                                                            <!--end row-->
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


<script type="text/javascript">

</script>