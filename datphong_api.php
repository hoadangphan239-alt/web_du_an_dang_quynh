<?php
header("Content-Type: application/json; charset=UTF-8");
require_once "db.php";

$action = $_GET['action'] ?? '';

/* =========================
   THÊM ĐẶT PHÒNG
========================= */
if ($action === 'add') {

    $khachhang_id = intval($_POST['KhachHangID']);
    $phong_id     = intval($_POST['PhongID']);
    $ngay_nhan    = $_POST['NgayNhan'];
    $ngay_tra     = $_POST['NgayTra'];
    $trang_thai   = "Đang đặt";
    $ngay_dat     = date("Y-m-d");

    if (!$khachhang_id || !$phong_id || !$ngay_nhan) {
        echo json_encode(["status"=>"error","message"=>"Thiếu dữ liệu"]);
        exit;
    }

    $sql = "INSERT INTO datphong
            (KhachHangID, PhongID, NgayDat, NgayNhan, NgayTra, TrangThai)
            VALUES
            ($khachhang_id, $phong_id, '$ngay_dat', '$ngay_nhan', '$ngay_tra', '$trang_thai')";

    if ($conn->query($sql)) {
        echo json_encode(["status"=>"success"]);
    } else {
        echo json_encode(["status"=>"error","message"=>$conn->error]);
    }
    exit;
}

/* =========================
   DANH SÁCH ĐẶT PHÒNG (ADMIN)
========================= */
if ($action === 'list') {

    $sql = "SELECT dp.*, kh.TenKH, p.TenPhong
            FROM dat_phong dp
            JOIN khach_hang kh ON dp.KhachHangID = kh.KhachHangID
            JOIN phong p ON dp.PhongID = p.PhongID
            ORDER BY dp.DatPhongID DESC";

    $result = $conn->query($sql);
    $data = [];

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);
    exit;
}

/* =========================
   CẬP NHẬT TRẠNG THÁI
========================= */
if ($action === 'status') {

    $id = intval($_POST['DatPhongID']);
    $trang_thai = $_POST['TrangThai'];

    $conn->query("UPDATE dat_phong SET TrangThai='$trang_thai' WHERE DatPhongID=$id");
    echo json_encode(["status"=>"success"]);
    exit;
}

/* =========================
   XÓA ĐẶT PHÒNG
========================= */
if ($action === 'delete') {

    $id = intval($_POST['DatPhongID']);
    $conn->query("DELETE FROM dat_phong WHERE DatPhongID=$id");
    echo json_encode(["status"=>"success"]);
    exit;
}
