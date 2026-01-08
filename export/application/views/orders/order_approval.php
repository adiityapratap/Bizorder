<style>
#loading{
    
    position: absolute;
    z-index: 1000;
       top: 500px;
    left: 600px;
}
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

.fs-22{
    font-size: 22px;
} 
.fw-700{
    font-weight: 700;
}
select {
    appearance: none;
}
.form-control:disabled {
    background-color: #fbfbfb;
    opacity: 1;
}
.marketTable tr.productRow td {
    padding: 0 !important;
    padding-bottom: 5px !important;
    border-color: transparent !important;
}
.marketTable tr.productRow{
    border-color: transparent;
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
			<!--				<h1>New Quote</h1>-->
			<!--			</div>-->
			<!--		</div>-->
			<!--		<div class="col-md-6 justify-content-md-end d-md-flex">-->
			<!--			<div class="breadcrumb_nav">-->
			<!--				<ol class="breadcrumb">-->
			<!--					<li>-->
			<!--						<i class="fa fa-home"></i>-->
			<!--						<a class="parent-item" href="#!">Quote</a>-->
			<!--						<i class="fa fa-angle-right"></i>-->
			<!--					</li>-->
			<!--					<li class="active">-->
			<!--						New Quote-->
			<!--					</li>-->
			<!--				</ol>-->
			<!--			</div>-->
			<!--		</div>-->
			<!--	</div>-->
			<!--</div>-->
			<!-- breadcrumb_End -->

			<!-- Section -->
			<div class="container-fluid">
				<form action="<?php echo base_url();?>index.php/orders/update_new_quote" method="POST" id="new_order_form" novalidate>
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
									           <h3 class="text-center fs-22 fw-700">Request for Offer</h3>
									           
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
								                <input type="hidden" class="form-control" name="order_id" value="<?php echo $order_info[0]->order_id; ?>" >
								                <input disabled type="text" class="form-control" id="reference_number" name="reference_number" value="<?php echo $order_info[0]->reference_number; ?>" >
								            </div>
								            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 mt-3 ">
								                <label>Supplier</label>
								                <select disabled class="form-control" id="supplier" name="supplier" >
											        <option value=""></option>
										        	<?php if(!empty($suppliers)){
        												foreach($suppliers as $supplier){
        												    if($supplier->supplier_id == $order_info[0]->supplier){
        													    echo "<option value=\"".$supplier->supplier_id."\" selected>".ucwords($supplier->supplier_name)."</option>";
        												    }else{
        													    echo "<option value=\"".$supplier->supplier_id."\">".ucwords($supplier->supplier_name)."</option>";
        												    }
        												}
        											}?>
											    </select>
								            </div>
								            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 mt-3 supplier_address_wrap" >
								                <label>Supplier Email Address</label>
								                <input disabled type="text" class="form-control" name="supplier_address" id="supplier_address" value="<?php echo $order_info[0]->email_address; ?>">
								            </div>
								            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 mt-3 ">
								                <label>Date</label>
								                <input disabled type="text" class="form-control datepicker" name="date" id="date" value="<?php echo date("d-m-Y",strtotime($order_info[0]->order_date)); ?>" >
								            </div>
								        </div>
								        <div class="table-responsive mt-4">
											<table class="table table-sm product_main_table product_table">
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
												    <?php if(!empty($order_products)){
												        foreach($order_products as $product){ ?>
												    
												    <tr class="productRow">
												        <td><input type="hidden" name="order_product_id[]" value="<?php echo $product->order_product_id; ?>"><input disabled type="text" class="form-control product_name" name="product_name[]" value="<?php echo $product->product_name; ?>"></td>
												        <td><input disabled type="text" class="form-control product_volume" name="product_volume[]" value="<?php echo $product->product_volume; ?>"></td>
												        <td>
												            	<select disabled class="form-control" name="category[]" id="category">
												            	    <option value=""></option>
                        											<?php if(!empty($categories)){
                        												foreach($categories as $cat){
                        												    if($cat->category_id != '' && $cat->category_name != ''){
                            												    if($cat->category_id == $product->category ){
                            													    echo "<option value=\"".$cat->category_id."\" selected>".ucwords($cat->category_name)."</option>";
                            												    }else{
                            													    echo "<option value=\"".$cat->category_id."\">".ucwords($cat->category_name)."</option>";
                            												    }
                        												    }
                        												}
                        											}?>
                        										
                        										</select>
												        </td>
												        <td><input disabled type="text" class="form-control product_comment" name="product_comment[]" value="<?php echo $product->product_comment; ?>"></td>
												        <td width="200px">
												            <div class="input-group">
                    											<span class="input-group-addon">$</span>
                    											<input type="text" class="form-control" name="amount[]" value="<?php echo $product->amount; ?>">
                    										</div>
												        </td>
												        
												    </tr>
												    <?php } } ?>
												</tbody>
											</table>
										</div>
								        <div class="row">
								            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 mt-3 ">
								                <label>SHIPMENT TERMS</label>
								                <input disabled type="text" class="form-control" id="fob_fas" name="fob_fas" value="<?php echo $order_info[0]->fob_fas; ?>">
								                    
								            </div>
								            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mt-3 ">
								                <label>Market </label>
								                <div class="table-responsive">
        											<table class="table table-sm product_table marketTable ">
        												<tbody>
        												    <?php $markets = unserialize($order_info[0]->market); 
        												    if(!empty($markets)){
        												     foreach($markets as $market){
        												    ?>
    												        <tr class="productRow">
    												            <td> <input disabled type="text" class="form-control" id="market" value="<?php echo $market; ?>" name="market[]" required></td>
    												        </tr>
    												        <?php } } ?>
    												    </tbody>
    												</table>
												</div>
								                
								            </div>
								        </div>
								        <div class="row">
								            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 mt-3 ">
								                <label>SHIPMENT PERIOD</label>
								                <input disabled type="text" class="form-control" id="shipment_period" name="shipment_period" value="<?php echo $order_info[0]->shipment_period; ?>">
								                    
								            </div>
								            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 mt-3 ">
								                <label>Container Size  </label>
								                <select disabled class="form-control" id="container_size" name="container_size">
								                    <option value=""></option>
								                    <option value="Sea" <?php if($order_info[0]->container_size == 'Sea'){ echo "selected"; } ?> >Sea</option>
								                    <option value="Air" <?php if($order_info[0]->container_size == 'Air'){ echo "selected"; } ?> >Air</option>
								                </select>
								                    
								            </div> 
								            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 mt-3 supply_qty_wrap" <?php if($order_info[0]->container_size == 'Sea'){ ?> style="display:block"<?php }else{ ?>style="display:none" <?php } ?>>
								                <label>Supply QTY </label>
								                <select disabled class="form-control" id="container_supply_qty" name="container_supply_qty">
								                    <option value=""></option>
								                    <option value="20" <?php if($order_info[0]->container_supply_qty == '20'){ echo "selected"; } ?> >20</option>
								                    <option value="40" <?php if($order_info[0]->container_supply_qty == '40'){ echo "selected"; } ?> >40</option>
								                </select>
								                    
								            </div> 
								            
								            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 mt-3 qty_wrap" <?php if($order_info[0]->container_size == 'Air'){ ?> style="display:block"<?php }else{ ?>style="display:none" <?php } ?>>
								                <label>QTY </label>
								                <select disabled class="form-control" id="container_qty" name="container_qty">
								                    <option value=""></option>
								                    <option value="1" <?php if($order_info[0]->container_qty == '1'){ echo "selected"; } ?> >1</option>
								                    <option value="2" <?php if($order_info[0]->container_qty == '2'){ echo "selected"; } ?> >2</option>
								                    <option value="3" <?php if($order_info[0]->container_qty == '3'){ echo "selected"; } ?> >3</option>
								                </select>
								                    
								            </div>
								        </div>
								        <div class="row">
								             <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 mt-3 ">
								                <label>PAYMENT TERMS </label>
								                <input disabled type="text" class="form-control" id="payment_terms" name="payment_terms" value="<?php echo $order_info[0]->payment_terms; ?>">
								                    
								            </div>
								            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 mt-3 ">
								                <label>Marks</label>
								                <select disabled class="form-control" id="marks" name="marks" >
								                    <option value=""></option>
								                    <option value="Frozen" <?php if($order_info[0]->marks == 'Frozen'){ echo "selected"; } ?> >Frozen</option>
								                    <option value="Chilled" <?php if($order_info[0]->marks == 'Chilled'){ echo "selected"; } ?> >Chilled</option>
								                </select>
								            </div>
								        </div>
								        <div class="row">
    							            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mt-3 ">
    							                <label>PORT OF LOADING </label>
    							                <input disabled type="text" class="form-control" id="port_loading" name="port_loading" value="<?php echo $order_info[0]->port_loading; ?>" >
    							            </div>
							            </div>
							           <div class="row">
    							            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mt-3">
    							                <label>PORT OF DISCHARGE </label>
    							                <input disabled type="text" class="form-control" name="port_discharge" id="port_discharge" value="<?php echo $order_info[0]->port_discharge; ?>">
    							            </div>
							           </div>
							           <div class="row">
								            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mt-3 ">
								                <label>FINAL DESTINATION </label>
								                <input disabled type="text" class="form-control" name="final_destination" id="final_destination" value="<?php echo $order_info[0]->final_destination; ?>">
								            </div>
								        </div>
								        
									    <div class="row ">
									        <div class="col-lg-12 mt-3">
									            <label>Requirement Box</label>
									            <textarea disabled class="form-control" style="height:150px" >
• FROZEN PRODUCTS
• HALAL CERTIFIED
• INSERT ALL LABELS
• PRODUCTS SHOULD BE ELIGIBLE FOR ENTRY INTO ---------
• RFP, INTERIM HALAL AND LOAD OUT DOCS TO BE EMAILED TO NACH FOOD CO PTY LTD (EXPORTER NO: 3518 AND EDI NO:2145) at email address: info@nachfoodco.com.au</textarea>
									        </div>
									        <div class="col-lg-12 mt-3">
									            <label>Comments</label>
									            <textarea disabled class="form-control" name="comments" style="height:100px" ><?php echo $order_info[0]->comments; ?></textarea>
									        </div>
									    </div>
									    
									    <div class="text-end mt-3"><button type="submit" class="btn btn-info submit-button">Save and Close</button></div>
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

