<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登入頁面</title>
</head>
<body>
    <div class="container">
        <h2>登入</h2>
        <?php
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

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $staff_ID = $_POST['staff_ID'];
            $password = $_POST['password'];

            // 驗證輸入
            if (empty($staff_ID) || empty($password)) {
                echo "<p style='color:red;'>帳號和密碼都是必填的。</p>";
            } else {
                // 預備查詢
                $stmt = $conn->prepare("SELECT password FROM users WHERE account = ?");
                $stmt->bind_param("s", $account);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($hashed_password);
                    $stmt->fetch();

                    // 驗證密碼
                    if (password_verify($password, $hashed_password)) {
                        echo "<p style='color:green;'>登入成功！</p>";
                    } else {
                        echo "<p style='color:red;'>密碼錯誤。</p>";
                    }
                } else {
                    echo "<p style='color:red;'>帳號不存在。</p>";
                }

                $stmt->close();
            }
        }

        // 關閉連接
        $conn->close();
        ?>
        <form action="Sign_in.php" method="post">
            <div class="form-group">
                <label for="username">用戶名： </label>
                <input type="text" id="account" name="account" required>
            </div>
            <div class="form-group">
                <label for="password">密碼： </label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="submitbtn">登入</button>
            <p><a href="Sign_Up.html">註冊</a></p>
            <p><a href="ForgetPassword.html">忘記密碼？</a></p>
        </form>
    </div>
</body>
</html>
