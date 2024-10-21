<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับคะแนนจาก request
    $rating = $_POST["rating"];

    // เชื่อมต่อกับฐานข้อมูล MySQL
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbproject";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // สร้างคำสั่ง SQL เพื่อบันทึกคะแนน
    $sql = "INSERT INTO ratings (rating) VALUES ('$rating')";

    if ($conn->query($sql) === TRUE) {
        echo "Rating saved successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
