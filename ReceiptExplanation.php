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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'];
    $invoice_number = $_POST['invoice_number'];
    $total_amount_of_receipt = $_POST['total_amount_of_receipt'];
    $cost_category = $_POST['cost_category'];
    $purpose = $_POST['purpose'];
    $note = $_POST['note'];

    $sql = "INSERT INTO receipts (date, invoice_number, total_amount_of_receipt, cost_category, purpose, note) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $date, $invoice_number, $total_amount_of_receipt, $cost_category, $purpose, $note);

    if ($stmt->execute()) {
        echo "資料儲存成功";
    } else {
        echo "錯誤: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>