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
    $staff_id = $_POST['staff_id'];
    $password = $_POST['password'];

    // 密碼加密
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO user (staff_id, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $staff_id, $hashed_password);

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
                <h1>Registration Successful</h1>
                <p>You have successfully registered.</p>
                <form method='POST' action='index.html'>
                    <button type='submit' class='btn'>Back</button>
                </form>
            </div>
        </body>
        </html>";

    } else {
        echo "錯誤: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
