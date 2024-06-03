<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "DBMS_Project";

    // 檢查是否成功執行語句
    if ($stmt->execute() === false) {
        die("執行語句失敗: " . $stmt->error);
    }
// 建立連線
$conn = new mysqli($servername, $username, $password, $dbname);

    $result = $stmt->get_result();
// 檢查連線
if ($conn->connect_error) {
    die("連線失敗: " . $conn->connect_error);
}

    // 檢查是否成功獲取結果
    if ($result === false) {
        die("獲取結果失敗: " . $stmt->error);
    }
$plans = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $plan_number = isset($_POST['plan_number']) ? $_POST['plan_number'] : '';
    $keyword = isset($_POST['Keyword']) ? $_POST['Keyword'] : '';

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $plans[] = $row;
    if (!empty($plan_number) || !empty($keyword)) {
        $sql = "SELECT plan_number, plan_name FROM plans WHERE plan_number LIKE ? OR plan_name LIKE ?";
        $stmt = $conn->prepare($sql);
        $searchPlanNumber = '%' . $plan_number . '%';
        $searchKeyword = '%' . $keyword . '%';
        $stmt->bind_param('ss', $searchPlanNumber, $searchKeyword);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $plans[] = $row;
            }
        }
    }

    $stmt->close();
    }
    }
}
$conn->close();
?>