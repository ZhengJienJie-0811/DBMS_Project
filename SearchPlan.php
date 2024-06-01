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

$results = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $plan_number = $_POST['plan_number'];
    $keyword = $_POST['keyword'];

    $sql = "SELECT * FROM plans WHERE plan_number LIKE ? AND keyword LIKE ?";
    $stmt = $conn->prepare($sql);
    $like_plan_number = "%" . $plan_number . "%";
    $like_keyword = "%" . $keyword . "%";
    $stmt->bind_param("sss", $like_plan_number, $like_keyword);

    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $results[] = $row;
    }

    $stmt->close();
}

$conn->close();
?>