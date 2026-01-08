<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menuplanner Published</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .email-header {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #555;
            margin-bottom: 20px;
        }
        .email-content {
            font-size: 16px;
            margin-bottom: 20px;
        }
        .email-footer {
            text-align: center;
            font-size: 14px;
            color: #888;
        }
        .view-invoice-btn {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 10px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }
        .view-invoice-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            Café Team
        </div>
        <div class="email-content">
            Dear Staff,<br><br>
            Tomorrow’s menu has been published in Bizorder. Please login to the portal to view and order from the menu.<br><br>
           
            Thank you<br>
            <br>
            Café Team
        </div>
        <div class="email-footer">
            &copy; <?php echo date('Y'); ?> Zealcafe. All rights reserved.
        </div>
    </div>
</body>
</html>
