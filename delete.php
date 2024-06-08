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
    die("連接失败: " . $conn->connect_error);
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
            echo "<html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Delete Success</title>
                <style>
                    body { font-family: Arial, sans-serif; }
                    .container { text-align: center; margin-top: 50px; }
                    .btn { display: inline-block; padding: 10px 20px; font-size: 16px; text-decoration: none; color: white; background-color: #4CAF50; border: none; border-radius: 5px; }
                    .btn:hover { background-color: #45a049; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <h1>删除成功</h1>
                    <p>請點擊按钮返回</p>
                    <form method='POST' action='function.html'>
                        <button type='submit' class='btn'>返回</button>
                    </form>
                </div>
            </body>
            </html>";
        } else {
            echo "删除失败: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "未找到 inventory_number。";
    }
}

// 关闭数据库连接
$conn->close();
?>
