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

$plan_number = isset($_POST['plan_number']) ? $_POST['plan_number'] : '';
$keyword = isset($_POST['Keyword']) ? $_POST['Keyword'] : '';

$sql = "SELECT plan_number, plan_name FROM plans WHERE plan_number LIKE ? OR plan_name LIKE ?";
$stmt = $conn->prepare($sql);
$searchPlanNumber = '%' . $plan_number . '%';
$searchKeyword = '%' . $keyword . '%';
$stmt->bind_param('ss', $searchPlanNumber, $searchKeyword);
$stmt->execute();
$result = $stmt->get_result();

$plans = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $plans[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Plan</title>
</head>
<body>
    <div class="container">
        <form method="POST" action="SearchPlan.php">
            <p>Plan Search:</p>
            <table border="1">
                <tr>
                    <th>Plan number:</th>
                    <td>
                        <input type="text" id="plan_number" name="plan_number">
                    </td>
                </tr>
                <tr>
                    <th>Keyword:</th>
                    <td>
                        <input type="text" id="Keyword" name="Keyword">
                    </td>
                </tr>
            </table>
            <button type="submit" class="submitbtn">Search</button>
        </form>

        <?php if (isset($plans) && count($plans) > 0): ?>
            <table border="1">
                <tr>
                    <th>Plan number</th>
                    <th>Plan name</th>
                </tr>
                <?php foreach ($plans as $plan): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($plan['plan_number']); ?></td>
                        <td><?php echo htmlspecialchars($plan['plan_name']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php elseif (isset($plans)): ?>
            <p>No plans found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
