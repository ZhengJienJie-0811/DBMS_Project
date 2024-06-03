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

$planName = isset($_GET['plan_name']) ? $_GET['plan_name'] : '';
$planNumber = isset($_GET['plan_number']) ? $_GET['plan_number'] : '';

$sql = "SELECT * FROM plan WHERE ";
$params = [];
$types = '';

if (!empty($planName) and empty($planNumber)) {
    $sql .= "plan_name LIKE ?";
    $params[] = "%".$planName."%";
    $types .= 's';
}
if (!empty($planNumber) and empty($planName)) {
    $sql .= "plan_number LIKE ?";
    $params[] = "%".$planNumber."%";
    $types .= 's';
}

if(!empty($planName) and !empty($planNumber)){
    $sql .= "plan_number LIKE ? and plan_name LIKE ?";
    $params[] = "%".$planNumber."%";
    $types .= 's';
}

if(empty($planName) and empty($planNumber)){
    echo"請輸入搜尋條件";
}

$stmt = $conn->prepare($sql);

if ($types && $params) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    echo "<p>Plan Name: " . htmlspecialchars($row['plan_name']) . "<br>Plan Number: " . htmlspecialchars($row['plan_number']) . "</p>";
}

$stmt->close();
$conn->close();
?>
