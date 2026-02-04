<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Quản lý Phòng</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<style>
.table th{background:#0d6efd;color:white}
</style>
</head>

<body class="bg-light">

<div class="container mt-4">
<div class="card shadow">
<div class="card-header d-flex justify-content-between">
<h5>🏨 QUẢN LÝ PHÒNG</h5>
<button class="btn btn-primary" id="btnAdd">➕ Thêm phòng</button>
</div>

<div class="card-body">
<table class="table table-bordered text-center align-middle">
<thead>
<tr>
<th>ID</th>
<th>Tên phòng</th>
<th>Loại</th>
<th>Giá</th>
<th>Trạng thái</th>
<th>Hành động</th>
</tr>
</thead>
<tbody id="phongTable"></tbody>
</table>
</div>
</div>
</div>

<!-- MODAL -->
<div class="modal fade" id="modalPhong">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h5>Phòng</h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
<input type="hidden" id="id">

<label>Tên phòng</label>
<input class="form-control mb-2" id="ten_phong">

<label>Loại phòng</label>
<input class="form-control mb-2" id="loai_phong">

<label>Giá</label>
<input type="number" class="form-control mb-2" id="gia">

<label>Trạng thái</label>
<select class="form-control" id="trang_thai">
<option value="0">Trống</option>
<option value="1">Đang thuê</option>
</select>
</div>

<div class="modal-footer">
<button class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
<button class="btn btn-success" id="btnSave">Lưu</button>
</div>
</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(function(){
    loadPhong();

    function loadPhong(){
        $.post("phong_api.php",{action:"fetch"},function(data){
            let rows="";
            $.each(JSON.parse(data),function(i,v){
                rows+=`
                <tr>
                    <td>${v.id}</td>
                    <td>${v.ten_phong}</td>
                    <td>${v.loai_phong}</td>
                    <td>${v.gia}</td>
                    <td>${v.trang_thai==0?"Trống":"Đang thuê"}</td>
                    <td>
                        <button class="btn btn-warning btn-sm btnEdit"
                            data-json='${JSON.stringify(v)}'>Sửa</button>
                        <button class="btn btn-danger btn-sm btnDelete"
                            data-id="${v.id}">Xóa</button>
                    </td>
                </tr>`;
            });
            $("#phongTable").html(rows);
        });
    }

    $("#btnAdd").click(()=>{
        $("input").val("");
        $("#id").val("");
        $("#modalPhong").modal("show");
    });

    $("#btnSave").click(()=>{
        let data={
            action: $("#id").val()?"update":"insert",
            id: $("#id").val(),
            ten_phong: $("#ten_phong").val(),
            loai_phong: $("#loai_phong").val(),
            gia: $("#gia").val(),
            trang_thai: $("#trang_thai").val()
        };
        $.post("phong_api.php",data,function(){
            $("#modalPhong").modal("hide");
            loadPhong();
        });
    });

    $(document).on("click",".btnEdit",function(){
        let v=$(this).data("json");
        $("#id").val(v.id);
        $("#ten_phong").val(v.ten_phong);
        $("#loai_phong").val(v.loai_phong);
        $("#gia").val(v.gia);
        $("#trang_thai").val(v.trang_thai);
        $("#modalPhong").modal("show");
    });

    $(document).on("click",".btnDelete",function(){
        if(confirm("Xóa phòng này?")){
            $.post("phong_api.php",{action:"delete",id:$(this).data("id")},loadPhong);
        }
    });
});
</script>

</body>
</html>
