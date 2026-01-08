<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Approval Supplier Email</title>
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
                    Hi Manager ,
                   </p>
<p style="font-size: 16px; line-height: 1.5; margin: 0 0 20px;">    
              
The Supplier order for the <?php echo $locationName; ?> placed on <?php echo $order_date; ?> has exceeded the weekly budget.

To approve the order, please click on the approve button below.

 </p>

                 
<p>
    <a href="<?php echo $approveOrderUrl; ?>" style="display: inline-block; padding: 10px 20px; background-color: #45CB86; color: #ffffff; text-decoration: none; border-radius: 5px; font-weight: bold;">Approve</a>
<a href="<?php echo $rejectOrderUrl; ?>" style="display: inline-block;margin-left:15px; padding: 10px 20px; background-color: #172150; color: #ffffff; text-decoration: none; border-radius: 5px; font-weight: bold;">Reject</a>
</p>


            

                <!-- Closing -->
                <p style="font-size: 16px; margin: 0;">Kind regards,<br>Bizadmin</p>

            </td>
        </tr>
    </table>

</body>
</html>
