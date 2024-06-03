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
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $plan_number = isset($_POST['plan_number']) ? $_POST['plan_number'] : '';
    $keyword = isset($_POST['Keyword']) ? $_POST['Keyword'] : '';

    if (!empty($plan_number) || !empty($keyword)) {
        $sql = "SELECT plan_number, plan_name FROM plan WHERE plan_number LIKE ? OR plan_name LIKE ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
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

            $stmt->close(); // 關閉stmt
        } else {
            echo "SQL 錯誤: " . $conn->error;
        }
    }
}

$conn->close();

if (!empty($plans)): ?>
    <h2>搜尋結果:</h2>
    <ul>
        <?php foreach ($plans as $plan): ?>
            <li><?php echo "計劃編號: " . htmlspecialchars($plan['plan_number']) . " - 計劃名稱: " . htmlspecialchars($plan['plan_name']); ?></li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>未找到符合的計劃。</p>
<?php endif; ?>
