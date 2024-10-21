<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="headers.css">
    <link rel="stylesheet" href="carousel.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <div class="container-fluid">
        <img src="Asiatiqe.png" alt="เว็บไซต์ตัวอย่าง" style="display: block; margin: auto; width: 10%; height: auto;">
        <header class="py-3">
            <ul class="nav-pills">
                <a href="#">หน้าแรก</a>
                <a href="#">ข้อมูลสถานที่ท่องเที่ยว</a>
                <a href="#">เกี่ยวกับ</a>
            </ul>
        </header>
    </div>

    <main>
        <div class="slideshow-container">

            <div class="mySlides fade">

                <img src="img_nature_wide1.jpg" style="width:100%">

            </div>

            <div class="mySlides fade">

                <img src="img_snow_wide1.jpg" style="width:100%">

            </div>

            <div class="mySlides fade">

                <img src="img_mountains_wide1.jpg" style="width:100%">

            </div>

            <a class="prev" onclick="plusSlides(-1)">❮</a>
            <a class="next" onclick="plusSlides(1)">❯</a>

        </div>

        <div class="text">
            <h1 class="textasiatiqe">แผนที่แสดงเอเชียทีค เดอะ ริเวอร์ฟร้อนท์</h1>
        </div>

        <div class="container">
            <div class="map-asiatique">
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "dbproject";

                    $conn = new mysqli($servername, $username, $password, $dbname);
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // รับค่า subtopics จากฟอร์ม
                    $subtopicIds = array(
                        $_POST["subtopic"],
                        $_POST["subtopic2"],
                        $_POST["subtopic3"],
                        $_POST["subtopic4"],
                        $_POST["subtopic5"],
                        $_POST["subtopic6"],
                        $_POST["subtopic7"]
                    );

                    // แปลงค่าใน $subtopicIds เป็นตัวเลขและกำจัดค่าว่าง
                    $selectedSubtopics = array_filter(array_map('intval', $subtopicIds));

                    // ตรวจสอบว่า $selectedSubtopics ไม่ว่าง
                    if (!empty($selectedSubtopics)) {
                        // ถ้ามีการเลือก subtopic เพียงตัวเดียวหรือไม่มีการเลือกเลย
                        if (count($selectedSubtopics) <= 1) {
                            $subtopicString = reset($selectedSubtopics); // ใช้ค่าแรกในอาร์เรย์
                            $imageQuery = $conn->prepare("SELECT image_path FROM image WHERE P_ID = ?");
                        } else {
                            // ถ้ามีการเลือก subtopic มากกว่าหนึ่งตัว
                            $subtopicString = implode(",", $selectedSubtopics);
                            $imageQuery = $conn->prepare("SELECT image_path FROM image WHERE P_ID IN (?)");
                        }

                        // แทนที่ , ด้วยสตริงที่ว่างหรือตัดออก
                        $subtopicString = str_replace(',', '', $subtopicString);

                        // ทำการ bind parameter และ execute query
                        $imageQuery->bind_param("s", $subtopicString);
                        $imageQuery->execute();
                        $imageQuery->bind_result($imageData);

                        echo "<div class='gallery-container'>";

                        while ($imageQuery->fetch()) {
                            $base64Image = base64_encode($imageData);
                            echo "<img src='data:image/png;base64,$base64Image' class='gallery-image' width='650' height='750'>";
                        }

                        echo "</div>";

                        $imageQuery->close();
                    } else {
                        echo "Please select at least one subtopic.";
                    }

                    $conn->close();
                }
                ?>

                <div class="right-boxes">
                    <div class="box box1">
                        <h3>เลือกวิธีการมา-กลับ</h3>
                        <br>
                        <form action="index.php" method="post">
                            <label for="topic">เลือกวิธีการมา</label>
                            <select name="topic" id="topic">
                                <option value="">Select...</option>
                                <?php
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
                            </select>
                            <br>
                            <label for="topic2">เลือกวิธีการกลับ</label>
                            <select name="topic2" id="topic2">
                                <option value="">Select...</option>
                                <?php
                                $conn = new mysqli($servername, $username, $password, $dbname);
                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                $topicQuery = $conn->query("SELECT gate_ID, gate_name FROM gate");
                                while ($topic2 = $topicQuery->fetch_assoc()) {
                                    echo "<option value='{$topic2['gate_ID']}'>{$topic2['gate_name']}</option>";
                                }

                                $conn->close();
                                ?>
                            </select>
                            <br>
                        </form>
                        <br>
                    </div>
                    <br>
                    <div class="box box2">
                        <h3>เลือกสถานที่</h3>
                        <br>
                        <form action="index.php" method="post">
                            <label for="subtopic">เลือกสถานที่ 1</label>
                            <select name="subtopic" id="subtopic">
                                <option value="">Select...</option>
                                <!-- Options will be populated dynamically based on the selected main topic using JavaScript -->
                            </select>
                            <br>
                            <label for="subtopic2">เลือกสถานที่ 2</label>
                            <select name="subtopic2" id="subtopic2">
                                <option value="">Select...</option>
                                <!-- Options will be populated dynamically based on the selected main topic using JavaScript -->
                            </select>
                            <br>
                            <label for="subtopic3">เลือกสถานที่ 3</label>
                            <select name="subtopic3" id="subtopic3">
                                <option value="">Select...</option>
                                <!-- Options will be populated dynamically based on the selected main topic using JavaScript -->
                            </select>
                            <br>
                            <label for="subtopic4">เลือกสถานที่ 4</label>
                            <select name="subtopic4" id="subtopic4">
                                <option value="">Select...</option>
                                <!-- Options will be populated dynamically based on the selected main topic using JavaScript -->
                            </select>
                            <br>
                            <label for="subtopic5">เลือกสถานที่ 5</label>
                            <select name="subtopic5" id="subtopic5">
                                <option value="">Select...</option>
                                <!-- Options will be populated dynamically based on the selected main topic using JavaScript -->
                            </select>
                            <br>
                            <label for="subtopic6">เลือกสถานที่ 6</label>
                            <select name="subtopic6" id="subtopic6">
                                <option value="">Select...</option>
                                <!-- Options will be populated dynamically based on the selected main topic using JavaScript -->
                            </select>
                            <br>
                            <label for="subtopic7">เลือกสถานที่ 7</label>
                            <select name="subtopic7" id="subtopic7">
                                <option value="">Select...</option>
                                <!-- Options will be populated dynamically based on the selected main topic using JavaScript -->
                            </select>
                            <br>
                            <br>
                            <button class="button" name="submit">Show Images</button>
                            <br>
                        </form>

                        <!-- Image Gallery Container -->
                        <div id="imageGallery" class="gallery-container">
                            <!-- Images will be displayed here dynamically based on user selection -->
                        </div>

                        <!-- Download All Images Button -->
                        <?php
                        if (!empty($selectedSubtopics)) {
                            echo "<a href='download_images.php?subtopics=" . implode(',', $selectedSubtopics) . "'><button>Download All Images</button></a>";
                        }
                        ?>
                    </div>
                        <div id="id01" class="modal">
                            <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
                            <form class="modal-content" >
                                <div class="container-qq">
                                
                                <img id="imageToDownload" src="Photo/asiatique-NewMap.png" alt="Your Image" class="left-image">

                                <div class="clearfix">
                                    <button type="button" class="cancelbtn" id="downloadButton">ดาวน์โหลดแผนที่</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <button type="button" class="deletebtn" onclick="document.getElementById('id02').style.display='block'; document.getElementById('id01').style.display='none'">เสร็จสิ้น</button>
                                </div>
                                
                                </div>
                            </form>
                        </div>

                </div>
            </div>
        </div>
    </main>

    <br>
    <footer>
        <p>©2024 WWW.TEST.COM. ALL RIGHTS RESERVED.</p>
    </footer>

    <script>
        // JavaScript to populate subtopic options based on the selected main topic
        const topicSelect = document.getElementById("topic");
