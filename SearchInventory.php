<?php
session_start();

// 從表單中接收數據
$inventory_Number = isset($_POST['inventory_Number']) ? $_POST['inventory_Number'] : '';
$regi_starting_date = isset($_POST['regi_starting_date']) ? $_POST['regi_starting_date'] : '';
$regi_ending_date = isset($_POST['regi_ending_date']) ? $_POST['regi_ending_date'] : '';
$tran_starting_date = isset($_POST['tran_starting_date']) ? $_POST['tran_starting_date'] : '';
$tran_ending_date = isset($_POST['tran_ending_date']) ? $_POST['tran_ending_date'] : '';
$inventory_status = isset($_POST['inventory_status']) ? $_POST['inventory_status'] : '';
$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';

// 連接數據庫
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

/*
if (!empty($inventory_status)) {
    $conditions[] = "inventory_status = '$inventory_status'";
}
*/

if (!empty($keyword)) {
    $conditions[] = "(plan_name LIKE '%$keyword%' OR title LIKE '%$keyword%')";
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

$_SESSION['searchResults'] = $searchResults;

$conn->close();


header("Location: SearchInventory.html");
exit();
?>
