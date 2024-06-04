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

$account = isset($_GET['account']) ? $_GET['account'] : '';

if (empty($account)) {
    echo "請輸入E-mail";
    exit();
}

$sql = "SELECT password FROM user WHERE account LIKE ?";
$stmt = $conn->prepare($sql);
$searchAccount = "%" . $account . "%";
$stmt->bind_param('s', $searchAccount);

$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    echo "<p>Password: " . htmlspecialchars($row['password']) . "</p>";
}

$stmt->close();
$conn->close();
?>
