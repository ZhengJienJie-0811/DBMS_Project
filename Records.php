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
    $plan_number = $_POST['plan_number'];
    $budget_number = $_POST['budget_number'];
    $document_amount = $_POST['document_amount'];
    $total_amount = $_POST['total_amount'];

    $sql = "INSERT INTO records (plan_number, budget_number, document_amount, total_amount) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdd", $plan_number, $budget_number, $document_amount, $total_amount);

    if ($stmt->execute()) {
        echo "新紀錄新增成功";
    } else {
        echo "錯誤: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Records</title>
</head>
<body>
    <div class="container">
        <p>
            請輸入以下資訊！
        </p>
        <form method="POST" action="Record.php">
            <table border="1">
                <tr>
                    <th>計畫編號：</th>
                    <td>
                        <input type="text" id="plan_number" name="plan_number" required>
                    </td>
                </tr>
                <tr>
                    <th>預算科目：</th>
                    <td>
                        <input type="text" id="budget_number" name="budget_number" required>
                    </td>
                </tr>
                <tr>
                    <th>文件金額：</th>
                    <td>
                        <input type="number" step="0.01" id="document_amount" name="document_amount" required>
                    </td>
                </tr>
                <tr>
                    <th>總金額：</th>
                    <td>
                        <input type="number" step="0.01" id="total_amount" name="total_amount" required>
                    </td>
                </tr>
            </table>
            <button type="submit" class="submitbtn">下一步</button>
            <button type="button" class="btn" onclick="history.back();">返回</button>
        </form>
    </div>
</body>
</html>
