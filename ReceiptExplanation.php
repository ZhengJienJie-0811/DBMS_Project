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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'];
    $invoice_number = $_POST['invoice_number'];
    $total_amount_of_receipt = $_POST['total_amount_of_receipt'];
    $cost_category = $_POST['cost_category'];
    $purpose = $_POST['purpose'];
    $note = $_POST['note'];

    if (!isset($_SESSION['inventory_number'])) {
        echo "無法找到 inventory_number。\n";
        exit();
    } else {
        $inventory_number = $_SESSION['inventory_number'];
    }
    
    $sql = "INSERT INTO receipt_explanation (cost_category, note, invoice_number, total_amount_of_receipt, purpose, date, inventory_number) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssisss", $cost_category, $note, $invoice_number, $total_amount_of_receipt, $purpose, $date ,$inventory_Number);

    if ($stmt->execute()) {
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

    } else {
        echo "錯誤: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>