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
    $account = isset($_POST['account']) ? $_POST['account'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // 驗證帳號和密碼
    $sql = "SELECT staff_ID FROM user WHERE account = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $account, $password);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($staff_id);
        $stmt->fetch();
        // 設置 session 變量
        $_SESSION['staff_ID'] = $staff_id;
        // 跳轉到主頁或其他頁面
        header("Location: function.html");
        exit();
    } else {
        echo "帳號或密碼錯誤";
    }

    $stmt->close();
}

$conn->close();
?>
