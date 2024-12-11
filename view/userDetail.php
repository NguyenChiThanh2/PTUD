<?php
// error_reporting(0);
session_start();
ob_start();

if(!$_SESSION['dangnhap']){
    header('refresh: 0.5; url=dangnhap.php');
}
if (!isset($_SESSION["dangnhap"]) || !isset($_SESSION["loaiNguoiDung"])) {
    echo '<script>alert("Bạn không có quyền truy cập!");</script>';
    header("refresh: 0; url=../index.php");
    exit();
}
include_once("..//controller/cUser.php");
$p = new ControllerUser();
$kq = mysqli_fetch_assoc($p->getAUserByEmail2($_SESSION['email']));
// $userName = isset($kq['name']) ? $kq['name'] : null;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quanlysanbong</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        #featured-fields {
            margin: 40px 0;
            text-align: center;
        }

        #featured-fields h2 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #333;
        }

        .field-list {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            max-width: 1200px;
            margin: 0 auto;
        }

        .field-item {
            flex: 1;
            min-width: 250px;
            max-width: 300px;
            text-align: center;
            padding: 20px;
            margin: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            transition: transform 0.2s;
        }

        .field-item:hover {
            transform: scale(1.05);
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
        }

        .field-item img {
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .field-item h3 {
            font-size: 18px;
            margin: 10px 0;
            color: #4CAF50;
        }

        .field-item p {
            font-size: 14px;
            color: #555;
        }

        .view-more {
            margin-top: 20px;
        }

        .view-more a {
            text-decoration: none;
            color: #4CAF50;
            font-weight: bold;
            border: 1px solid #4CAF50;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        .view-more a:hover {
            background-color: #4CAF50;
            color: white;
        }

        .user-details-container {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 400px;
            padding: 20px;
        }
        .user-details-container h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .user-details-container .detail-group {
            margin-bottom: 15px;
        }
        .user-details-container label {
            font-weight: bold;
            color: #555;
            display: block;
            margin-bottom: 5px;
        }
        .user-details-container input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            color: #333;
            background: #f9f9f9;
        }
        .user-details-container input:disabled {
            background: #eaeaea;
        }
        .user-details-container .btn-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .user-details-container button {
            background: #4caf50;
            color: white;
            border: none;
            padding: 10px 15px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .user-details-container button:hover {
            background: #45a049;
        }
        .user-details-container .btn-edit {
            background: #2196f3;
        }
        .user-details-container .btn-edit:hover {
            background: #1e88e5;
        }

        .form-container {
    display: flex;
    justify-content: center; /* Căn giữa theo chiều ngang */
    align-items: center;    /* Căn giữa theo chiều dọc */
    height: 100vh;          /* Chiều cao của container bằng 100% chiều cao của viewport */
}

.user-details-container {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    width: 400px;           /* Đặt chiều rộng của form */
    padding: 20px;
    box-sizing: border-box;
}

    </style>
</head>
<body>
    <header id="header">
        <div class="logo">
            <img src="img/logo.jpg" alt="Sport Logo" width="100px">
        </div>
        <nav id="menu">
            <ul>
                <li class="item active"><a href="../trangchu.php" id="trangchu">Trang Chủ</a></li>
                <li class="item"><a href="../San.php">Danh sách sân</a></li>
                <li class="item"><a href="../admin.php">Quản lý</a></li>
                <li class="item"><a href="../timkiem.php">Tìm Kiếm</a></li>
            </ul>
        </nav>
        <div id="actions">
            <!-- <button class="btn-register"><a style="color: white;" href="view/dangki.php">Đăng ký</a></button> -->
            <?php
                 if(isset($_SESSION["dangnhap"])){
                    // var_dump($_SESSION["hoten"]);

                    echo '<button class="btn-login"><a style="color: white;" href="userDetail.php"><i style="font-size:24px" class="fa">&#xf007;</i> '.$_SESSION["hoten"].'</a></button>';
                    echo '<button class="btn-login"><a style="color: white;" href="../view/dangxuat.php">Đăng xuất</a></button>';
                 }else{
                    echo '<button class="btn-register"><a style="color: white;" href="view/dangki.php">Đăng ký</a></button>';
                    echo '<button class="btn-login"><a style="color: white;" href="view/dangnhap.php">Đăng nhập</a></button>';
                 }
            ?>
            <!-- <button class="btn-login"><a href="view/dangnhap.php">Đăng nhập</a></button> -->
        </div>
    </header>
    
    <div class="form-container">
    <div class="user-details-container">
        <h2>Chi Tiết User</h2>
        
        <div class="detail-group">
            <label for="userName">Họ và Tên</label>
            <input type="text" id="userName" value="<?= $_SESSION['hoten'] ?>" disabled>
        </div>
        
        <div class="detail-group">
            <label for="userEmail">Email</label>
            <input type="email" id="userEmail" value="<?= $kq['Email'] ?>" disabled>
        </div>
        
        <div class="detail-group">
            <label for="userPassword">Mật Khẩu</label>
            <input type="password" id="userPassword" value="<?= $kq['MatKhau'] ?>" disabled>
        </div>
        
        <?php
            if (!isset($_SESSION["MaQuanTri"])) {
                echo '
                    <div class="detail-group">
                        <label for="userPhone">Số Điện Thoại</label>
                        <input type="tel" id="userPhone" value="' . $kq['SDT'] . '" disabled>
                    </div>
                    <div class="detail-group">
                        <label for="diachi">Địa Chỉ</label>
                        <input type="text" id="userAdd" value="' . $kq['DiaChi'] . '" disabled>
                    </div>
                    <div class="detail-group">
                        <label for="userGender">Giới tính</label>
                        <select id="userGender" disabled>
                            <option value="male" ' . ($kq['GioiTinh'] == 1 ? 'selected' : '') . '>Nam</option>
                            <option value="female" ' . ($kq['GioiTinh'] == 0 ? 'selected' : '') . '>Nữ</option>
                        </select>
                    </div>
                ';
            }
            ?>
        
        <div class="btn-container">
        <button onclick='window.history.back();' >Quay lại</button>
            <!-- <button class="btn-edit" id="btnEdit">Chỉnh sửa</button>
            <button class="btn-save" id="btnSave" disabled>Lưu</button> -->
        </div>
    </div>
</div>

    

    <!-- Footer Section -->
    <footer id="footer">
        <div class="box">
            <h3>GIỚI THIỆU</h3>
            <div class="logo">
                <img src="img/logo.jpg" alt="Logo" width="200px">
            </div>
            <p>Cung cấp một nền tảng tiện lợi, giúp người dùng dễ dàng tìm kiếm, đặt chỗ và quản lý việc thuê sân bóng</p>
        </div>
        <div class="box">
            <h3>NỘI DUNG</h3>
            <ul class="quick-menu">
                <li class="item"><a href="index.php">Trang chủ</a></li>
                <li class="item"><a href="San.php">Danh sách sân</a></li>
                <li class="item"><a href="#">Dịch vụ</a></li>
                <li class="item"><a href="https://www.facebook.com/chuyen.cho.thue.san.bong/">Liên hệ</a></li>
            </ul>
        </div>
        <div class="box">
            <h3>Thông tin</h3>
            <p><strong>Website đặt sân trực tuyến</strong></p>
            <p>Email: <a href="mailto:contact@datsan247.com">contact@datsan.com</a></p>
            <p>Địa chỉ: Nguyễn Văn Bảo, Phường 14, Gò Vấp</p>
            <p>Điện thoại: <a href="tel:+84355193363">0355193363</a></p>
        </div>
    </footer>
    <script src="script.js"></script>
</body>
</html>
