<?php
include "db.php";

if (isset($_POST['register'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $check = mysqli_query($conn, "SELECT * FROM users WHERE username='$user'");
    if (mysqli_num_rows($check) > 0) {
        $error = "Tên đăng nhập đã tồn tại";
    } else {
        $sql = "INSERT INTO users(username, password, role)
                VALUES ('$user', '$pass', 'user')";
        mysqli_query($conn, $sql);
        header("Location: login.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(120deg, #f6f9fc, #e9eff5);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .register-card {
            width: 100%;
            max-width: 420px;
            border-radius: 16px;
        }
    </style>
</head>
<body>

<div class="card shadow register-card p-4">
    <h3 class="text-center fw-bold mb-4">Đăng ký tài khoản</h3>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label class="form-label">Tên đăng kí</label>
            <input type="text" name="username" class="form-control" placeholder="Nhập tên đăng nhập" required>
        </div>

        <div class="mb-3">
            <label class="form-label">  Tạo mật khẩu</label>
            <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu" required>
        </div>
        <button type="submit" name="register" class="btn btn-dark w-100 py-2">
            ĐĂNG KÝ
        </button>
    </form>

    <p class="text-center mt-3 mb-0">
        Đã có tài khoản?
        <a href="login.php" class="fw-semibold text-decoration-none">Đăng nhập</a>
    </p>
</div>

</body>
</html>



