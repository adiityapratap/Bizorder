<style>
input[type=checkbox], input[type=radio] {
    margin: 9px 10px 9px 0;
}
</style>
<div class="main-content">

    <div class="page-content">
                
   <div class="container">
    <div class="card shadow rounded">
        <div class="card-header bg-primary text-white rounded-top">
            <h5 class="mb-0">Add/Update New Suite</h5>
            <p class="mb-0 small">Fill in the details to add or update a suite</p>
        </div>

        <?php if(isset($bedDetails['id'])){ ?>    
        <form action="<?php echo base_url('Orderportal/Hospitalconfig/updateBed') ?>" id="bed_add" method="post">
        <?php } else { ?>
        <form action="<?php echo base_url('Orderportal/Hospitalconfig/submitBed') ?>" id="bed_add" method="post">
        <?php } ?>

        <div class="card-body">
            <div class="row g-3">

                <!-- Name -->
                <div class="col-md-6">
                    <label class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="clientName" required value="<?php echo ($bedDetails['clientName'] ?? '') ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Suite Number <span class="text-danger">*</span></label>
                    <select class="form-select" name="bed_no" required>
                        <option value="">Select allergies</option>
                        <?php foreach($suites as $suite): ?>
                            <option value="<?php echo $suite['id']; ?>" <?php echo ($bedDetails['allergy'] == $suite['id']) ? 'selected' : ''; ?>>
                                <?php echo $suite['name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                

                <!-- Ward Number -->
                <div class="col-md-6">
                    <label class="form-label">Ward No</label>
                    <input type="text" class="form-control" name="ward_no" value="<?php echo ($bedDetails['ward_no'] ?? '') ?>">
                </div>

                <!-- Allergies -->
                <div class="col-md-6">
                    <label class="form-label">Allergies <span class="text-danger">*</span></label>
                    <select class="form-select" name="allergy" required>
                        <option value="">Select allergies</option>
                        <?php foreach($allergyLists as $allergy): ?>
                            <option value="<?php echo $allergy['id']; ?>" <?php echo ($bedDetails['allergy'] == $allergy['id']) ? 'selected' : ''; ?>>
                                <?php echo $allergy['name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Floor -->
                <div class="col-md-6">
                    <label class="form-label">Floor <span class="text-danger">*</span></label>
                    <select class="form-select" name="floor" required>
                        <option value="">Select floor</option>
                        <?php foreach($floorLists as $floor): ?>
                            <option value="<?php echo $floor['id']; ?>" <?php echo ($bedDetails['floor'] == $floor['id']) ? 'selected' : ''; ?>>
                                <?php echo $floor['name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Date Onboarded -->
                <div class="col-md-6">
                    <label class="form-label">Date Onboarded</label>
                    <div class="input-group">
                        <input type="text" class="form-control flatpickr" name="onboardingDate" value="<?php echo ($bedDetails['onboardingDate'] ?? '') ?>" readonly>
                        <span class="input-group-text bg-primary text-white"><i class="ri-calendar-2-line"></i></span>
                    </div>
                </div>

                <!-- Date of Discharge -->
                <div class="col-md-6">
                    <label class="form-label">Date of Discharge</label>
                    <div class="input-group">
                        <input type="text" class="form-control flatpickr" name="dischargeDate" value="<?php echo ($bedDetails['dischargeDate'] ?? '') ?>" readonly>
                        <span class="input-group-text bg-primary text-white"><i class="ri-calendar-2-line"></i></span>
                    </div>
                </div>

                <!-- Special Instructions -->
                <div class="col-12">
                    <label class="form-label">Special Instructions</label>
                    <textarea class="form-control" name="notes" rows="3"><?php echo ($bedDetails['notes'] ?? '') ?></textarea>
                </div>
            </div>
        </div>

        <div class="card-footer d-flex justify-content-between">
            <a href="<?php echo base_url('Orderportal/Hospitalconfig/List') ?>" class="btn btn-outline-danger">
                ← Back
            </a>

            <?php if(isset($bedDetails['id'])){ ?>
                <input type="hidden" name="bedId" value="<?php echo $bedDetails['id']; ?>">
                <button type="submit" class="btn btn-success">Update</button>
            <?php } else { ?>
                <button type="submit" class="btn btn-success">Submit ✔</button>
            <?php } ?>
        </div>

        </form>
    </div>
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
        // Initialize Flatpickr for onboarding and discharge dates
        flatpickr(".flatpickr", {
            defaultDate: new Date(), 
            dateFormat: "d M, Y",
            minDate: "today"  // Restrict past dates for onboarding/discharge
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