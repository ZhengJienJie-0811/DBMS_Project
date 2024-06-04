<?php
session_start();

// 從表單中接收數據
$inventory_Number = isset($_POST['inventory_Number']) ? $_POST['inventory_Number'] : '';
$regi_starting_date = isset($_POST['regi_starting_date']) ? $_POST['regi_starting_date'] : '';
$regi_ending_date = isset($_POST['regi_ending_date']) ? $_POST['regi_ending_date'] : '';
$tran_starting_date = isset($_POST['tran_starting_date']) ? $_POST['tran_starting_date'] : '';
$tran_ending_date = isset($_POST['tran_ending_date']) ? $_POST['tran_ending_date'] : '';
$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';

// 連接資料庫
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "DBMS_Project";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 構建查詢語句
$sql = "SELECT print_date, inventory_number, title FROM inventory WHERE 1=1";

$conditions = [];

if (!empty($inventory_Number)) {
    $conditions[] = "inventory_number LIKE '%$inventory_Number%'";
}

if (!empty($regi_starting_date) && !empty($regi_ending_date)) {
    $conditions[] = "print_date BETWEEN '$regi_starting_date' AND '$regi_ending_date'";
}

if (!empty($tran_starting_date) && !empty($tran_ending_date)) {
    $conditions[] = "print_date BETWEEN '$tran_starting_date' AND '$tran_ending_date'";
}

if (!empty($keyword)) {
    $conditions[] = "plan_name LIKE '%$keyword%' OR title LIKE '%$keyword% OR document_code LIKE '%$keyword% OR inventory_number LIKE '%$keyword% OR budget_subject LIKE '%$keyword%'";
}

if (count($conditions) > 0) {
    $sql .= " AND " . implode(" AND ", $conditions);
}

// 執行查詢
$result = $conn->query($sql);

// 存儲查詢結果
$searchResults = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $searchResults[] = $row;
    }
}

$conn->close();

// 顯示接收到的表單數據和搜尋結果
echo "<!DOCTYPE html>
<html>
<head>
    <link rel='stylesheet' type='text/css' href='style.css'>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Form Inputs and Search Results</title>
</head>
<body>
    <div class='container'>
        <h2>Received Form Inputs</h2>
        <table border='1'>
            <tr><th>Field</th><th>Value</th></tr>
            <tr><td>Inventory Number</td><td>" . htmlspecialchars($inventory_Number) . "</td></tr>
            <tr><td>Starting Date of Registration</td><td>" . htmlspecialchars($regi_starting_date) . "</td></tr>
            <tr><td>Ending Date of Registration</td><td>" . htmlspecialchars($regi_ending_date) . "</td></tr>
            <tr><td>Starting Date of Transfer</td><td>" . htmlspecialchars($tran_starting_date) . "</td></tr>
            <tr><td>Ending Date of Transfer</td><td>" . htmlspecialchars($tran_ending_date) . "</td></tr>
            <tr><td>Inventory Status</td><td>" . htmlspecialchars($inventory_status) . "</td></tr>
            <tr><td>Keyword</td><td>" . htmlspecialchars($keyword) . "</td></tr>
        </table>
        
        <h2>Search Results</h2>
        <table border='1'>
            <tr>
                <th>Date</th>
                <th>Inventory number</th>
                <th>Title</th>
            </tr>";

if (count($searchResults) > 0) {
    foreach ($searchResults as $row) {
        echo "<tr>
                <td>" . htmlspecialchars($row['print_date']) . "</td>
                <td>" . htmlspecialchars($row['inventory_number']) . "</td>
                <td>" . htmlspecialchars($row['title']) . "</td>
              </tr>";
    }
}

echo "        </table>
        <p><a href='function.html'>Back to Search</a></p>
    </div>
</body>
</html>";
?>
