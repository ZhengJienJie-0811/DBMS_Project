<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "DBMS_Project";

// 建立連接
$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連接
if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $staff_id = $_POST['staff_id'];
    $password = $_POST['password'];

    // 驗證輸入
    if (empty($staff_id) || empty($password)) {
        $message = "<p style='color:red;'>帳號和密碼都是必填的。</p>";
    } else {
        // 預備查詢
        $stmt = $conn->prepare("SELECT password FROM user WHERE staff_id = ?");
        $stmt->bind_param("s", $staff_id);
        $stmt->execute();
        $stmt->store_result();

        // 檢查用戶是否存在
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashed_password);
            $stmt->fetch();

            // 驗證密碼
            if (password_verify($password, $hashed_password)) {
                header("Location: function.html");
                $_SESSION['user'] = $staff_id;
                exit();
            } else {
                $message = "<p style='color:red;'>帳號或密碼錯誤。</p>";
            }
        } else {
            $message = "<p style='color:red;'>帳號不存在。</p>";
        }

        $stmt->close();
    }
}

// 關閉連接
$conn->close();
?>