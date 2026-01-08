<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .invoice-header {
            background-color: #4a628e;
            color: #fff;
            padding: 20px;
            position: relative;
        }

        .invoice-header h1,.invoice-footer h1 {
            font-size: 26px;
            text-align: center;
            color: white;
            margin: 0;
            position: absolute;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        /* Style for table header */
        .table th {
            background-color: #4a628e;
            color: white;
            text-align: left;
            padding: 10px;
        }

        /* Style for odd rows */
        .table tr:nth-child(odd) {
            background-color: #eeeeee;
            color: black;
        }

        /* Style for even rows */
        .table tr:nth-child(even) {
            background-color: white;
            color: black;
        }

        .table td {
            padding: 10px;
            text-align: left;
            /*border: 1px solid #ddd;*/
        }

        .table tr:last-child td {
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            padding: 20px;
            text-align: center;
            background-color: #f3f3f3;
        }
    </style>
    <title>Invoice</title>
</head>
<body>
    <!-- Invoice Header -->
    <div class="invoice-header">
        <!-- TAX INVOICE Text -->
        <h1>TAX INVOICE</h1>
        
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <tr>
                <!-- Left Section -->
                <td style="text-align: left; vertical-align: top; padding-right: 20px; width: 50%;color:white;line-height:22px" class="details-left">
                    <p><strong>Invoice No :</strong> <?php echo $invoice_no; ?></p>
                    <p><strong>Order Date:</strong> <?php echo $date; ?></p>
                    <p><strong>Floors:</strong> ALL</p>
                    <p><strong>Company Name:</strong> <?php echo $company_name ?></p>
                    <p><strong>Address:</strong> <?php echo $company_addr ?></p>
                    <p><strong>ABN:</strong> <?php echo $abn ?></p>
                </td>

                <!-- Right Section -->
                <td style="text-align: right; vertical-align: top; padding-left: 20px; width: 50%;color:white;line-height:22px" class="details-left">
                 <p><b> Bill To </b></p>   
                 <p><strong>Company Name:</strong> <?php echo $hospital_company_name ?></p>
                 <p><strong>Address:</strong> <?php echo $hospital_company_addr ?></p>
                 <p><strong>Email:</strong> <?php echo $hospital_email ?></p>
                 <p><strong>Phone:</strong> <?php echo $hospital_phone ?></p>
                </td>
            </tr>
        </table>
    </div>

    <!-- Invoice Table -->
    <table class="table">
        <thead>
            <tr style="color:white">
                <th>Floor(s)</th>
                <th>Actual Suites Serviced</th>
                <th>Billable Suites</th>
                <th>Cost per Suite</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            // UPDATED: ONE consolidated row for ALL floors
            // Calculate total using billable suites (minimum logic applied)
            $grandTotal = $billableSuites * $dailyCost;
            ?>
            <tr>
                <td><?= $floorsServiced ?></td>
                <td><?= $actualSuitesServiced ?></td>
                <td><?= $billableSuites ?></td>
                <td>$<?= number_format($dailyCost, 2) ?></td>
                <td>$<?= number_format($grandTotal, 2) ?></td>
            </tr>
            
            <?php if($actualSuitesServiced < $minimumLimit) { ?>
            <tr>
                <td colspan="5" style="font-size: 11px; color: #666; padding: 5px 10px;">
                    <em>* Daily minimum of <?= $minimumLimit ?> suites applied (actual: <?= $actualSuitesServiced ?>)</em>
                </td>
            </tr>
            <?php } ?>
            
            <tr>
                <td colspan="4" style="text-align: right; font-weight: bold;">Subtotal</td>
                <td style="font-weight: bold;">$<?= number_format($grandTotal, 2) ?></td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: right;">GST (Included)</td>
                <td>$<?= number_format($grandTotal/11, 2) ?></td>
            </tr>
            
            <tr style="background-color: #4a628e; color: white;">
                <td colspan="4" style="text-align: right; font-weight: bold; font-size: 16px;">Balance Due</td>
                <td style="font-weight: bold; font-size: 16px;">$<?= number_format($grandTotal, 2) ?></td>
            </tr>
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
       
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <!-- Left Section -->
               <td style="text-align: left; vertical-align: top; padding-right: 20px; width: 50%; color: black; line-height: 22px;" class="details-left">
                <h3>Bank Details</h3>
                <p><strong>Account Name :</strong> <?php echo $account_name; ?></p>
                <p><strong>Account Number:</strong> <?php echo $account_no; ?></p>
                <p><strong>BSB :</strong> <?php echo $bsb; ?></p>
            </td>
                <!-- Right Section -->
                <td style="text-align: right; vertical-align: top; padding-left: 20px; width: 50%;color:black;line-height:22px" class="details-left">
                    <p><strong>Remittance Email:</strong> <?php echo $account_email ?></p>
                    <p><strong>Terms:</strong> <?php echo $terms ?></p>
                    
                </td>
            </tr>
        </table>

        <p style="margin-top: 20px; font-style: italic; color: #4a628e; font-size: 14px;">
            Satisfaction through Product Quality, Freshness & Service
        </p>
        
        <p>Thank you,<br><strong><?= $company_name ?></strong></p>
    </div>
</body>
</html>
