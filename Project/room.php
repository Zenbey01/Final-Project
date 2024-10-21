<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbproject";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$topicId = $_GET["gate_ID"];

$subtopicQuery = $conn->prepare("SELECT route_ID, route_name  FROM route WHERE gate_ID = ?");
$subtopicQuery->bind_param("i", $topicId);
$subtopicQuery->execute();
$subtopicQuery->bind_result($subtopicId, $subtopicName);

$subtopics = array();
while ($subtopicQuery->fetch()) {
    $subtopics[] = array("id" => $subtopicId, "name" => $subtopicName);
}

$subtopicQuery->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($subtopics);
?>