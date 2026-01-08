<?php
/**
 * DIAGNOSTIC SCRIPT: Check Snapshots Setup
 * 
 * This script checks if all required tables exist and provides detailed diagnostics
 * Run this in browser: https://yourdomain.com/check_snapshots_setup.php
 */

// Database configuration
$servername = "localhost";
$username = "bizordercom_zeal"; // UPDATE THIS with your DB username
$password = "UGYgM;mf+6Uv";     // UPDATE THIS with your DB password
$database = "bizordercom_zeal";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

echo "<h1>📊 Snapshots Setup Diagnostic</h1>";
echo "<p><strong>Database:</strong> $database</p>";
echo "<hr>";

// Required tables
$requiredTables = [
    'late_order_dismissals' => 'Late Order Alert Dismissals',
    'order_snapshots' => 'Order Snapshots',
    'suite_order_snapshots' => 'Suite Order Snapshots',
    'menu_item_snapshots' => 'Menu Item Snapshots',
    'invoice_snapshots' => 'Invoice Snapshots'
];

$allTablesExist = true;
$tableStatus = [];

echo "<h2>🔍 Checking Required Tables</h2>";
echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
echo "<tr style='background: #f0f0f0;'><th>Table Name</th><th>Purpose</th><th>Status</th><th>Row Count</th></tr>";

foreach ($requiredTables as $tableName => $purpose) {
    // Check if table exists
    $result = $conn->query("SHOW TABLES LIKE '$tableName'");
    
    if ($result->num_rows > 0) {
        // Table exists - get row count
        $countResult = $conn->query("SELECT COUNT(*) as cnt FROM `$tableName`");
        $count = $countResult->fetch_assoc()['cnt'];
        
        echo "<tr>";
        echo "<td><strong>$tableName</strong></td>";
        echo "<td>$purpose</td>";
        echo "<td style='color: green; font-weight: bold;'>✅ EXISTS</td>";
        echo "<td>$count rows</td>";
        echo "</tr>";
        
        $tableStatus[$tableName] = true;
    } else {
        // Table missing
        echo "<tr>";
        echo "<td><strong>$tableName</strong></td>";
        echo "<td>$purpose</td>";
        echo "<td style='color: red; font-weight: bold;'>❌ MISSING</td>";
        echo "<td>-</td>";
        echo "</tr>";
        
        $tableStatus[$tableName] = false;
        $allTablesExist = false;
    }
}

echo "</table>";

// Summary
echo "<hr>";
echo "<h2>📋 Summary</h2>";

if ($allTablesExist) {
    echo "<div style='background: #d4edda; color: #155724; padding: 15px; border: 1px solid #c3e6cb; border-radius: 5px;'>";
    echo "<h3>✅ All Required Tables Exist!</h3>";
    echo "<p>Your database is correctly set up for snapshots.</p>";
    echo "</div>";
} else {
    echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border: 1px solid #f5c6cb; border-radius: 5px;'>";
    echo "<h3>❌ Missing Tables Detected</h3>";
    echo "<p>You need to run the SQL script to create missing tables.</p>";
    echo "<p><strong>Action Required:</strong> Run PRODUCTION_COMPLETE_TABLES.sql on your database</p>";
    echo "</div>";
}

// Check Snapshot_model file
echo "<hr>";
echo "<h2>📁 Checking Required Files</h2>";
echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
echo "<tr style='background: #f0f0f0;'><th>File</th><th>Path</th><th>Status</th></tr>";

$requiredFiles = [
    'Snapshot_model.php' => 'application/modules/Orderportal/models/Snapshot_model.php',
    'Reports.php (Controller)' => 'application/modules/Orderportal/controllers/Reports.php',
    'snapshots_list.php (View)' => 'application/modules/Orderportal/views/Reports/snapshots_list.php'
];

foreach ($requiredFiles as $fileName => $filePath) {
    $fullPath = __DIR__ . '/' . $filePath;
    $exists = file_exists($fullPath);
    
    echo "<tr>";
    echo "<td><strong>$fileName</strong></td>";
    echo "<td><code>$filePath</code></td>";
    
    if ($exists) {
        echo "<td style='color: green; font-weight: bold;'>✅ EXISTS</td>";
    } else {
        echo "<td style='color: red; font-weight: bold;'>❌ MISSING</td>";
    }
    echo "</tr>";
}

echo "</table>";

// Test actual query
echo "<hr>";
echo "<h2>🧪 Testing Snapshot Query</h2>";

