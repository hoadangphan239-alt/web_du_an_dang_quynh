<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Hóa đơn</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body class="bg-light">

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header">
            <h5>🧾 HÓA ĐƠN DỊCH VỤ</h5>
        </div>

        <div class="card-body">
            <!-- nội dung hóa đơn -->
            <table class="table table-bordered text-center">
                <thead class="table-primary">
                <tr>
                    <th>Dịch vụ</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th>Thành tiền</th>
                </tr>
                </thead>
                <tbody id="cthd"></tbody>
            </table>
        </div>
    </div>
</div>

<script>
$(function(){
    $.post("hoa_don_api.php",{action:"test"},function(data){
        console.log(data);
    });
});
</script>

</body>
</html>