const topicSelect2 = document.getElementById("topic2");
const subtopicSelect = document.getElementById("subtopic");
const subtopicSelect2 = document.getElementById("subtopic2");
const subtopicSelect3 = document.getElementById("subtopic3");
const subtopicSelect4 = document.getElementById("subtopic4");
const subtopicSelect5 = document.getElementById("subtopic5");
const subtopicSelect6 = document.getElementById("subtopic6");
const subtopicSelect7 = document.getElementById("subtopic7");
const imageGallery = document.getElementById("imageGallery");

function fetchSubtopics(topicId, ...subtopicDropdowns) {
    const promises = subtopicDropdowns.map((subtopicDropdown) => {
        return fetch(`room.php?gate_ID=${topicId}`)
            .then(response => response.json())
            .then(subtopics => {
                // Clear existing options
                subtopicDropdown.innerHTML = "<option value=''>Select...</option>";

                // Populate new options
                subtopics.forEach(subtopic => {
                    const option = document.createElement("option");
                    option.value = subtopic.id;
                    option.textContent = subtopic.name;
                    subtopicDropdown.appendChild(option);
                });
            });
    });

    return Promise.all(promises);
}

function fetchImages(topicId, subtopicId) {
    fetch(`index.php?topic=${topicId}&subtopic=${subtopicId}`)
        .then(response => response.text())
        .then(html => {
            imageGallery.innerHTML = html;
        });
}

function handleTopicChange() {
    const topicId = topicSelect.value;
    const topicId2 = topicSelect2.value;

    fetchSubtopics(topicId, subtopicSelect,subtopicSelect2,subtopicSelect3);
    fetchSubtopics(topicId2, subtopicSelect4,subtopicSelect5,subtopicSelect6, subtopicSelect7);
}

function handleImageGalleryChange() {
    const topicId = topicSelect.value;
    const subtopicId = subtopicSelect.value;

    fetchImages(topicId, subtopicId);
}

// Attach event listeners
topicSelect.addEventListener("change", handleTopicChange);
topicSelect2.addEventListener("change", handleTopicChange);
imageGallery.addEventListener("change", handleImageGalleryChange);

// Initial fetch for subtopics based on default selections
const initialTopicId = topicSelect.value;
const initialTopicId2 = topicSelect2.value;
fetchSubtopics(initialTopicId, subtopicSelect,subtopicSelect2,subtopicSelect3);
fetchSubtopics(initialTopicId2, subtopicSelect4,subtopicSelect5,subtopicSelect6, subtopicSelect7);

        
    </script>
</body>
</html>