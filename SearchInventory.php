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

// 初始化查询条件
$conditions = [];
$params = [];
$types = "";

// 收集查询条件
if (!empty($_POST['inventory_Number'])) {
    $conditions[] = "inventory_number = ?";
    $params[] = $_POST['inventory_Number'];
    $types .= "s";
}
if (!empty($_POST['regi_starting_date']) && !empty($_POST['regi_ending_date'])) {
    $conditions[] = "print_date BETWEEN ? AND ?";
    $params[] = $_POST['regi_starting_date'];
    $params[] = $_POST['regi_ending_date'];
    $types .= "ss";
}
if (!empty($_POST['tran_starting_date']) && !empty($_POST['tran_ending_date'])) {
    $conditions[] = "transfer_date BETWEEN ? AND ?";
    $params[] = $_POST['tran_starting_date'];
    $params[] = $_POST['tran_ending_date'];
    $types .= "ss";
}
if (!empty($_POST['inventory_status'])) {
    $conditions[] = "status = ?";
    $params[] = $_POST['inventory_status'];
    $types .= "s";
}
if (!empty($_POST['keyword'])) {
    $conditions[] = "(title LIKE ? OR reason LIKE ? OR plan_name LIKE ? OR budget_subject LIKE ?)";
    $keyword = "%" . $_POST['keyword'] . "%";
    $params[] = $keyword;
    $params[] = $keyword;
    $params[] = $keyword;
    $types .= "sss";
}

// 构建查询语句
$sql = "SELECT * FROM inventory";
if (count($conditions) > 0) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$stmt = $conn->prepare($sql);
if ($stmt) {
    if (!empty($types)) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $searchResults = $result->fetch_all(MYSQLI_ASSOC);

    $stmt->close();
} else {
    die("查询失败: " . $conn->error);
}

$conn->close();

// 将查询结果传递给 SearchInventory.html
session_start();
$_SESSION['searchResults'] = $searchResults;
header('Location: SearchInventory.html');
exit();
?>