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

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "DBMS_Project";

// 建立連線
$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連線
if ($conn->connect_error) {
    die("連線失敗: " . $conn->connect_error);
}

$plans = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $plan_number = isset($_POST['plan_number']) ? $_POST['plan_number'] : '';
    $keyword = isset($_POST['Keyword']) ? $_POST['Keyword'] : '';

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
}

$conn->close();
?>



