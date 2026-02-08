<?php
header("Content-Type: application/json; charset=UTF-8");

$host = "localhost";
$db_name = "quan_li_khach_san";
$username = "root";
$password = "";

try {
    $conn = new PDO(
        "mysql:host=".$host.";dbname=".$db_name.";charset=utf8",
        $username,
        $password
    );
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo json_encode(array(
        "status" => false,
        "message" => "Lỗi kết nối DB",
        "error" => $e->getMessage()
    ));
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if ($data === null) {
    echo json_encode(array(
        "status" => false,
        "message" => "Không nhận được JSON"
    ));
    exit;
}

if (
    !isset($data['DatPhongID']) ||
    !isset($data['DichVuID']) ||
    !isset($data['SoLuong']) ||
    !isset($data['NgaySuDung'])
) {
    echo json_encode(array(
        "status" => false,
        "message" => "Thiếu dữ liệu bắt buộc",
        "debug" => $data
    ));
    exit;
}

$sql = "INSERT INTO sudungdichvu (DatPhongID, DichVuID, SoLuong, NgaySuDung)
        VALUES (:datphong, :dichvu, :soluong, :ngaysudung)";

$stmt = $conn->prepare($sql);

try {
    $stmt->execute(array(
        ":datphong"   => $data['DatPhongID'],
        ":dichvu"     => $data['DichVuID'],
        ":soluong"    => $data['SoLuong'],
        ":ngaysudung" => $data['NgaySuDung']
    ));

    echo json_encode(array(
        "status" => true,
        "message" => "Đặt dịch vụ thành công"
    ));
} catch(PDOException $e) {
    echo json_encode(array(
        "status" => false,
        "message" => "Không thể đặt dịch vụ",
        "error" => $e->getMessage()
    ));
}
