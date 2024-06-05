<?php
session_start();
$servername = "localhost"; // MySQL 伺服器主機名稱
$username = "root"; // MySQL 使用者名稱
$password = ""; // MySQL 密碼
$dbname = ""; // 資料庫名稱

$conn = new mysqli("localhost", "root", "","");

if ($conn->connect_error) {
    die("連線失敗: " . $conn->connect_error);
}

$inventory_number = isset($_GET['inventory_number']) ? $_GET['inventory_number'] : '';

if (empty($inventory_number)) {
    die("未提供 inventory_number。");
}

// 查询与 inventory_number 相关的数据
$sql_inventory = "SELECT * FROM inventory WHERE inventory_number = ?";
$stmt_inventory = $conn->prepare($sql_inventory);
$stmt_inventory->bind_param("s", $inventory_number);
$stmt_inventory->execute();
$result_inventory = $stmt_inventory->get_result();
$inventory_data = $result_inventory->fetch_assoc();


$print_date = $inventory_data['print_date'];
$payment_year_month = date("Y-m", strtotime($print_date));
$Account =  $inventory_data['account'];
$quantity = 1;

// 查询 receipt_explanation 表中与 inventory_number 相关的 invoice_number
$sql_invoice = "SELECT invoice_number FROM receipt_explanation WHERE inventory_number = ?";
$stmt_invoice = $conn->prepare($sql_invoice);
$stmt_invoice->bind_param("s", $inventory_number);
$stmt_invoice->execute();
$result_invoice = $stmt_invoice->get_result();
$invoice_data = $result_invoice->fetch_assoc();


// 查询 receipt_keeping_list 表中与 inventory_number 相关的数据
$sql_receipt_keeping = "SELECT * FROM receipt_keeping_list WHERE inventory_number = ?";
$stmt_receipt_keeping = $conn->prepare($sql_receipt_keeping);
$stmt_receipt_keeping->bind_param("s", $inventory_number);
$stmt_receipt_keeping->execute();
$result_receipt_keeping = $stmt_receipt_keeping->get_result();
$receipt_keeping_data = [];
while ($row = $result_receipt_keeping->fetch_assoc()) {
    $receipt_keeping_data[] = $row;
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Output</title>
    <style>
        .container {
            max-width: 80%;
            margin: auto;
            padding: 20px;
        }
        table {
            width: 100%;
            max-width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            word-wrap: break-word;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn2 {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            text-decoration: none;
            color: white;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
        }
        .btn2:hover {
            background-color: #45a049;
        }
    </style>
    <script>
        function printPage() {
            window.print();
        }
    </script>
</head>
<body>
    <div class="container">
        <?php if ($inventory_data): ?>
            <table>
                <tr>
                    <td>Inventory number:</td>
                    <td><input type="text" name="inventory_number" value="<?php echo htmlspecialchars($inventory_data['inventory_number']); ?>"></td>
                </tr>
                <tr>
                    <td>Document code:</td>
                    <td><input type="text" name="document_code" value="<?php echo htmlspecialchars($inventory_data['document_code']); ?>"></td>
                </tr>
                <tr>
                    <td>Maker (Staff ID):</td>
                    <td><input type="text" name="account" value="<?php echo htmlspecialchars($inventory_data['account']); ?>"></td>
                </tr>
                <tr>
                    <td>Receipt number:</td>
                    <td><input type="text" name="invoice_number" value="<?php echo htmlspecialchars($invoice_data['invoice_number'] ?? 'N/A'); ?>"></td>
                </tr>
                <tr>
                    <td>Title:</td>
                    <td><input type="text" name="title" value="<?php echo htmlspecialchars($inventory_data['title']); ?>"></td>
                </tr>
                <tr>
                    <td>Plan name:</td>
                    <td><input type="text" name="plan_name" value="<?php echo htmlspecialchars($inventory_data['plan_name']); ?>"></td>
                </tr>
            </table>
        <?php else: ?>
            <p>No inventory data found.</p>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th rowspan="2">Personnel</th>
                    <th rowspan="2">Staff_ID</th>
                    <th rowspan="2">Payment<br>Year/Month</th>
                    <th rowspan="2">Account</th>
                    <th colspan="2">Items</th>
                    <th rowspan="2">Health<br>Insurance (Employer)</th>
                    <th rowspan="2">Total<br>Due</th>
                    <th colspan="3">Employee Deductions</th>
                    <th rowspan="2">Total<br>Deductions</th>
                    <th rowspan="2">Net<br>Amount</th>
                </tr>
                <tr>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Tax</th>
                    <th>Health<br>Insurance</th>
                    <th>Other<br>Deductions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($receipt_keeping_data) > 0): ?>
                    <?php foreach ($receipt_keeping_data as $item): ?>
                    <tr>
                        <td rowspan="2">Staff</td>
                        <td rowspan="2"><input type="text" name="account" value="<?php echo htmlspecialchars($inventory_data['account']); ?>"></td>
                        <td rowspan="2"><input type="text" name="payment_year_month" value="<?php echo htmlspecialchars($payment_year_month); ?>"></td>
                        <td rowspan="2"><input type="text" name="account" value="<?php echo htmlspecialchars($item['account'] ?? 'N/A'); ?>"></td>
                        <td><input type="text" name="unit_price" value="<?php echo htmlspecialchars($item['unit_price'] ?? 'N/A'); ?>"></td>
                        <td><input type="text" name="quantity" value="<?php echo htmlspecialchars($item['quantity'] ?? 'N/A'); ?>"></td>
                        <td rowspan="2"><input type="text" name="health_insurance_employer" value="0"></td>
                        <td rowspan="2"><input type="text" name="total_due" value="<?php echo htmlspecialchars($item['total_due'] ?? 'N/A'); ?>"></td>
                        <td rowspan="2"><input type="text" name="tax" value="0"></td>
                        <td rowspan="2"><input type="text" name="health_insurance" value="0"></td>
                        <td rowspan="2"><input type="text" name="other_deductions" value="0"></td>
                        <td rowspan="2"><input type="text" name="total_deductions" value="0"></td>
                        <td rowspan="2"><input type="text" name="net_amount" value="<?php echo htmlspecialchars($item['net_amount'] ?? 'N/A'); ?>"></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="text" name="description" value="<?php echo htmlspecialchars($item['description'] ?? 'N/A'); ?>"></td>
                    </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="4">Total: <?php echo count($receipt_keeping_data); ?> Entry</td>
                        <td><?php echo array_sum(array_column($receipt_keeping_data, 'unit_price')); ?></td>
                        <td>0</td>
                        <td><?php echo array_sum(array_column($receipt_keeping_data, 'total_due')); ?></td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td><?php echo array_sum(array_column($receipt_keeping_data, 'net_amount')); ?></td>
                    </tr>
                <?php else: ?>
                    <tr><td colspan='13'>No receipt keeping data found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        
        <p>Undertaker: </p>
        <p>Project manager: </p>
        <p>Unit supervisor: </p>
        <p>Accounting Office: </p>
        <p>President: </p>
        <button class="btn2" onclick="printPage()">print</button>
        <form action="delete.php" method="post" onsubmit="return confirm('Are you sure you want to delete this record?');">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($inventory_data['inventory_number']); ?>">
            <button type="submit" class="btn2">Delete</button>
        </form>
        <form action="edit.php" method="post">
            <button type="submit" class="btn2">Edit</button>
        </form>
    </div>
</body>
</html>
