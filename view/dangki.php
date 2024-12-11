<?php
    // session_start();
    // if($_SESSION["dangnhap"])
    //     header("Location:index.php");
    include_once("../controller/cUser.php");
    if(isset($_REQUEST["btnDangKy"])){
        $hoten = $_REQUEST["hoten"];
        $email = $_REQUEST["email"];
        $matkhau = $_REQUEST["matkhau"];
        $sodienthoai = $_REQUEST["sodienthoai"];
        $diachi = $_REQUEST["diachi"];
        $gioitinh = $_REQUEST["gioitinh"];
        $loaiTK = $_REQUEST["loaitaikhoan"];
        $p = new ControllerUser();
        $kq = $p->getAUserByEmail($email);
        if(!$kq){
            $p2 = new ControllerUser();
            
            $kq2 = $p->registerTK($hoten, $email, $matkhau, $sodienthoai, $diachi, $gioitinh, $loaiTK);
            header("refresh: 0.5; url=dangnhap.php");
        }else{
            echo "<script>alert('Email đã tồn tại, vui lòng sử dụng email khác !')</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('../img/pexels-photo-61135.jpeg');
            background-size: cover; 
            background-position: center; 
            height: 100vh; 
        }
        .container {
            margin-top: 10px;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            width: 70%;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            position: relative; /* For positioning the close button */
        }
        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            font-size: 20px;
            color: #0062E6;
            cursor: pointer;
        }
        .btn-primary {
            background-color: #0062E6;
            border: none;
            transition: background-color 0.3s;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
<div class="container">
    <button class="close-btn" onclick="window.history.back();">&times;</button>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center">Đăng ký tài khoản</h2>
            <form method="POST" onsubmit="return validatePassword()">
                <div class="mb-3">
                    <label for="fullname" class="form-label">Họ và tên</label>
                    <input type="text" class="form-control" id="fullname" placeholder="Nhập họ và tên" name="hoten" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="Nhập email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <input type="password" class="form-control" id="password" placeholder="Nhập mật khẩu" name="matkhau" required>
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Nhập lại mật khẩu</label>
                    <input type="password" class="form-control" id="confirm_password" placeholder="Nhập lại mật khẩu" required>
                    <span id="passwordError" style="color: red; font-size: 14px;"></span>
                </div>
                <div class="mb-3">
                    <label for="sdt" class="form-label">Số điện thoại</label>
                    <input type="tel" class="form-control" id="sdt" placeholder="Nhập Số điện thoại" name="sodienthoai" required>
                </div>
                <div class="mb-3">
                    <label for="diachi" class="form-label">Địa chỉ</label>
                    <input type="text" class="form-control" id="diachi" placeholder="Địa chỉ" name="diachi" required>
                </div>
                <div style="display:flex; justify-content: space-between;">
                    <div class="mb-3">
                        <label class="form-label">Giới tính</label><br>
                        &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id="nam" name="gioitinh" value="1" required>
                        <label for="1">Nam</label><br>
                        &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id="nu" name="gioitinh" value="0">
                        <label for="0">Nữ</label>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Loại tài khoản</label><br>
                        &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id="canhan" name="loaitaikhoan" value="canhan" required>
                        <label for="khachhang">Cá nhân</label><br>
                        &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id="kinhdoanh" name="loaitaikhoan" value="kinhdoanh">
                        <label for="chusan">Kinh doanh</label>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary w-100" name="btnDangKy">Đăng ký</button>
            </form>
            <p class="text-center mt-3">
                Đã có tài khoản? <a href="dangnhap.php">Đăng nhập</a>
            </p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<script>
    // Kiểm tra khớp mật khẩu khi nhập
    document.getElementById("confirm_password").addEventListener("input", function () {
        const password = document.getElementById("password").value;
        const confirmPassword = document.getElementById("confirm_password").value;
        const errorSpan = document.getElementById("passwordError");

        if (confirmPassword !== password) {
            errorSpan.textContent = "Mật khẩu không khớp.";
        } else {
            errorSpan.textContent = "";
        }
    });

    // Kiểm tra trước khi gửi form
    function validatePassword() {
        const password = document.getElementById("password").value;
        const confirmPassword = document.getElementById("confirm_password").value;

        if (password !== confirmPassword) {
            alert("Mật khẩu và Nhập lại mật khẩu không khớp. Vui lòng kiểm tra lại.");
            return false;
        }
        return true;
    }
</script>
