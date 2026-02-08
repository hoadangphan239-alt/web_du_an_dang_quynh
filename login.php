<?php
session_start();
include "db.php";

if (isset($_POST['login'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$user'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row && $pass == $row['password']) {
        $_SESSION['user'] = $row;
        header("Location: ../index.php");
        exit;
    } else {
        $error = "Sai tài khoản hoặc mật khẩu";
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
    <h3 class="text-center fw-bold mb-4">Đăng nhập</h3>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label class="form-label">Tên đăng nhập</label>
            <input type="text" name="username" class="form-control" placeholder="Nhập tên đăng nhập" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Mật khẩu</label>
            <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu" required>
        </div>

        <button type="submit" name="register" class="btn btn-dark w-100 py-2">
            ĐĂNG NHẬP 
        </button>
    </form>

    <p class="text-center mt-3 mb-0">
    Chưa có tài khoản?
        <a href="register.php" class="fw-semibold text-decoration-none">Đăng kí</a>
    </p>
</div>

</body>
</html>




