<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Web</title>
    <style>
        ul.menu {
            margin: 0px;
            padding: 0px;
        }
        li.menu {
            display: inline;
            font-size: 20px;
        }
        a.menu {
            color: blue;
            margin-right: 5px;
            padding: 5px;
            text-decoration: none;
            border-style: solid;
            border-width: 1px;
            border-radius: 10px;
        }
        a.menu:hover {
            background-color: blue;
            color: white;
        }
        a.active {
            background-color: red;
            color: yellow;
        }
        #content {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<?php
    // 1. Nhận giá trị id từ URL
    $id = null;
    if(isset($_GET["id"])){
        $id = $_GET["id"];
    }

    // 2. Nhúng file cấu hình và kết nối database
    include_once("db_config.php");
    
    $cn = new mysqli($servername, $username, $password, $dbname);
    if($cn->connect_error){
        die("Lỗi kết nối: " . $cn->connect_error);
    }

    // 3. Truy vấn lấy danh sách menu và hiển thị
    $sql = "select id, title from pages order by id";
    $result = $cn->query($sql);

    echo "<ul class='menu'>";
    while($row = $result->fetch_assoc()){
        // Nếu ban đầu vào trang chưa có id, mặc định lấy id của dòng đầu tiên làm active
        if($id == null){
            $id = $row["id"];
        }

        $active = "";
        if ($row["id"] == $id){
            $active = "active";
        }
        echo "<a class='menu {$active}' href='?id={$row['id']}'><li class='menu'>{$row['title']}</li></a>";
    }
    echo "</ul>";

    // 4. Truy vấn lấy content tương ứng với id đang active và hiển thị
    if($id != null){
        $sql = "select content from pages where id={$id}";
        $result = $cn->query($sql);
        $row = $result->fetch_assoc();
        
        echo "<div id='content'>{$row['content']}</div>";
    }

    // 5. Đóng kết nối
    $fclose = $cn->close();
?>

</body>
</html>
