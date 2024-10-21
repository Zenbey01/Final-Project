<?php
//เลือกหัวขอใน box 1
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbproject";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $topicQuery = $conn->query("SELECT gate_ID, gate_name FROM gate");
    while ($topic = $topicQuery->fetch_assoc()) {
        echo "<option value='{$topic['gate_ID']}'>{$topic['gate_name']}</option>";
    }

    $conn->close();
?>