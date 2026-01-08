<style>
input[type=checkbox], input[type=radio] {
    margin: 9px 10px 9px 0;
}
</style>
<div class="main-content">

    <div class="page-content">
                
    <div class="container-fluid">
     <div class="row">
        <div class="col-lg-12">
            <div class="page-content-inner">
                <div class="card" id="userList">
                 <?php if(isset($bedDetails['id'])){  ?>    
                    <form action="<?php echo base_url('Orderportal/Hospitalconfig/updateSuite') ?>" id="bed_add" method="post" class="form-horizontal" >
                        <?php }else{ ?>
                    <form action="<?php echo base_url('Orderportal/Hospitalconfig/submitSuite') ?>" id="bed_add" method="post" class="form-horizontal" > 
                      <?php } ?>    
                    <div class="card-header border-bottom-dashed">

                        <div class="row g-4 align-items-center">
                            <div class="col-sm ">
                                <div>
                                    <h5 class="card-title mb-0 text-black">
                                      Add/Update New Suite
                                    </h5>
                                </div>
                            </div>
                            <div class="col-sm-auto">
                                <div>
                    <a class="btn btn-danger add-btn" href="<?php echo base_url('Orderportal/Hospitalconfig/List') ?>"><i class="mdi mdi-reply align-bottom me-1"></i> Back</a>
                                    
                   <?php if(isset($bedDetails['id'])){  ?>
                    <input type="hidden" class="form-control" name="bedId" value="<?php echo $bedDetails['id']; ?>" >
                    <input type="submit" class="btn btn-success" value="Update">
                    <?php }else{ ?>
                    <input type="submit" class="btn btn-success" value="Submit">
                     <?php } ?>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                    
                
                    <div class="card-body">
                        
                  <div class="row">
                   
                   <div class="col-12 col-md-3 col-lg-2 mb-2">
                        <label>Name :<span>*</span></label>
                        <input type="text" class="form-control" required name="clientName"  autocomplete="off" value="<?php echo ($bedDetails['clientName'] !='' ? $bedDetails['clientName'] : '') ?>" >
                    </div>
                    
                    <div class="col-12 col-md-3 col-lg-2 mb-2">
                        <label>Suite Number :<span>*</span></label>
                        <input type="text" class="form-control" required name="bed_no"  autocomplete="off" value="<?php echo ($bedDetails['bed_no'] !='' ? $bedDetails['bed_no'] : '') ?>" >
                    </div>
                    
                  
                    
                   
                    
                  
                    
                    <div class="col-12 col-md-3 col-lg-2 mb-2"> 
                         <label>Floor :<span>*</span></label>
                            <select class="form-select" name="floor"  required> 
							     <option value="">-- Select Floor --</option>
							     <?php if(isset($floorLists) && !empty($floorLists)) {  ?>
							    <?php foreach($floorLists as $floorList){   	  
							    if($floorList['id'] == $bedDetails['floor']){ ?>
							        <option value="<?php echo $floorList['id']; ?>" selected><?php echo $floorList['name']; ?></option>
							    <?php }else{ ?>
							        <option value="<?php echo $floorList['id']; ?>"><?php echo $floorList['name']; ?></option>
							    <?php } } ?>
							     <?php } ?>
							</select>
                    </div>
                     
                   
                
                      </div>
                 
                    </div>
                    </form>
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

document.addEventListener("DOMContentLoaded", function() {
        // Initialize Flatpickr with today's date
        const datePicker = document.getElementById('datePicker');
        flatpickr(datePicker, {
            defaultDate: new Date(), 
            dateFormat: "d M, Y",  
        });
    });
	$(document).ready(function() { 
	    $("#bed_add").validate({
	      	ignore: "input[type='text']:hidden",
		    rules: {
			bed_no: {
	                required:true
	            },
	        
	        
            floor: {
	        	required:true
            },
	      
			},		
			messages: {
			bed_no: {
	                required:"Please provide the Bed No"
	            },
	          
	        floor: {
                 required:"Please select the Floor"
                 }
	       // large: {
	       //       required:"Please Provide the large value"
	       //     }   
			}

	    });	
	});
	
	

    
</script>