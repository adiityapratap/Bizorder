<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Notification</title>
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
            padding: 15px;
            background-color: #4a5568;
            color: white;
            border-radius: 5px;
        }
        .order-type {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .order-type.new {
            background-color: #d4edda;
            color: #155724;
        }
        .order-type.update {
            background-color: #fff3cd;
            color: #856404;
        }
        .email-content {
            font-size: 16px;
            margin-bottom: 20px;
        }
        .order-details {
            background-color: #fff;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .order-details table {
            width: 100%;
            border-collapse: collapse;
        }
        .order-details td {
            padding: 8px;
            border-bottom: 1px solid #eee;
        }
        .order-details td:first-child {
            font-weight: bold;
            color: #555;
            width: 40%;
        }
        .order-items {
            background-color: #fff;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .order-items h3 {
            margin-top: 0;
            color: #555;
        }
        .category-section {
            margin-bottom: 15px;
        }
        .category-title {
            font-weight: bold;
            color: #007bff;
            font-size: 16px;
            margin-bottom: 5px;
        }
        .menu-item {
            margin-left: 15px;
            margin-bottom: 8px;
        }
        .menu-item-name {
            font-weight: bold;
            color: #333;
        }
        .menu-item-option {
            color: #666;
            font-size: 14px;
            margin-left: 10px;
        }
        .allergen-tag {
            display: inline-block;
            background-color: #fff3cd;
            color: #856404;
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 12px;
            margin-left: 10px;
            margin-top: 3px;
        }
        .note-tag {
            display: inline-block;
            background-color: #d1ecf1;
            color: #0c5460;
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 12px;
            margin-left: 10px;
            margin-top: 3px;
        }
        .action-box {
            background-color: #e3f2fd;
            border-left: 4px solid #2196F3;
            padding: 15px;
            margin-top: 20px;
            border-radius: 5px;
        }
        .email-footer {
            text-align: center;
            font-size: 14px;
            color: #888;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            BizOrder System
        </div>
        
        <div class="order-type <?php echo $isUpdate ? 'update' : 'new'; ?>">
            <?php echo $isUpdate ? 'ORDER UPDATED' : 'NEW ORDER RECEIVED'; ?>
        </div>
        
        <div class="email-content">
            Dear Chef Team,<br><br>
            <?php if ($isUpdate): ?>
                An existing order has been modified and requires your attention.
            <?php else: ?>
                A new order has been placed and is ready for preparation.
            <?php endif; ?>
        </div>
        
        <div class="order-details">
            <table>
                <tr>
                    <td>Floor:</td>
                    <td><strong><?php echo htmlspecialchars($floorName); ?></strong></td>
                </tr>
                <tr>
                    <td>Suite:</td>
                    <td><strong style="color: #007bff;">Suite <?php echo htmlspecialchars($suiteNumber); ?></strong></td>
                </tr>
                <tr>
                    <td>Order Date:</td>
                    <td><strong style="color: #28a745;"><?php echo $orderDate; ?></strong></td>
                </tr>
                <tr>
                    <td>Placed By:</td>
                    <td><?php echo htmlspecialchars($userName); ?> (<?php echo htmlspecialchars($roleName); ?>)</td>
                </tr>
                <tr>
                    <td>Time:</td>
                    <td><?php echo date('d M Y, h:i A'); ?></td>
                </tr>
            </table>
        </div>
        
        <?php if (!empty($orderItems)): ?>
        <div class="order-items">
            <h3>Order Items:</h3>
            
            <?php foreach ($orderItems as $category => $items): ?>
                <div class="category-section">
                    <div class="category-title"><?php echo htmlspecialchars($category); ?></div>
                    
                    <?php foreach ($items as $item): ?>
                        <div class="menu-item">
                            <span class="menu-item-name">• <?php echo htmlspecialchars($item['name']); ?></span>
                            
                            <?php if (!empty($item['options'])): ?>
                                <br><span class="menu-item-option">→ <?php echo htmlspecialchars($item['options']); ?></span>
                            <?php endif; ?>
                            
                            <?php if (!empty($item['allergens'])): ?>
                                <br><span class="allergen-tag">⚠ ALLERGENS: <?php echo htmlspecialchars($item['allergens']); ?></span>
                            <?php endif; ?>
                            
                            <?php if (!empty($item['comment'])): ?>
                                <br><span class="note-tag">💬 NOTE: <?php echo htmlspecialchars($item['comment']); ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        
        <div class="action-box">
            <strong>Action Required:</strong> Please prepare this order according to the specified items and schedule.
            <?php if ($isUpdate): ?>
                Note that this is an updated order with changes to previously placed items.
            <?php else: ?>
                This is a new order.
            <?php endif; ?>
        </div>
        
        <div class="email-footer">
            This is an automated notification from BizOrder System<br>
            <a href="<?php echo base_url(); ?>" style="color: #007bff; text-decoration: none;">Visit Dashboard</a><br><br>
            &copy; <?php echo date('Y'); ?> BizOrder. All rights reserved.
        </div>
    </div>
</body>
</html>

