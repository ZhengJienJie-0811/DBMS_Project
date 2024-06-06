<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "DBMS_Project";

// 创建数据库连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 检查连接是否成功
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

// 检查是否是 POST 请求
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 从会话中获取 inventory_number
    if (isset($_SESSION['inventory_number'])) {
        $inventory_number = $_SESSION['inventory_number'];

        // 使用 inventory_number 删除记录
        $sql = "DELETE FROM inventory WHERE inventory_number = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $inventory_number);

        if ($stmt->execute()) {
            echo "删除成功";
        } else {
            echo "删除失敗: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "未找到 inventory_number。";
    }
}

// 关闭数据库连接
$conn->close();
?>
