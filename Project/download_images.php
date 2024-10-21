<?php
// เชื่อมต่อกับฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbproject";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// เพิ่มข้อมูลลงในฐานข้อมูล
$sql = "INSERT INTO download_logs (image_data) VALUES ('$base64Image')";
if ($conn->query($sql) === TRUE) {
    echo "Record added successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

<script>
function recordDownload() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "record_download.php?image=<?php echo $base64Image; ?>", true);
    xhr.send();
}
</script>
