<?php
require 'db.php';

$action = $_POST['action'] ?? '';

/* LOAD */
if ($action === 'fetch') {
    $rs = $conn->query("SELECT * FROM danh_muc ORDER BY id DESC");
    $data = [];
    while ($row = $rs->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
    exit;
}

/* INSERT */
if ($action === 'insert') {
    $ten = $_POST['ten_danh_muc'] ?? '';
    $moTa = $_POST['mo_ta'] ?? '';
    $trangThai = $_POST['trang_thai'] ?? 1;

    $stmt = $conn->prepare(
        "INSERT INTO danh_muc(ten_danh_muc, mo_ta, trang_thai)
         VALUES (?,?,?)"
    );
    $stmt->bind_param("ssi", $ten, $moTa, $trangThai);
    echo $stmt->execute();
    exit;
}

/* UPDATE */
if ($action === 'update') {
    $stmt = $conn->prepare(
        "UPDATE danh_muc 
         SET ten_danh_muc=?, mo_ta=?, trang_thai=?
         WHERE id=?"
    );
    $stmt->bind_param(
        "ssii",
        $_POST['ten_danh_muc'],
        $_POST['mo_ta'],
        $_POST['trang_thai'],
        $_POST['id']
    );
    echo $stmt->execute();
    exit;
}

/* DELETE */
if ($action === 'delete') {
    $stmt = $conn->prepare("DELETE FROM danh_muc WHERE id=?");
    $stmt->bind_param("i", $_POST['id']);
    echo $stmt->execute();
    exit;
}
