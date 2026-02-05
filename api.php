<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
include_once 'db.php'; 

$action = $_GET['action'] ?? '';

// --- 1. LẤY DANH SÁCH DỊCH VỤ ---
if ($action == 'get_products') {
    $sql = "SELECT id, ten_dich_vu as name, gia as price, hinh_anh as image, danh_muc_id as cat 
            FROM dich_vu WHERE trang_thai = 1";
    $result = $conn->query($sql);
    
    $data = [];
    while($row = $result->fetch_assoc()) {
        if(empty($row['image'])) $row['image'] = "https://via.placeholder.com/150?text=No+Image";
        $data[] = $row;
    }
    echo json_encode($data);
} 

// --- 2. LẤY CHI TIẾT VÀ SẢN PHẨM TƯƠNG TỰ ---
elseif ($action == 'product_detail') {
    $id = intval($_GET['id'] ?? 0);
    
    // Lấy thông tin chi tiết dịch vụ
    $sql = "SELECT d.*, dm.ten_danh_muc 
            FROM dich_vu d 
            LEFT JOIN danh_muc dm ON d.danh_muc_id = dm.id 
            WHERE d.id = $id";
    $result = $conn->query($sql);
    $product = $result->fetch_assoc();

    if ($product) {
        // Lấy thêm 3 sản phẩm tương tự cùng danh mục
        $cat_id = $product['danh_muc_id'];
        $sql_similar = "SELECT id, ten_dich_vu as name, gia as price, hinh_anh as image 
                        FROM dich_vu WHERE danh_muc_id = $cat_id AND id != $id LIMIT 3";
        $res_similar = $conn->query($sql_similar);
        $similar = [];
        while($s = $res_similar->fetch_assoc()) {
            if(empty($s['image'])) $s['image'] = "https://via.placeholder.com/150";
            $similar[] = $s;
        }
        
        echo json_encode([
            "status" => "success",
            "details" => [
                "id" => $product['id'],
                "name" => $product['ten_dich_vu'],
                "price" => $product['gia'],
                "image" => $product['hinh_anh'] ?: "https://via.placeholder.com/400",
                "category_name" => $product['ten_danh_muc'] ?: "Dịch vụ"
            ],
            "similar_products" => $similar
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "Sản phẩm không tồn tại"]);
    }
}

// --- 3. XỬ LÝ LƯU ĐƠN HÀNG ---
elseif ($action == 'checkout') {
    $data = json_decode(file_get_contents("php://input"), true);
    if (!empty($data['cart'])) {
        $room = $conn->real_escape_string($data['roomNumber']);
        $ngay = date('Y-m-d H:i:s');
        
        // Mẹo: Trong bài tập này, ta giả định DatPhongID = 1 
        // để khớp với bảng sudungdichvu của bạn
        $datPhongID = 1; 

        foreach ($data['cart'] as $item) {
            $dv_id = intval($item['id']);
            $qty = intval($item['qty']);
            $sql = "INSERT INTO sudungdichvu (DatPhongID, DichVuID, SoLuong, NgaySuDung) 
                    VALUES ($datPhongID, $dv_id, $qty, '$ngay')";
            $conn->query($sql);
        }
        echo json_encode(["status" => "success", "message" => "Đơn hàng phòng $room đã được ghi nhận!"]);
    }
}

$conn->close();
?>