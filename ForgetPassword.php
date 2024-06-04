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

$account= isset($_GET['account']) ? $_GET['account'] : '';

$sql = "SELECT password FROM user WHERE 1=1";  // 使用 1=1 來簡化條件附加
$params = [];
$types = '';

if (!empty($account)) {
    $sql .= " AND account == ?";
    $params[] = "%".$account."%";
    $types .= 's';
}
else{
    echo "請輸入E-mail";
    exit();
}

$stmt = $conn->prepare($sql);

if ($types && $params) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    echo "<p>Password: " . htmlspecialchars($row['account']) . "</p>";
}

$stmt->close();
$conn->close();
?>
