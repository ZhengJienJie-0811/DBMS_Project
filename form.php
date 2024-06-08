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
    $print_date = $_POST['print_date'];
    $budget_subject = $_POST['budget_subject'];
    $plan_number = $_POST['plan_number'];
    $title = $_POST['title'];
    $reason = $_POST['plan_number']. "_" . $_POST['budget_subject'];
    $document_code = '';
    $inventory_number = '';
    $underLine = '_';
    $array = explode($underLine, $reason);
    $document_amount = $_POST['document_amount'];
    $total_amount = $_POST['total_amount'];
    $quantity = $_POST['quantity'];

    $_SESSION['quantity'] = $quantity;

    if (count($array) == 2) {
        $plan_number = $array[0];
        $budget_subject = $array[1];
    } else {
        echo "The string does not contain the expected format.\n";
    }

    function generateDc() {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // 設置版本號為0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // 設置變種為10
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    function generateIn() {
        $data = random_bytes(5);
        $hexString = bin2hex($data);
        $customString = substr($hexString, 0, 10);
        return $customString;
    }
    
    $document_code = generateDc();
    $inventory_number = generateIn();

    // 从会话中获取 account
    if (!isset($_SESSION['account'])) {
        echo "用戶未登錄。\n";
        exit();
    } else {
        $account = $_SESSION['account'];
    }

    $sql1 = "INSERT INTO inventory (document_code, inventory_number, plan_number, budget_subject, print_date, title, account) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->bind_param("sssssss", $plan_name, $document_code, $inventory_number, $plan_number, $budget_subject, $print_date, $title, $account);

    $sql2 = "INSERT INTO receipt_keeping_list (total_amount, plan_number, budget_subject, document_amount, inventory_number) VALUES (?, ?, ?, ?, ?)";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param("issis", $total_amount, $plan_number, $budget_subject, $document_amount, $inventory_number);

    if ($stmt1->execute() && $stmt2->execute()) {
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
        echo "錯誤" ;
    }

    $stmt1->close();
    $stmt2->close();
}

$conn->close();
?>
