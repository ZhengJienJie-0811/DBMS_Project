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
    $staff_id = $_POST['staff_id'];
    $password = $_POST['password'];

    // 密碼加密
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (staff_id, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $staff_id, $hashed_password);

    if ($stmt->execute()) {
        echo "註冊成功";
    } else {
        echo "錯誤: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
</head>
<body>
    <div class="container">
        <form method="POST" action="Sign_up.php">
            <div class="form-group">
                <p>
                    Please enter the staff ID and default password
                </p>
            </div>
            <div class="form-group">
                <label for="staff_id">Staff ID: </label>
                <input type="text" id="staff_id" name="staff_id" required>
            </div>
            <div class="form-group">
                <label for="password">Password: </label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="submitbtn">Register</button>
        </form>
    </div>
</body>
</html>
