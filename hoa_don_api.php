<?php
require 'db.php';
$action=$_POST['action'] ?? '';

if($action=='fetch'){
$sql="
SELECT dp.*, kh.HoTen, p.SoPhong
FROM datphong dp
JOIN khachhang kh ON dp.KhachHangID=kh.KhachHangID
JOIN phong p ON dp.PhongID=p.PhongID
";
$rs=$conn->query($sql);
$data=[];
while($r=$rs->fetch_assoc()) $data[]=$r;
echo json_encode($data);
}

if($action=='insert'){
$stmt=$conn->prepare("
INSERT INTO datphong(KhachHangID,PhongID,NgayDat,NgayNhan,NgayTra,TrangThai)
VALUES(?,?,?,?,?,?)
");
$stmt->bind_param("iissss",
$_POST['khachhang_id'],
$_POST['phong_id'],
$_POST['ngay_dat'],
$_POST['ngay_nhan'],
$_POST['ngay_tra'],
$_POST['trang_thai']
);
echo $stmt->execute();
}
