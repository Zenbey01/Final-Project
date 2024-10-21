
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbproject";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    
    $subtopic = $_POST["subtopic"];

    
    echo "Subtopic: " . $subtopic;

    mysqli_close($conn);
} else {
    // หากไม่มีข้อมูลที่ส่งมา แสดงข้อความว่าไม่มีข้อมูล
    echo "ไม่มีข้อมูลที่ส่งมา";
}

?>
