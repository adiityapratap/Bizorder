<style>
#loading{
    
    position: absolute;
    z-index: 1000;
       top: 500px;
    left: 600px;
}
label {
    color: #000;
    font-weight: 500;
}
.headertitleNach {
    max-width: 370px;
}
.headertitleNach h2{
    color:#b31f2b;
    font-size:45px;
    font-weight:800;
    margin-bottom:0;
    font-family: 'Noto Sans', sans-serif;
}
.headertitleNach p{
    color:#b31f2b;
    font-size:16px;
    font-weight:600;
    margin-bottom:0;
    font-family: 'Lato', sans-serif;
}
.headertitleNach p.subHeading{
    color:#b31f2b;
    font-size: 20px;
    font-weight:700;
    line-height: 22px;
}
.blackHeader{
    background-color: black;
}
.bg_img_banner:before{
    display:none;
}
.bannerLogo{
    max-width: 110px;
}
/*.product_main_table tbody tr{*/
/*   background-color: #e46f6f;*/
/*}*/
.fs-22{
    font-size: 22px;
} 
.fs-12{
    font-size: 12px;
} 
.fw-700{
    font-weight: 700;
}
.required.error {
    border-color: #f00;
}
label span{
    color: #ff1515;
    font-weight: 700;
}
@media(max-width: 768px){
   .bannerLogo{
        max-width: 80px;
   }
   .headertitleNach {
        max-width: 316px;
    }
    .headertitleNach h2 {
        color: #b31f2b;
        font-size: 38px;
    }
    .headertitleNach p {
        font-size: 14px;
    }
    .headertitleNach p.subHeading {
        font-size: 16px;
        line-height: 15px;
    }
}
@media(max-width: 575px){
   .bannerLogo {
        max-width: 56px;
    }
    .headertitleNach {
        max-width: 210px;
    }
    .headertitleNach h2 {
        font-size: 26px;
    }
    .headertitleNach p {
        font-size: 9px;
    }
    .headertitleNach p.subHeading {
        font-size: 11px;
        line-height: 13px;
    }
}
@media(max-width: 415px){
    .bannerLogo {
        max-width: 52px;
    }
    .headertitleNach {
        max-width: 160px;
    }
    .headertitleNach h2 {
        font-size: 20px;
    }
    .headertitleNach p {
        font-size: 8px;
    }
    .headertitleNach p.subHeading {
        font-size: 9px;
        line-height: 12px;
    }

}
@media(max-width: 349px){
    .bannerLogo {
        max-width: 46px;
    }
    .headertitleNach {
    max-width: 128px;
}
    .headertitleNach h2 {
        font-size: 16px;
    }
    .headertitleNach p {
        font-size: 7px;
    }
    .headertitleNach p.subHeading {
        font-size: 8px;
        line-height: 10px;
    }

}
</style>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" ></script>
<div class="container_full bg_img_banner mt-5">
	<div class="content_wrapper">
		<div class="container-fluid">
			<!-- breadcrumb -->
			<!--<div class="page-heading">-->
			<!--	<div class="row d-flex align-items-center">-->
			<!--		<div class="col-md-6">-->
			<!--			<div class="page-breadcrumb">-->
			<!--				<h1>Request an offer</h1>-->
			<!--			</div>-->
			<!--		</div>-->
			<!--		<div class="col-md-6 justify-content-md-end d-md-flex">-->
			<!--			<div class="breadcrumb_nav">-->
			<!--				<ol class="breadcrumb">-->
			<!--					<li>-->
			<!--						<i class="fa fa-home"></i>-->
			<!--						<a class="parent-item" href="#!">Offer</a>-->
			<!--						<i class="fa fa-angle-right"></i>-->
			<!--					</li>-->
			<!--					<li class="active">-->
			<!--						New Offer-->
			<!--					</li>-->
			<!--				</ol>-->
			<!--			</div>-->
			<!--		</div>-->
			<!--	</div>-->
			<!--</div>-->
			<!-- breadcrumb_End -->

			<!-- Section -->
			<div class="container-fluid">
				<form action="<?php echo base_url();?>index.php/orders/save_new_quote" method="POST" id="offer_request_form">
				    <div class="mt-3 px-4 blackHeader">
				        <div class="row py-2">
				            <div class="col-auto"><img src="<?php echo base_url();?>assets/images/logo-png.png" alt="" class="bannerLogo"></div>
				            <div class="col-8">
				                <div class="headertitleNach">
				                    <h2 class="text-end">NACH FOOD CO.</h2>
				                    <p class="text-end subHeading">Supplying Premium Meats</p>
				                    <p class="text-end">to the Food Service Industry</p>
				                </div>
				            </div>
				        </div>
			           
			        </div>
			        
					<div class="row mb-4">
						<!--Report widget start-->
						
							<div class="col-12">
								<div class="card card-shadow">
									<div class="card-header">
									     <div class="row ">
									        <div class="col-lg-12">
									           <h2 class="text-center fs-22 fw-700">Request for Offer</h2>
									           
							                </div>
						                </div>
							        </div>
							        <div class="card-header">
									     <div class="row ">
									        <div class="col-lg-12">
									            
									           <div>
									               <span>NACH FOOD CO PTY LTD</span><br />
									               <span>47-53 CHIFLEY DRIVE</span><br />
									               <span>PRESTON VIC 3072</span><br />
									               <span>PH: 94714411</span><br />
									               <span>EM: info@nachfoodco.com.au</span>
									           </div>
							                </div>
						                </div>
							        </div>
									<div class="card-body">
									    
									     
									                
								        <div class="row">
								            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 mt-3 ">
								                <label>Reference number</label>
								                <input type="text" class="form-control" id="reference_number" name="reference_number" >
								            </div>
								            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 mt-3 ">
								                <label>Supplier <span>*</span></label>
								                <select class="form-control required" id="supplier" name="supplier" required>
											        <option value="">Select Supplier</option>
											        <option value="add_supplier">+ Add New Supplier</option>
										        	<?php if(!empty($suppliers)){
        												foreach($suppliers as $supplier){
        													echo "<option value=\"".$supplier->supplier_id."\">".ucwords($supplier->supplier_name)."</option>";
        												}
        											}?>
											    </select>
								            </div>
								            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 mt-3 supplier_address_wrap" style="display:none;">
								                <label>Supplier Email Address</label>
								                <input type="text" class="form-control" name="supplier_email_address" id="supplier_address">
								            </div>
								            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 mt-3 ">
								                <label>Date</label>
								                <input type="text" class="form-control datepicker" name="date" id="date" value="<?php echo date('d-m-Y'); ?>">
								            </div>
								        </div>
								        
								        <div class="table-responsive mt-4">
											<table class="table table-striped table-sm product_table product_main_table">
												<thead>
													<tr>
														<th>Product Name/Description </th>
														<th>Volume/KG</th>
														<th>Category</th>
														<th>Comment</th>
														<th>Price</th>
														<th></th>
													</tr>
												</thead>
												<tbody>
												    <tr class="productRow">
												        <td><input type="text" class="form-control product_name" name="product_name[]" ></td>
												        <td><input type="text" class="form-control product_volume" name="product_volume[]" ></td>
												        <td>
												            	<select class="form-control" name="category[]" id="category">
												            	    <option value="">Select</option>
                        											<?php if(!empty($categories)){
                        												foreach($categories as $cat){
                        												    if($cat->category_id != '' && $cat->category_name != ''){
                        													    echo "<option value=\"".$cat->category_id."\">".ucwords($cat->category_name)."</option>";
                        												    }
                        												}
                        											}?>
                        										
                        										</select>
												        </td>
												        <td><input type="text" class="form-control product_comment" name="product_comment[]" ></td>
												        <td width="200px">
												            <div class="input-group">
                    											<span class="input-group-addon">$</span>
                    											<input type="text" class="form-control" name="amount[]" readonly>
                    										</div>
												        </td>
												        <td width="170px"><div class="add_btns"><a href="javascript:void(0)" class="btn add_field_button" style="background-color:#16b708;color:#fff;">+</a></div></td>
												    </tr>
												</tbody>
											</table>
										</div>
								        
								        <div class="row">
								            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 mt-3 ">
								                <label>SHIPMENT TERMS <span>*</span></label>
								                <input type="text" class="form-control required" id="fob_fas" name="fob_fas" required>
								                    
								            </div> 
								            
								           
								             
								            <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 mt-3 ">
								                <label>Market <span>*</span></label>
								                <div class="table-responsive">
        											<table class="table table-striped table-sm product_table">
        												<tbody>
    												        <tr class="productRow">
    												            <td> <input type="text" class="form-control required" id="market" name="market[]" required></td>
    												            <td width="130px"><div class="add_btns"><a href="javascript:void(0)" class="btn add_field_button" style="background-color:#16b708;color:#fff;">+</a></div></td>
    												        </tr>
    												    </tbody>
    												</table>
												</div>
								                
								               
								                    
								            </div> 
								            </div>
								            <div class="row">
								                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 mt-3 ">
    								                <label>SHIPMENT PERIOD</label>
    								                <input type="text" class="form-control" id="shipment_period" name="shipment_period" >
    								                    
    								            </div> 
								                 <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 mt-3 ">
    								                <label>Container Size  </label>
    								                <select class="form-control" id="container_size" name="container_size">
    								                    <option value="">Select</option>
    								                    <option value="Sea">Sea</option>
    								                    <option value="Air">Air</option>
    								                </select>
    								                    
    								            </div> 
    								            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 mt-3 supply_qty_wrap" style="display:none;">
    								                <label>Supply QTY </label>
    								                <select class="form-control" id="container_supply_qty" name="container_supply_qty">
    								                    <option value="">Select</option>
    								                    <option value="20">20</option>
    								                    <option value="40">40</option>
    								                </select>
    								                    
    								            </div> 
    								            
    								            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 mt-3 qty_wrap" style="display:none;">
    								                <label>QTY </label>
    								                <select class="form-control" id="container_qty" name="container_qty">
    								                    <option value="">Select</option>
    								                    <option value="1">1</option>
    								                    <option value="2">2</option>
    								                    <option value="3">3</option>
    								                </select>
    								                    
    								            </div>
								            </div>
								            <div class="row">
								                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 mt-3 ">
    								                <label>PAYMENT TERMS </label>
    								                <input type="text" class="form-control" id="payment_terms" name="payment_terms" >
    								                    
    								            </div>
    								            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 mt-3 ">
    								                <label>Marks <span>*</span></label>
    								                <select class="form-control required" id="marks" name="marks" required>
    								                    <option value="">Select</option>
    								                    <option value="Frozen">Frozen</option>
    								                    <option value="Chilled">Chilled</option>
    								                </select>
    								            </div>
								            </div>
								           <div class="row">
								            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mt-3 ">
								                <label>PORT OF LOADING </label>
								                <input type="text" class="form-control" id="port_loading" name="port_loading" >
								            </div>
								            </div>
								           <div class="row">
								            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mt-3">
								                <label>PORT OF DISCHARGE </label>
								                <input type="text" class="form-control" name="port_discharge" id="port_discharge">
								            </div>
								            </div>
								           <div class="row">
								            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mt-3 ">
								                <label>FINAL DESTINATION </label>
								                <input type="text" class="form-control" name="final_destination" id="final_destination">
								            </div>
								           </div>
								          
								             
								             <div class="row ">
									        <div class="col-lg-12 mt-3">
									            <label>Requirement Box</label>
									            <textarea class="form-control" style="height:150px" >
