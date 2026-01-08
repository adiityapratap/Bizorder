<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Order</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f5f5f5; margin: 0; padding: 0;">

    <!-- Email Container -->
    <table align="center" width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse; background-color: #ffffff; margin: 20px auto; padding: 20px; box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.2);">
        <tr>
            <td>

                <!-- Header -->
                <!--<p style="font-size: 24px; font-weight: bold; margin: 0 0 20px;">Bank Order</p>-->

                <!-- Email Content -->
                <p style="font-size: 16px; line-height: 1.5; margin: 0 0 20px;">
                    Hi <?php echo $supplierName; ?> ,<br><br>
                   You have received a new supplier order from <?php echo $orzName; ?>, <?php echo $locationName; ?>  </p>
               <p style="font-size: 16px; line-height: 1.5; margin: 0 0 20px;">    
                Please click on the view order button below to view the order information. </p>
                </p>
                 <p style="font-size: 16px; line-height: 1.5; margin: 0 0 20px;">    
                 Café Name/Location : <?php echo $orzName; ?> / <?php echo $locationName; ?> <br></br>
                 Café Email:          <?php echo $cafeEmail; ?> <br></br>
                 Café Contact Number: <?php echo $cafeContactNumber; ?> <br></br>
                
                </p>
                <p><a href="<?php echo $orderUrl; ?>" style="display: inline-block; padding: 10px 20px; background-color: #172150; color: #ffffff; text-decoration: none; border-radius: 5px; font-weight: bold;">Click to View Order</a>
</p>

            

                <!-- Closing -->
                <p style="font-size: 16px; margin: 0;">Kind regards,<br>Bizadmin</p>

            </td>
        </tr>
    </table>

</body>
</html>
