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
     <div class="row">
        <div class="col-lg-12">
            <div class="page-content-inner">
                <div class="card" id="userList">
                 <?php if(isset($patientDetails['id'])){  ?>    
                    <form action="<?php echo base_url('Orderportal/Patient/updatePatient') ?>" id="patient_add" method="post" class="form-horizontal" >
                        <?php }else{ ?>
                    <form action="<?php echo base_url('Orderportal/Patient/submitPatient') ?>" id="patient_add" method="post" class="form-horizontal" > 
                      <?php } ?>    
                    <div class="card-header border-bottom-dashed">

                        <div class="row g-4 align-items-center">
                            <div class="col-sm ">
                                <div>
                                    <h5 class="card-title mb-0 text-black">
                                      Add/Update New Patient
                                    </h5>
                                </div>
                            </div>
                            <div class="col-sm-auto">
                                <div>
                    <a class="btn btn-danger add-btn" href="<?php echo base_url('Orderportal/Patient/List') ?>"><i class="mdi mdi-reply align-bottom me-1"></i> Back</a>
                                    
                   <?php if(isset($patientDetails['id'])){  ?>
                    <input type="hidden" class="form-control" name="patientId" value="<?php echo $patientDetails['id']; ?>" >
                    <input type="submit" class="btn btn-success" value="Update Patient">
                    <?php }else{ ?>
                    <input type="submit" class="btn btn-success" value="Submit Patient">
                     <?php } ?>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <div>
        <?php if(null !==$this->session->userdata('sucess_msg')) { ?>  
        <div class='hideMe'>
          <p class="alert alert-success"><?php echo $this->session->flashdata('sucess_msg'); ?></p>
        </div>
        <?php } ?>
        <?php if(null !==$this->session->userdata('error_msg')) { ?>  
        <div class='hideMe'>
          <p class="alert alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
        </div>
        <?php } ?>
                        </div>
                    </div>
                    <div class="card-body">
                        
                  <div class="row">
                     <div class="col-12 col-md-3 col-lg-2 mb-2">
                        <label>First Name :<span>*</span></label>
                        <input type="text" class="form-control" required name="fname"  autocomplete="off" value="<?php echo ($patientDetails['fname'] !='' ? $patientDetails['fname'] : '') ?>" >
                    </div>
                    
                    <div class="col-12 col-md-3 col-lg-2 mb-2">
                        <label>Last Name :<span>*</span></label>
                        <input type="text" class="form-control" required name="lname"  autocomplete="off" value="<?php echo ($patientDetails['lname'] !='' ? $patientDetails['lname'] : '') ?>" >
                    </div>
                    
                    <div class="col-12 col-md-3 col-lg-2 mb-2">
                        <label>Email :<span>*</span></label>
                        <input type="text" class="form-control" required name="email"  autocomplete="off" value="<?php echo ($patientDetails['email'] !='' ? $patientDetails['email'] : '') ?>" >
                    </div>
                    
                    
                    <div class="col-12 col-md-3 col-lg-2 mb-2">
                        <label>Phone :<span>*</span></label>
                        <input type="text" class="form-control" required name="phone"  autocomplete="off" value="<?php echo ($patientDetails['phone'] !='' ? $patientDetails['phone'] : '') ?>" >
                    </div>
                    
                    <div class="col-12 col-md-3 col-lg-2 mb-2">
                        <label>Daily Budget Limit :<span>*</span></label>
                        <input type="text" class="form-control" required name="daily_budget_limit"  autocomplete="off" value="<?php echo ($patientDetails['daily_budget_limit'] !='' ? $patientDetails['daily_budget_limit'] : '') ?>" >
                    </div>
                    
                     <div class="col-12 col-md-3 col-lg-2 mb-2">
                        <label>Ward No :<span>*</span></label>
                        <input type="text" class="form-control" required name="ward_no"  autocomplete="off" value="<?php echo ($patientDetails['ward_no'] !='' ? $patientDetails['ward_no'] : '') ?>" >
                    </div>
                    
                    
                  <div class="col-12 col-md-3 col-lg-2 mb-2"> 
                         <label>Floor :<span>*</span></label>
                            <select class="form-select" name="floor" >
							     <option value="">-- Select Floor --</option>
							    <?php foreach($floorLists as $floor){   ?>	  
							   <option value="<?php echo $floor['id']; ?>" <?php echo (isset($patientDetails['floor']) && $patientDetails['floor'] == $floor['id'] ? 'selected' : '') ?> ><?php echo $floor['name']; ?></option>
							    <?php }  ?>
							</select>
                    </div>
                    
                    <div class="col-12 col-md-3 col-lg-2 mb-2"> 
                         <label>Department :<span>*</span></label>
                            <select class="form-select" name="department"  required> 
							     <option value="">-- Select Department --</option>
							     
							    <?php foreach($departments as $department){   	  
							    if($department['id'] == $patientDetails['department']){ ?>
							        <option value="<?php echo $department['id']; ?>" selected><?php echo $department['name']; ?></option>
							    <?php }else{ ?>
							        <option value="<?php echo $department['id']; ?>"><?php echo $department['name']; ?></option>
							    <?php } } ?>
							</select>
                    </div>
                     
                   
                    
                    
                    
                    
                  <div class="col-12 col-md-3 col-lg-2 mb-2">
                        <label>Dietry Restrictions :<span>*</span></label>
                        <textarea  class="form-control" required name="dietry_req"  autocomplete="off" ><?php echo ($patientDetails['dietry_req'] !='' ? $patientDetails['dietry_req'] : '') ?></textarea>
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
	$(document).ready(function() { 
	    $("#patient_add").validate({
	      	ignore: "input[type='text']:hidden",
		    rules: {
			fname: {
	                required:true
	            },
	        lname: {
	                required:true
	            }, 
	        email: {
	        	required:true
            },
            phone: {
	        	required:true
            },
            department: {
	        	required:true
            },
	      
			},		
			messages: {
			fname: {
	                required:"Please provide the Patient Name"
	            },
	        email: {
	                required:"Please provide the Patient Email"
	            },    
	        phone: {
                 required:"Please provide the Patient Phone"
                 },
	        department: {
	               required:"Please select the department name"
	            },
	       // large: {
	       //       required:"Please Provide the large value"
	       //     }   
			}

	    });	
	});
	
	

    
</script>