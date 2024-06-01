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
    if (empty($account) || empty($password)) {
        $message = "<p style='color:red;'>帳號和密碼都是必填的。</p>";
    } else {
        // 預備查詢
        $stmt = $conn->prepare("SELECT password FROM users WHERE Staff_ID = ?");
        $stmt->bind_param("s", $staff_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashed_password);
            $stmt->fetch();

            // 驗證密碼
            if (password_verify($password, $hashed_password)) {
                $_SESSION['user'] = $account;
                $message = "<p style='color:green;'>登入成功！</p>";
                header("Location:function.html");
                exit();
            } else {
                $message = "<p style='color:red;'>密碼錯誤。</p>";
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