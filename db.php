<?php
// Cấu hình thông số kết nối
$host = "localhost";
$user = "root";
$pass = "";
$db   = "quan_li_khach_san";
$port = 3306; // Cổng 3307 khớp với cấu hình MySQL trong XAMPP của bạn

// Tạo kết nối bằng MySQLi
$conn = new mysqli($host, $user, $pass, $db, $port);

// Kiểm tra kết nối
if ($conn->connect_error) {
    header('Content-Type: application/json');
    die(json_encode([
        "status" => "error",
        "message" => "Kết nối Database thất bại: " . $conn->connect_error
    ]));
}

// Thiết lập bảng mã UTF-8 để hiển thị tiếng Việt không bị lỗi font
$conn->set_charset("utf8mb4");

// Lưu ý: Không đóng kết nối ở đây, biến $conn sẽ được dùng tiếp trong api.php
?>