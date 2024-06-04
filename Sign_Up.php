<?php

$servername = "localhost"; // MySQL 伺服器主機名稱
$username = "root"; // MySQL 使用者名稱
$password = ""; // MySQL 密碼
$dbname = "dbms_project"; // 資料庫名稱

// 建立連線
$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連線
if ($conn->connect_error) {
    die("連線失敗: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST['password'];
    $account  = $_POST['account'];
    $name     = $_POST['name'];

    // 檢查帳號是否已存在
    $check_sql = "SELECT * FROM user WHERE  account = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $account);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        echo "錯誤: 帳號已存在。";
    } else {
    
        

        $sql = "INSERT INTO user (password, name, account) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $password, $name, $account);

        if ($stmt->execute()) {
            echo  "<html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Registration Success</title>
                <style>
                    body { font-family: Arial, sans-serif; }
                    .container { text-align: center; margin-top: 50px; }
                    .btn { display: inline-block; padding: 10px 20px; font-size: 16px; text-decoration: none; color: white; background-color: #4CAF50; border: none; border-radius: 5px; }
                    .btn:hover { background-color: #45a049; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <h1>已成功註冊</h1>
                    <p>請點選按鈕回到登入頁面</p>
                    <form method='POST' action='index.html'>
                        <button type='submit' class='btn'>返回</button>
                    </form>
                </div>
            </body>
            </html>";
        } else {
            echo "錯誤: " . $sql . "<br>" . $conn->error;
        }

        $stmt->close();
    }

    $check_stmt->close();
}

$conn->close();
?>
