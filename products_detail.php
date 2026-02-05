<?php
header("Content-Type: application/json");
include_once 'db.php'; 

$action = $_GET['action'] ?? '';
$id = intval($_GET['id'] ?? 0);

if ($action == 'get_detail') {
    // Truy vấn lấy chi tiết từ bảng dich_vu
    $sql = "SELECT d.*, dm.ten_danh_muc 
            FROM dich_vu d 
            LEFT JOIN danh_muc dm ON d.danh_muc_id = dm.id 
            WHERE d.id = $id";
            
    $result = $conn->query($sql);
    
    if ($result && $row = $result->fetch_assoc()) {
        // Chuẩn bị dữ liệu khớp với JavaScript của bạn
        $row['gia'] = floatval($row['gia']);
        $row['hinh_anh_phu'] = [$row['hinh_anh']]; // Giả lập mảng ảnh phụ
        
        // Lấy sản phẩm tương tự
        $cat_id = $row['danh_muc_id'];
        $sql_sim = "SELECT id, ten_dich_vu, gia, hinh_anh FROM dich_vu WHERE danh_muc_id = $cat_id AND id != $id LIMIT 3";
        $res_sim = $conn->query($sql_sim);
        $similar = [];
        while($s = $res_sim->fetch_assoc()) {
            $s['gia'] = floatval($s['gia']);
            $similar[] = $s;
        }
        $row['san_pham_tuong_tu'] = $similar;
        
        echo json_encode($row);
    } else {
        echo json_encode(["error" => "Không tìm thấy dữ liệu trong Database"]);
    }
}
?>