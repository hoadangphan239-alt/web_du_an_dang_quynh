<?php
require 'db.php';
$action = $_POST['action'] ?? '';

if ($action == 'fetch') {
    $sql = "
        SELECT p.*, d.ten_danh_muc
        FROM phong p
        LEFT JOIN danh_muc d ON p.id_danh_muc = d.id
    ";
    $rs=$conn->query($sql);
    $data=[];
    while($r=$rs->fetch_assoc()) $data[]=$r;
    echo json_encode($data);
}

if ($action == 'loadDanhMuc') {
    $rs=$conn->query("SELECT * FROM danh_muc WHERE trang_thai=1");
    $data=[];
    while($r=$rs->fetch_assoc()) $data[]=$r;
    echo json_encode($data);
}

if ($action == 'insert') {
    $stmt=$conn->prepare("
        INSERT INTO phong(SoPhong,LoaiPhong,GiaPhong,TrangThai,id_danh_muc)
        VALUES (?,?,?,?,?)
    ");
    $stmt->bind_param("ssdsi",
        $_POST['so_phong'],
        $_POST['loai_phong'],
        $_POST['gia_phong'],
        $_POST['trang_thai'],
        $_POST['id_danh_muc']
    );
    echo $stmt->execute();
}
