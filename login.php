<?php
$servername = "localhost";  // 資料庫伺服器
$username = "root";         // 資料庫使用者名稱
$password = "";             // 資料庫密碼
$dbname = "your_database";  // 資料庫名稱

// 創建連接
$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連接
if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}

// 獲取表單提交的數據
$user = $_POST['username'];
$pass = $_POST['password'];

// 避免 SQL 注入
$user = $conn->real_escape_string($user);
$pass = $conn->real_escape_string($pass);

// 查詢資料庫
$sql = "SELECT * FROM users WHERE username = '$user' AND password = '$pass'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // 成功登入
    echo "登入成功！";
} else {
    // 登入失敗
    echo "用戶名或密碼錯誤。";
}

$conn->close();
?>
