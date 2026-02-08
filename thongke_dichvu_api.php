
<?php
header('Content-Type: application/json; charset=utf-8');

$conn = new PDO("mysql:host=localhost;dbname=quan_li_khach_san;charset=utf8","root","");

$sql = "
SELECT dv.ten_dich_vu,
       COUNT(sd.SuDungID) AS so_luot,
       SUM(sd.SoLuong * dv.gia) AS doanh_thu
FROM sudungdichvu sd
JOIN dich_vu dv ON sd.DichVuID = dv.id
GROUP BY sd.DichVuID
";

$data = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);

$totalUse = 0;
$totalRevenue = 0;
$topService = '';
$max = 0;

foreach ($data as $row) {
    $totalUse += $row['so_luot'];
    $totalRevenue += $row['doanh_thu'];
    if ($row['so_luot'] > $max) {
        $max = $row['so_luot'];
        $topService = $row['ten_dich_vu'];
    }
}

echo json_encode([
    'total_use' => $totalUse,
    'total_revenue' => $totalRevenue,
    'top_service' => $topService,
    'services' => $data
]);
