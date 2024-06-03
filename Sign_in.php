<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "DBMS_Project";

// 启用错误报告
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 建立连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 检查连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $staff_id = $_POST['staff_id'];
    $password = $_POST['password'];

    // 验证输入
    if (empty($staff_id) || empty($password)) {
        $message = "帳號與密碼都是必填的。";
    } else {
        // 预备查询
        $stmt = $conn->prepare("SELECT password FROM user WHERE staff_id = ?");
        if ($stmt === false) {
            die("預備查詢失敗: " . $conn->error);
        }
        $stmt->bind_param("s", $staff_id);
        $stmt->execute();
        $stmt->store_result();

        // 检查用户是否存在
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($stored_password);
            $stmt->fetch();
            

            // 验证密码
            if ($password == $stored_password) { // 直接比较密码
                $_SESSION['user'] = $staff_id;
                echo "Password verification successful.<br>";
                // 确保没有输出在 header 前
                ob_clean();
                header("Location: function.html");
                exit();
            } else {
                $message = "帳號或密碼錯誤。";
                echo $message . "<br>";
            }
        } else {
            $message = "帳號不存在。";
            echo $message . "<br>";
        }

        $stmt->close();
    }
}