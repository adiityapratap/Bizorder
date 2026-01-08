
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">

    <div class="page-content">
                
    <div class="container-fluid">
     <div class="row">
        <div class="col-lg-12">
            <div class="page-content-inner">
                <div class="card" id="userList">
                    <div class="card-header border-bottom-dashed">

                        <div class="row g-4 align-items-center">
                            <div class="col-sm">
                                <div>
                                    <h5 class="card-title mb-0 text-black"> Suites Configuration</h5>
                                </div>
                            </div>
                            <div class="col-sm-auto">
                                <div>
                                <a class="btn btn-success add-btn btn-sm" href="<?php echo base_url('Orderportal/Hospitalconfig/addBed') ?>"><i class="ri-add-line align-bottom me-1"></i> Add Suite </a>
                                  
                                  <a class="btn btn-success add-btn btn-sm" href="<?php echo base_url('Orderportal/Hospitalconfig/addClient') ?>"><i class="ri-add-line align-bottom me-1"></i> Onboard New Client </a>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body border-bottom-dashed border-bottom">
                        <form id="bed_filters">
                            <div class="row g-3">
                                 <div class="col-xl-2">
                                     <input class="form-control " id="bed_no" type="text" placeholder="Suite Number">
                                </div>
                                
                                <div class="col-xl-2">
                                     <input class="form-control " id="ward_no" type="text" placeholder="Ward Number">
                                </div>
                                <!--end col-->
                               
                                <!--end col-->
                                <div class="col-xl-2">
                                 <select class="form-select" name="floor"  id="floor" required> 
							     <option value="">-- Select Floor --</option>
							     <?php if(isset($floorLists) && !empty($floorLists)) {  ?>
							    <?php foreach($floorLists as $floorList){   	  ?>
							    <option value="<?php echo $floorList['name']; ?>"><?php echo $floorList['name']; ?></option>
							     <?php } } ?>
							</select>
                                </div>
                               
                                
                            </div>
                            <!--end row-->
                        </form>
                    </div>
                   
                    <div class="card-body">
                        <div>
                            <div class="table-responsive table-card mb-1">
                                
                                <table class="table align-middle" id="bedTable">
                                    <thead class="table-dark text-white">
                                        <tr>
                                            <th class="sort" data-sort="fname">Suite Number</th>
                                            <th class="sort" data-sort="email">Ward Number</th>
                                           <th class="sort" data-sort="phone">Floor</th>
                                            <!--<th class="sort" data-sort="status">Status</th>-->
                                            <th width="120">Action</th>
                                        </tr>
                                    </thead>
                                    <?php $i = 0; if(!empty($bedLists)){ ?>
                                    <tbody class="list form-check-all" id="formRow">
                                        <?php foreach($bedLists as $bedList){ ?>
                                        <?php $floor = array_filter($floorLists, function ($floor) use ($bedList) {
                                            return $floor['id'] == $bedList['floor'];
                                                });
                                           
                                          $floorName = !empty($floor) ? reset($floor)['name'] : '';
                                          ?>
                                        <tr id="row_<?php echo  $bedList['id']; ?>">
                                           <td class="bed_no"><?php echo $bedList['bed_no'] ?></td>
                                           <td class="ward_no"><?php echo $bedList['ward_no'] ?></td>
                                           <td class="floor"><?php echo $floorName ?></td>
                                         
                                        
                                         <td>
                                            <div class="d-flex gap-2">
                                            <div class="edit">
                                            <a href="<?php echo base_url('Orderportal/Hospitalconfig/editBed/'.$bedList['id']); ?>" class="btn btn-sm btn-secondary edit-item-btn">
                                            <i class="ri-edit-box-line label-icon align-middle fs-12 me-2"></i>View/Edit</a>
                                           </div>
                                          <div class="remove">
                                          <button class="btn btn-sm btn-danger remove-item-btn "  data-rel-id="<?php echo  $bedList['id']; ?>">
                                           <i class="ri-delete-bin-line label-icon align-middle fs-12 me-2"></i>Remove</button>
                                           </div>
                                          </div>
                                         </td>
                                         
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                    <?php } ?>
                                </table>
                                
                                
                               
                            </div>
                       
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

$(document).ready(function () {
    // When any input field changes, filter the table
   
     $('#bed_filters input, #bed_filters select').on('keyup change', function () {
        filterTable();
    });

    function filterTable() {
        // Get filter input values
        let bed_no = $('#bed_no').val().toLowerCase();
        let ward_no = $('#ward_no').val().toLowerCase();
        let floor = $('#floor').val().toLowerCase();

        // Loop through all table rows to filter based on inputs
        $('#bedTable tbody tr').each(function () {
            let row = $(this);
            let rowbedno = row.find('.bed_no').text().toLowerCase();
            let rowwardno = row.find('.ward_no').text().toLowerCase();
            let rowfloor = row.find('.floor').text().toLowerCase();

            // Check if the row matches the filters
            if (
                rowbedno.includes(bed_no) &&
                rowwardno.includes(ward_no) &&
                rowfloor.includes(floor)
            ) {
                row.show(); // Show matching row
            } else {
                row.hide(); // Hide non-matching row
            }
        });
    }
});




 $(document).on("click", ".remove-item-btn" , function() {
                let id = $(this).attr('data-rel-id');
               
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
                            url: '<?php echo base_url("Orderportal/Hospitalconfig/deleteBed"); ?>',
                            data: 'id='+id,
                            success: function(data){
                              $('#row_'+id).remove();
                            }
                        });
                      }
                  })
                
                
            });



</script> 
