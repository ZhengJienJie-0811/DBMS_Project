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
    $unit_code = $_POST['unit_code'];
    $print_date = $_POST['print_date'];
    $title = $_POST['title'];
    $reason = $_POST['reason'];
    $plan_name = $_POST['plan_name'];

    $sql = "INSERT INTO inventory (unit_code, print_date, title, reason, plan_name) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $unit_code, $print_date, $title, $reason, $plan_name);

    if ($stmt->execute()) {
        echo "資料儲存成功";
    } else {
        echo "錯誤: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>