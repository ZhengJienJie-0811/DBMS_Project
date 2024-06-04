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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $print_date = $_POST['print_date'];
    $title = $_POST['title'];
    $reason = $_POST['reason'];
    $plan_name = $_POST['plan_name'];
    $staff_ID = '';
    $budget_subjet = '';
    $plan_number = ''; 
    $document_code = '';
    $inventory_number = '';
    $underLine = '_';
    $array = explode($underLine, $reason);
    if (count($array) == 2) {
        $plan_number = $array[0];
        $budget_subject = $array[1];
    }else{
        echo "The string does not contain the expected format.\n";
    }

    function generateDc() {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // 設置版本號為0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // 設置變種為10
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    function generateIn() {
        $data = random_bytes(5);
        $hexString = bin2hex($data);
        $customString = substr($hexString, 0, 10);
        return $customString;
    }
    
    $document_code = generateDc();
    $inventory_number = generateIn();

       // 从会话中获取 account
       if (isset($_SESSION['account'])) {
        $staff_ID = $_SESSION['account'];
    } else {
        echo "用戶未登錄。\n";
        exit();
    }


    $sql = "INSERT INTO inventory (plan_name,document_code,inventory_number,plan_number,budget_subject,print_date,title, staff_ID) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $plan_name, $document_code, $inventory_number, $plan_number, $budget_subject, $print_date, $title, $staff_ID);

    if ($stmt->execute()) {
        header('Location:Records.html');
    } else {
        echo "錯誤: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>