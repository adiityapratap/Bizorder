<!DOCTYPE html>
<html>
<head>
    <title>Order Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            border: 1px solid #dddddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #ffffff;
            color: #000000;
            text-align: center;
            padding: 15px;
            font-size: 20px;
            font-weight: bold;
        }
        .content {
            padding: 20px;
            color: #333333;
            line-height: 1.6;
            font-size: 16px;
        }
        .footer {
            background-color: #ffffff;
            text-align: center;
            padding: 10px;
            font-size: 14px;
            color: #000000;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            Order Notification
        </div>
        <div class="content">
            <p>Dear Chef,</p>
            <p>Today’s orders have been finalized by the hospital staff in the Bizorder portal. Please log in to the portal to prepare the order.</p>
            <p>Thank you,</p>
            <p>Café Team</p>
        </div>
        <div class="footer">
            © <?php echo date('Y') ?> Café Team. All rights reserved.
        </div>
    </div>
</body>
</html>
