<?php
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

if (!isset($_SESSION['inventory_number'])) {
    echo "無法找到 inventory_number。\n";
    exit();
} else {
    $inventory_number = $_SESSION['inventory_number'];
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $plan_number = $_POST['plan_number'];
    $budget_subject = $_POST['budget_subject'];
    $document_amount = $_POST['document_amount'];
    $total_amount = $_POST['total_amount'];

    $sql = "INSERT INTO receipt_keeping_list (total_amount, plan_number, budget_subject, document_amount) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issi", $total_amount, $plan_number, $budget_subject, $document_amount);

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
                <p>請點選按鈕到下一步</p>
                <form method='POST' action='ReceiptExplanation.html'>
                    <button type='submit' class='btn'>Next</button>
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