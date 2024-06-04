<?php
session_start();

$servername = "localhost"; // MySQL 伺服器主機名稱
$username = "root"; // MySQL 使用者名稱
$password = ""; // MySQL 密碼
$dbname = "DBMS_Project"; // 資料庫名稱

// 建立連線
$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連線
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

$sql_receipt_keeping = "SELECT * FROM receipt_keeping_list WHERE inventory_number = ?";
$stmt_receipt_keeping = $conn->prepare($sql_receipt_keeping);
$stmt_receipt_keeping->bind_param("s", $inventory_number);
$stmt_receipt_keeping->execute();
$result_receipt_keeping = $stmt_receipt_keeping->get_result();
$receipt_keeping_data = [];
while ($row = $result_receipt_keeping->fetch_assoc()) {
    $receipt_keeping_data[] = $row;
}

$sql_receipt_explanation = "SELECT * FROM receipt_explanation WHERE inventory_number = ?";
$stmt_receipt_explanation = $conn->prepare($sql_receipt_explanation);
$stmt_receipt_explanation->bind_param("s", $inventory_number);
$stmt_receipt_explanation->execute();
$result_receipt_explanation = $stmt_receipt_explanation->get_result();
$receipt_explanation_data = [];
while ($row = $result_receipt_explanation->fetch_assoc()) {
    $receipt_explanation_data[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Output</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        .container {
            max-width: 1200px;
            margin: auto;
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
        <p>Inventory number: <?php echo htmlspecialchars($inventory_data['inventory_number']); ?></p>
        <p>Document code: <?php echo htmlspecialchars($inventory_data['document_code']); ?></p>
        <p>Maker: <?php echo htmlspecialchars($inventory_data['account']); ?></p>
        <p>Subpoena number: null</p>
        <p>Title: <?php echo htmlspecialchars($inventory_data['title']); ?></p>
        <p>Plan name: <?php echo htmlspecialchars($inventory_data['plan_name']); ?></p>
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
                <?php foreach ($receipt_keeping_data as $item): ?>
                <tr>
                    <td rowspan="2">Staff</td>
                    <td rowspan="2"><?php echo htmlspecialchars($item['staff_ID']); ?></td>
                    <td rowspan="2"><?php echo htmlspecialchars($item['payment_year_month']); ?></td>
                    <td rowspan="2"><?php echo htmlspecialchars($item['account']); ?></td>
                    <td><?php echo htmlspecialchars($item['unit_price']); ?></td>
                    <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                    <td rowspan="2">0</td>
                    <td rowspan="2"><?php echo htmlspecialchars($item['total_due']); ?></td>
                    <td rowspan="2">0</td>
                    <td rowspan="2">0</td>
                    <td rowspan="2">0</td>
                    <td rowspan="2">0</td>
                    <td rowspan="2"><?php echo htmlspecialchars($item['net_amount']); ?></td>
                </tr>
                <tr>
                    <td colspan="2"><?php echo htmlspecialchars($item['description']); ?></td>
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
            </tbody>
        </table>
        <p>Undertaker: </p>
        <p>Project manager: </p>
        <p>Unit supervisor: </p>
        <p>Accounting Office: </p>
        <p>President: </p>
        <button class="btn2" onclick="printPage()">print</button>
        <form action="delete.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($inventory_data['inventory_number']); ?>">
            <button type="submit" class="btn2">Delete</button>
        </form>
        <form action="edit.php" method="post">
            <button type="submit" class="btn2">Edit</button>
        </form>
    </div>
</body>
</html>
