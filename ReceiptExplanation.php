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

// 从会话中获取 inventory_number
if (!isset($_SESSION['inventory_number'])) {
    echo "無法找到 inventory_number。\n";
    exit();
} else {
    $inventory_number = $_SESSION['inventory_number'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dates = $_POST['date'];
    $invoice_numbers = $_POST['invoice_number'];
    $total_amounts_of_receipt = $_POST['total_amount_of_receipt'];
    $cost_categories = $_POST['cost_category'];
    $purposes = $_POST['purpose'];
    $notes = $_POST['note'];

    $sql = "INSERT INTO receipt_explanation (cost_category, note, invoice_number, total_amount_of_receipt, purpose, date, inventory_number) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    for ($i = 0; $i < count($dates); $i++) {
        $date = $dates[$i];
        $invoice_number = $invoice_numbers[$i];
        $total_amount_of_receipt = $total_amounts_of_receipt[$i];
        $cost_category = $cost_categories[$i];
        $purpose = $purposes[$i];
        $note = $notes[$i];

        $stmt->bind_param("sssisss", $cost_category, $note, $invoice_number, $total_amount_of_receipt, $purpose, $date, $inventory_number);

        if (!$stmt->execute()) {
            echo "錯誤: " . $sql . "<br>" . $conn->error;
            $stmt->close();
            $conn->close();
            exit();
        }
    }

    echo  "<html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Registration Success</title>
        <style>
            body { font-family: Arial, sans-serif; }
            .container { text-align: center; margin-top: 50px; }
            .btn { display: inline-block; padding: 10px 20px; font-size: 16px; text-decoration: none; color: white; background-color: #4CAF50; border: none; border-radius: 5px; }
            .btn:hover { background-color: #45a049; }
        </style>
    </head>
    <body>
        <div class='container'>
            <h1>儲存成功</h1>
            <p>請點選按鈕返回</p>
            <form method='POST' action='function.html'>
                <button type='submit' class='btn'>返回</button>
            </form>
        </div>
    </body>
    </html>";

    $stmt->close();
}

$conn->close();
?>