• FROZEN PRODUCTS
• HALAL CERTIFIED
• INSERT ALL LABELS
• PRODUCTS SHOULD BE ELIGIBLE FOR ENTRY INTO ---------
• RFP, INTERIM HALAL AND LOAD OUT DOCS TO BE EMAILED TO NACH FOOD CO PTY LTD (EXPORTER NO: 3518 AND EDI NO:2145) at email address: info@nachfoodco.com.au</textarea>
									        </div>
									        <div class="col-lg-12 mt-3">
									            <label>Comments</label>
									            <textarea class="form-control" name="comments" style="height:100px" ></textarea>
									        </div>
									    </div>
								             
								              <div class="row ">
								            
								            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 mt-3 ">
								                <label>Customer Name </label>
								                <input type="text" class="form-control" id="customer_name" name="customer_name">
								                    
								            </div> 
								          
								            <div class="col-xl-2 col-lg-3 col-md-3 col-sm-12 mt-3 ">
								                <label>Request Number</label>
								                <input type="text" class="form-control" id="request_number" name="request_number" >
								            </div>
								            
								             </div>
								       
										
									    <div class="text-end mt-3"><button type="submit" class="btn btn-info submit-button" onclick="validation()">Save and Close</button></div>
									</div>
								</div>
							</div>
							<!--Report widget end-->
						</div>
				
							</form>
						</div>
						<!-- Section_End -->
					</div>
				</div>
			</div>
			<!-- Content_right_End -->
