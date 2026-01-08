<div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                   <div class="col-lg-6 align-items-center" style="text-align: left;">
                   <h4 class="flex-grow-1 text-black">Internal Order Report</h4>
                    </div>       
                  </div> 
                  
                  <div class="row">
                       <form action="/Supplier/filterInternalOrderReport" method="POST">
        <div class="row">
            <!-- Delivery Date From -->
            <div class="col-md-3 col-lg-2 col-sm-6 mt-2">
                <label class="form-label mb-0 fw-semibold">Delivery Date From</label>
                <input type="text" required class="form-control flatpickr-input active" value="<?php echo isset($from_date) ? $from_date : ''; ?>" data-provider="flatpickr" data-date-format="d-m-Y" id="from_delivery_date" name="from_delivery_date" placeholder="Select date" readonly="readonly">         
            </div>
            
            <!-- Delivery Date To -->
            <div class="col-md-3 col-lg-2 col-sm-6 mt-2">
                <label class="form-label mb-0 fw-semibold">Delivery Date To</label>
                <input type="text" required class="form-control flatpickr-input active" value="<?php echo isset($to_date) ? $to_date : ''; ?>" data-provider="flatpickr" data-date-format="d-m-Y" id="to_delivery_date" name="to_delivery_date" placeholder="Select date" readonly="readonly">         
            </div>

            <!-- Product List -->
            <div class="col-md-4 col-lg-3 col-sm-6 mt-2">
    <label class="form-label mb-0 fw-semibold">Product List</label>
<select class="form-control" name="product_ids[]" id="choices-multiple-remove-button" data-choices data-choices-removeItem name="choices-multiple-remove-button" multiple>
<option value="">ALL</option>
<?php foreach ($products as $product): ?>
<option value="<?php echo $product['id']; ?>" <?php echo (isset($selected_product_ids) && in_array($product['id'], $selected_product_ids)) ? 'selected' : ''; ?>>
  <?php echo $product['name']; ?>
  </option>
    <?php endforeach; ?>
    </select>
</div>

<!-- Location List -->
<div class="col-md-3 col-lg-2 col-sm-6 mt-2">
    <label class="form-label mb-0 fw-semibold">Location List</label>
    <select class="form-control" name="location_ids[]" id="choices-multiple-remove-button" data-choices data-choices-removeItem name="choices-multiple-remove-button" multiple>
        <option value="">ALL</option>
        <?php foreach ($locations as $location): ?>
         <option value="<?php echo $location['location_id']; ?>" <?php echo (isset($selected_location_ids) && in_array($location['location_id'], $selected_location_ids)) ? 'selected' : ''; ?>>
           <?php echo $location['name']; ?>
          </option>
        <?php endforeach; ?>
    </select>
</div>

            <!-- Filter Button -->
            <div class="col-md-3 col-lg-2 col-sm-6 mt-2">
                <label class="form-label mb-0 fw-semibold">&nbsp;</label><br>
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>
                      </div>
                      
                      <?php if (isset($orders) && !empty($orders)): ?>
        <div class="row mt-4">
            <div class="col-md-12">
            
                  <table id="reportTable" class="display table table-bordered" style="width:100%">    
                   <thead class="text-muted table-light">
                        <tr>
                            <th>Product Name</th>
                            <th>Category Name</th>
                            <!--<th>Location Name</th>-->
                            <th>Delivery Date</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-primary-subtle fw-bold">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>Total: <?php echo $totalOrderQty; ?></td>
                            <td>Total : $<?php echo number_format($totalPrice, 2, '.', ','); ?></td>
                            
                        </tr>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?php echo $order['product_name']; ?></td>
                                <td><?php echo $order['category_name']; ?></td>
                                <!--<td><?php echo $order['location_name']; ?></td>-->
                                <td><?php echo date('d-m-Y', strtotime($order['delivery_date'])); ?></td>
                                <td><?php echo '$'.number_format($order['price'],2); ?></td>
                                <td><?php echo $order['orderQty']; ?></td>
                                <td><?php echo '$'.number_format($order['price'] * $order['orderQty'],2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
                  
                  
                    </div>
                    </div>
                    </div>
<script>
  $(document).ready(function(){
   new DataTable("#reportTable", {
    dom: "Bfrtip",
    pageLength: 100,
    buttons: [
      { extend: "excel", className: "btn btn-success", text: "<i class='fas fa-file-excel'></i> Excel" },
      { extend: "print", className: "btn btn-yellow" , text: "<i class='fas fa-print'></i> Print" }
    ]
  });
  
   $('.select2').select2({
            placeholder: "Select options",
            allowClear: true
        });
  });
                    </script>