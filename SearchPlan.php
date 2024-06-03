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

$plans = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $plan_number = isset($_POST['plan_number']) ? $_POST['plan_number'] : '';
    $keyword = isset($_POST['Keyword']) ? $_POST['Keyword'] : '';

    $sql = "SELECT plan_number, plan_name FROM plan WHERE plan_number LIKE ? OR plan_name LIKE ?";
    $stmt = $conn->prepare($sql);

    // 檢查是否成功準備 SQL 語句
    if ($stmt === false) {
        die("準備 SQL 語句失敗: " . $conn->error);
    }

    $searchPlanNumber = '%' . $plan_number . '%';
    $searchKeyword = '%' . $keyword . '%';
    $stmt->bind_param('ss', $searchPlanNumber, $searchKeyword);

    // 檢查是否成功綁定參數
    if ($stmt->bind_param('ss', $searchPlanNumber, $searchKeyword) === false) {
        die("綁定參數失敗: " . $stmt->error);
    }

    $stmt->execute();

    // 檢查是否成功執行語句
    if ($stmt->execute() === false) {
        die("執行語句失敗: " . $stmt->error);
    }

    $result = $stmt->get_result();

    // 檢查是否成功獲取結果
    if ($result === false) {
        die("獲取結果失敗: " . $stmt->error);
    }

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $plans[] = $row;
        }
    }

    $stmt->close();
}

$conn->close();
?>

