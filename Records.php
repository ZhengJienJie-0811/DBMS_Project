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
    $plan_number = $_POST['plan_number'];
    $budget_number = $_POST['budget_number'];
    $document_amount = $_POST['document_amount'];
    $total_amount = $_POST['total_amount'];

    $sql = "INSERT INTO receipt_keeping_list (total_amount,plan_number,budget_subject,document_amount) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdd", $plan_number, $budget_number, $document_amount, $total_amount);

    if ($stmt->execute()) {
        echo "新紀錄新增成功";
    } else {
        echo "錯誤: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>