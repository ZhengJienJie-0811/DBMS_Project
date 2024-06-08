<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "DBMS_Project";

// 創建連接
$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連接
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$planName = isset($_GET['plan_name_keyword']) ? $_GET['plan_name_keyword'] : '';
$planNumber = isset($_GET['plan_number']) ? $_GET['plan_number'] : '';

$sql = "SELECT * FROM plan WHERE 1=1";  // 使用 1=1 來簡化條件附加
$params = [];
$types = '';

if (!empty($planName)) {
    $sql .= " AND plan_name LIKE ?";
    $params[] = "%".$planName."%";
    $types .= 's';
}

if (!empty($planNumber)) {
    $sql .= " AND plan_number LIKE ?";
    $params[] = "%".$planNumber."%";
    $types .= 's';
}

if(empty($planName) && empty($planNumber)){
    echo "請輸入搜尋條件";
    exit();
}

$stmt = $conn->prepare($sql);

if ($types && $params) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();  // 获取结果集

if ($result->num_rows > 0) {
    // 輸出數據
    while($row = $result->fetch_assoc()) {
        echo "Plan Name: " . $row["plan_name"]. " - Plan Number: " . $row["plan_number"]. "<br>";
    }
} else {
    echo "No results found.";
}

$stmt->close();
$conn->close();
?>