if ($tableStatus['order_snapshots'] ?? false) {
    try {
        $testQuery = "SELECT 
            os.id as snapshot_id,
            os.order_id,
            os.order_date,
            os.floor_name,
            os.created_by_user_name,
            os.created_at
        FROM order_snapshots os
        LIMIT 5";
        
        $result = $conn->query($testQuery);
        
        if ($result) {
            echo "<div style='background: #d4edda; color: #155724; padding: 15px; border: 1px solid #c3e6cb; border-radius: 5px;'>";
            echo "<p><strong>✅ Query executed successfully!</strong></p>";
            echo "<p>Found " . $result->num_rows . " snapshot(s)</p>";
            
            if ($result->num_rows > 0) {
                echo "<h4>Sample Data:</h4>";
                echo "<table border='1' cellpadding='5' style='border-collapse: collapse;'>";
                echo "<tr style='background: #f0f0f0;'>";
                echo "<th>Snapshot ID</th><th>Order ID</th><th>Order Date</th><th>Floor</th><th>Created By</th><th>Created At</th>";
                echo "</tr>";
                
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['snapshot_id']}</td>";
                    echo "<td>{$row['order_id']}</td>";
                    echo "<td>{$row['order_date']}</td>";
                    echo "<td>{$row['floor_name']}</td>";
                    echo "<td>{$row['created_by_user_name']}</td>";
                    echo "<td>{$row['created_at']}</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p><em>No snapshots created yet. Place an order to generate a snapshot.</em></p>";
            }
            echo "</div>";
        } else {
            echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border: 1px solid #f5c6cb; border-radius: 5px;'>";
            echo "<p><strong>❌ Query failed:</strong> " . $conn->error . "</p>";
            echo "</div>";
        }
    } catch (Exception $e) {
        echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border: 1px solid #f5c6cb; border-radius: 5px;'>";
        echo "<p><strong>❌ Error:</strong> " . $e->getMessage() . "</p>";
        echo "</div>";
    }
} else {
    echo "<div style='background: #fff3cd; color: #856404; padding: 15px; border: 1px solid #ffeeba; border-radius: 5px;'>";
    echo "<p><strong>⚠️ Cannot test:</strong> order_snapshots table doesn't exist yet.</p>";
    echo "</div>";
}

// PHP Info
echo "<hr>";
echo "<h2>⚙️ PHP Configuration</h2>";
echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
echo "<tr><td><strong>PHP Version:</strong></td><td>" . phpversion() . "</td></tr>";
echo "<tr><td><strong>Display Errors:</strong></td><td>" . (ini_get('display_errors') ? 'ON' : 'OFF') . "</td></tr>";
echo "<tr><td><strong>Error Reporting:</strong></td><td>" . error_reporting() . "</td></tr>";
echo "<tr><td><strong>Max Execution Time:</strong></td><td>" . ini_get('max_execution_time') . "s</td></tr>";
echo "</table>";

// Final recommendation
echo "<hr>";
echo "<h2>🎯 Next Steps</h2>";

if ($allTablesExist) {
    echo "<ol>";
    echo "<li>✅ All tables exist - Good!</li>";
    echo "<li>Test the snapshots page: <a href='/Orderportal/Reports/snapshots' target='_blank'>/Orderportal/Reports/snapshots</a></li>";
    echo "<li>If still getting 500 error, check:<ul>";
    echo "<li>Application logs: <code>application/logs/log-" . date('Y-m-d') . ".php</code></li>";
    echo "<li>PHP error logs</li>";
    echo "<li>CodeIgniter profiler output</li>";
    echo "</ul></li>";
    echo "</ol>";
} else {
    echo "<div style='background: #fff3cd; color: #856404; padding: 15px; border: 1px solid #ffeeba; border-radius: 5px;'>";
    echo "<h3>⚠️ Action Required:</h3>";
    echo "<ol>";
    echo "<li>Upload <code>PRODUCTION_COMPLETE_TABLES.sql</code> to your server</li>";
    echo "<li>Run it via:<ul>";
    echo "<li><strong>phpMyAdmin:</strong> SQL tab → paste contents → Execute</li>";
    echo "<li><strong>SSH:</strong> <code>mysql -u username -p bizordercom_zeal < PRODUCTION_COMPLETE_TABLES.sql</code></li>";
    echo "</ul></li>";
    echo "<li>Refresh this page to verify tables were created</li>";
    echo "</ol>";
    echo "</div>";
}

echo "<hr>";
echo "<p style='color: #999; font-size: 12px;'><em>Diagnostic completed at " . date('Y-m-d H:i:s') . "</em></p>";
echo "<p style='color: #999; font-size: 12px;'><em>🔒 IMPORTANT: Delete this file after diagnosis for security!</em></p>";

$conn->close();
?>

