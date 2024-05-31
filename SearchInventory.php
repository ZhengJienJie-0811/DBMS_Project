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
    $date = $_POST['date'] ?? '';
    $inventory_number = $_POST['inventory_number'] ?? '';
    $title = $_POST['title'] ?? '';

    $sql = "SELECT * FROM inventory WHERE date LIKE ? AND inventory_number LIKE ? AND title LIKE ?";
    $stmt = $conn->prepare($sql);
    $like_date = "%" . $date . "%";
    $like_inventory_number = "%" . $inventory_number . "%";
    $like_title = "%" . $title . "%";
    $stmt->bind_param("sss", $like_date, $like_inventory_number, $like_title);

    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $results[] = $row;
    }

    $stmt->close();
}

$conn->close();
?>