<script>
function validation() {
    $('.customAlert').remove();
    $('.required').removeClass('error');
    $( ".required" ).each(function( index ) {
      if($( this ).val() == ''){
          $(this).addClass('error');
          $('<span class="customAlert text-danger fw-700 fs-12">Field is Mandatory.</span>').insertAfter(this);
         
      }else{
         
      }
    });
}
    $(document).on("change", ".error" , function() {
        if($(this).val() != ''){
            $('.customAlert').remove();
            $('.required').removeClass('error');
        }
    });
    $(document).on("change", "#container_size" , function() {
        var supplierval = $(this).val();
        if(supplierval == 'Sea'){
            $('.qty_wrap').css('display','none');
            $('.supply_qty_wrap').css('display','block');
        }else if(supplierval == 'Air'){
            $('.supply_qty_wrap').css('display','none');
            $('.qty_wrap').css('display','block');
        }else{
            $('.supply_qty_wrap').css('display','none');
            $('.qty_wrap').css('display','none');
        }
    });
    $(document).on("change", "#supplier" , function() {
        var supplierval = $(this).val();
        if(supplierval == 'add_supplier'){
            $(this).val('');
            jQuery.getScript('https://cdn.jsdelivr.net/npm/sweetalert2@11', function() {
            Swal.fire({
                title: "Add New Supplier",
                html: '<div class="mt-3 text-start"><label for="input-supplier" class="form-label fs-13">Supplier Name</label><input type="text" class="form-control" id="input-supplier" placeholder="Enter Supplier Name"></div><div class="mt-3 text-start"><label for="input-supplier-address" class="form-label fs-13">Supplier Email Address</label><input type="text" class="form-control" id="input-supplier-address" placeholder="Enter Supplier Email Address"></div>',
                confirmButtonClass: "btn btn-primary w-xs mb-2",
                confirmButtonText: 'Create',
                buttonsStyling: !1,
                showCloseButton: !0,
            }).then(function (t) {
                if (t.value) {
                    var supplierNameval = $('#input-supplier').val(); 
                    var supplierAddressval = $('#input-supplier-address').val(); 
                    console.log(supplierNameval); 
                    $.ajax({
                        url:"<?php echo base_url();?>index.php/orders/saveSupplier", 
                		method:"POST", 
                		data:{supplierNameval:supplierNameval,supplierAddressval:supplierAddressval},
                	    success:function(resp){
	                        
                            if(resp != 'error'){
                               $('#supplier').append('<option value="'+resp+'" selected>'+supplierNameval+'</option>');
                               $('#supplier_address').val(supplierAddressval);
                               $('.supplier_address_wrap').css('display','block');
                                Swal.fire({ title: "Supplier Saved!", icon: "success", confirmButtonClass: "btn btn-primary w-xs", buttonsStyling: !1 }); 
                            }else{
                                Swal.fire({ title: "Supplier not saved", icon: "info", confirmButtonClass: "btn btn-primary w-xs", buttonsStyling: !1 });
                            }
                            
                	    }
                    });
                }
            });
        
            });    
            }else{
                $.ajax({
                    url:"<?php echo base_url();?>index.php/orders/fetch_suppliers", 
            		method:"POST", 
            		data:{supplierval:supplierval},
            	    success:function(resp){
            	        if(resp != 'error'){
            	            data=JSON.parse(resp);
                               $('#supplier_address').val(data[0].email_address);
                               $('.supplier_address_wrap').css('display','block');
            	        }
            	    }
                });
            }
    });
    
    
    // add new row
     var table = $( '.product_table' );
       $( table ).delegate( '.add_field_button', 'click', function () {
    var thisRow = $( this ).closest( '.productRow' );
    
    $( thisRow ).clone().insertAfter( thisRow ).find( 'input:text' ).val( '' );
    var thisRowAddbtn = $( thisRow ).next('.productRow').find( '.add_field_button' );
    if (!$(thisRow).has(".remove_field_button").length) {
   $('<a href="javascript:void(0)" class="btn remove_field_button" style="background-color:#ff5426;color:#fff;margin-left:5px;">-</a>').insertAfter(thisRowAddbtn);
    } 
    });
    $( table ).delegate( '.remove_field_button', 'click', function () {
        $( this ).closest( '.productRow' ).remove();
    });
</script>	

