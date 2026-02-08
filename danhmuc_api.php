<?php
require_once "db.php";

$action = $_GET['action'] ?? '';

/* ======================
   LẤY DANH SÁCH DANH MỤC
====================== */
if ($action === 'list') {
    $sql = "SELECT * FROM danh_muc ORDER BY id DESC";
    $result = $conn->query($sql);

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);
    exit;
}

/* ======================
   LẤY 1 DANH MỤC
====================== */
if ($action === 'get') {
    $id = intval($_GET['id']);

    $sql = "SELECT * FROM danh_muc WHERE id = $id";
    $result = $conn->query($sql);

    echo json_encode($result->fetch_assoc());
    exit;
}

/* ======================
   THÊM DANH MỤC
====================== */
if ($action === 'add') {
    $ten = $_POST['ten_danh_muc'];
    $mo_ta = $_POST['mo_ta'];
    $trang_thai = intval($_POST['trang_thai']);

    $sql = "INSERT INTO danh_muc (ten_danh_muc, mo_ta, trang_thai)
            VALUES ('$ten', '$mo_ta', $trang_thai)";

    $conn->query($sql);

    echo json_encode(["status" => "success"]);
    exit;
}

/* ======================
   CẬP NHẬT DANH MỤC
====================== */
if ($action === 'update') {
    $id = intval($_POST['id']);
    $ten = $_POST['ten_danh_muc'];
    $mo_ta = $_POST['mo_ta'];
    $trang_thai = intval($_POST['trang_thai']);

    $sql = "UPDATE danh_muc 
            SET ten_danh_muc='$ten', mo_ta='$mo_ta', trang_thai=$trang_thai
            WHERE id=$id";

    $conn->query($sql);

    echo json_encode(["status" => "success"]);
    exit;
}

/* ======================
   XÓA DANH MỤC
====================== */
if ($action === 'delete') {
    $id = intval($_POST['id']);

    $sql = "DELETE FROM danh_muc WHERE id = $id";
    $conn->query($sql);

    echo json_encode(["status" => "success"]);
    exit;
}
