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

// 顯示接收到的表單數據
echo "<!DOCTYPE html>
<html>
<head>
    <link rel='stylesheet' type='text/css' href='style.css'>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Form Inputs</title>
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
        <p><a href='function.html'>Back to Search</a></p>
    </div>
</body>
</html>";
?>
