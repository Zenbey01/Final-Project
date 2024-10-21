<?php
// รับค่า จากหน้า index.php 
if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbproject";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // รับค่า subtopics จากฟอร์ม
    $subtopicIds = array($_POST["subtopic"]);

    // แปลงค่าใน $subtopicIds เป็นตัวเลขและกำจัดค่าว่าง
    $selectedSubtopics = array_filter(array_map('intval', $subtopicIds));

    // ตรวจสอบว่า $selectedSubtopics ไม่ว่าง
    if (!empty($selectedSubtopics)) {
        // ถ้ามีการเลือก subtopic เพียงตัวเดียวหรือไม่มีการเลือกเลย
        if (count($selectedSubtopics) <= 1) {
            $subtopicString = reset($selectedSubtopics); // ใช้ค่าแรกในอาร์เรย์
            $imageQuery = $conn->prepare("SELECT image_path, linkmap FROM image WHERE P_ID = ?");
        } else {
            // ถ้ามีการเลือก subtopic มากกว่าหนึ่งตัว
            $subtopicString = implode(",", $selectedSubtopics);
            $imageQuery = $conn->prepare("SELECT image_path, linkmap FROM image WHERE P_ID IN (?)");
        }

        // แทนที่ , ด้วยสตริงที่ว่างหรือตัดออก
        $subtopicString = str_replace(',', '', $subtopicString);

        // ทำการ bind parameter และ execute query
        $imageQuery->bind_param("s", $subtopicString);
        $imageQuery->execute();
        $imageQuery->bind_result($imageData, $linkmap);

        echo "<div class='gallery-container'>";

        while ($imageQuery->fetch()) {
            $base64Image = base64_encode($imageData);

            $linkmapShow = "";
            echo "<div class='gallery-item'>";
            echo "<img src='data:image/png;base64,$base64Image' class='gallery-image' style='max-width: 100%; max-height: 100%;' alt='Image'>";
            echo "</div>";

            echo "<div class='linkmap'>";
            echo "<a href='data:image/png;base64,$base64Image' class='btnDownload' download>";
            echo "<span class='button-text'>Download Image</span>";
            echo "</a>";
            echo "<a href='$linkmap' target='_blank'>$linkmapShow Link Map</a>";
            echo "</div>";

            echo "<br>";
        
            echo "<div class='clearfix' style='text-align: center;'>";
            echo "<button type='button' class='btnNextgo-on' onclick=\"document.getElementById('id01').style.display='none';\">เลือกใหม่</button>";
            echo "<button type='button' class='btnNextgo-on' onclick=\"document.getElementById('id02').style.display='block'; document.getElementById('id01').style.display='none'\">เสร็จสิ้น</button>";
            echo "</div>";
            
            


        }

        echo "</div>";

        $imageQuery->close();
        $showAsiatiqueImage = false; // หลังจากแสดงรูปภาพตาม subtopic แล้ว ไม่ต้องแสดง Asiatique อีก
    } else {
        echo "<div class='clearfix'>";
        echo "~โปรดเลือกวิธีการมา~";
        echo "<br>";
        echo "<button type='button' class='btnNextgo-on' onclick=\"document.getElementById('id01').style.display='none'\">ปิด</button>";
        echo "</div>";
    }

    $conn->close();
}
?>


<?php
// เก็บค่าการเลือกสาถานที่
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbproject";

$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตรวจสอบว่ามีการส่งข้อมูลจากฟอร์มหรือไม่
if(isset($_POST['submit'])) {
    // ตรวจสอบว่ามีค่าที่ส่งมาหรือไม่
    if(!empty($_POST['subtopic'])) {
        $location = $_POST['subtopic'];

        // สร้างคำสั่ง SQL เพื่อเพิ่มข้อมูลลงในฐานข้อมูล
        $sql = "INSERT INTO selections (location) VALUES ('$location')";

        // ทำการเพิ่มข้อมูล
        if ($conn->query($sql) === TRUE) {
            echo "";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "";
    }
}


// ปิดการเชื่อมต่อกับฐานข้อมูล
$conn->close();
?>

<?php
// เก็บค่าการกดดาวโหลดรูปภาพ
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbproject";

// ตรวจสอบว่ามีค่า $base64Image ที่ไม่ว่างหรือไม่
if(isset($base64Image) && !empty($base64Image)) {
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // เพิ่มข้อมูลลงในฐานข้อมูล
    $sql = "INSERT INTO download_logs (image_data) VALUES ('$base64Image')";
    if ($conn->query($sql) === TRUE) {
        echo "";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
 
    $conn->close();
} else {
    echo "";
}
?>









