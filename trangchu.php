<?php
session_start();
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quanlysanbong</title>
    <link rel="stylesheet" href="css/style.css">
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

    </style>
</head>
<body>
    <header id="header">
        <div class="logo">
            <img src="img/logo.jpg" alt="Sport Logo" width="100px">
        </div>
        <nav id="menu">
            <ul>
                <li class="item active"><a href="trangchu.php" id="trangchu">Trang Chủ</a></li>
                <li class="item"><a href="San.php">Danh sách sân</a></li>
                <?php
                    if(isset($_SESSION['MaNhanVien']) || isset($_SESSION['MaChuSan']) || isset($_SESSION['MaQuanTri']))
                    echo '<li class="item"><a href="admin.php">Quản lý</a></li>';
                ?>
                <li class="item"><a href="timkiem.php">Tìm Kiếm</a></li>
            </ul>
        </nav>
        <div id="actions">
            <!-- <button class="btn-register"><a style="color: white;" href="view/dangki.php">Đăng ký</a></button> -->
            <?php
                 if(isset($_SESSION["dangnhap"])){
                    // var_dump($_SESSION["hoten"]);
                    if( isset($_SESSION['loaiNguoiDung']) && $_SESSION['loaiNguoiDung'] == 'khachhang'){
                        echo '<button class="btn-login"><a style="color: white;" href="?lichsudatsan">Danh sách đơn đặt sân</a></button>';
                    }
                    echo '<button class="btn-login"><a style="color: white;" href="view/userDetail.php"><i style="font-size:24px" class="fa">&#xf007;</i> '.$_SESSION["hoten"].'</a></button>';
                    echo '<button class="btn-login"><a style="color: white;" href="view/dangxuat.php">Đăng xuất</a></button>';
                 }else{
                    echo '<button class="btn-register"><a style="color: white;" href="view/dangki.php">Đăng ký</a></button>';
                    echo '<button class="btn-login"><a style="color: white;" href="view/dangnhap.php">Đăng nhập</a></button>';
                 }
            ?>
                
            <!-- <button class="btn-login"><a href="view/dangnhap.php">Đăng nhập</a></button> -->
        </div>
    </header>
                 
    <!-- Banner -->
     <?php
    if (isset($_REQUEST["lichsudatsan"])) {
        if (isset($_SESSION['loaiNguoiDung']) && $_SESSION['loaiNguoiDung'] == 'khachhang') {
            include_once("View/listDonDatSan.php");
        }
    }else{
        echo '<section id="banner">
        <div class="box-left">
            <h2>Hãy nhanh tay tìm các sân chơi Xịn Xò để cháy hết mình với đam mê!</h2>
            <button>
            <a style="color: white;" href="San.php">Xem ngay</a>
                
            </button>
            
        </div>
    </section>

    <section id="featured-fields">
        <div class="field-list">
            <div class="field-item">
                <img src="img/image_3.png">
                <h3>Tìm kiếm vị trí sân</h3>
                <p>Dữ liệu sân đấu dồi dào, liên tục cập nhật, giúp bạn dễ dàng tìm kiếm theo khu vực mong muốn</p>
            </div>
            <div class="field-item">
                <img src="img/image_4.png">
                <h3>Đặt lịch online</h3>
                <p>Không cần đến trực tiếp, không cần gọi điện đặt lịch, bạn hoàn toàn có thể đặt sân ở bất kì đâu có internet</p>
            </div>
            <div class="field-item">
                <img src="img/image_5.png">
                <h3>Tìm đối, bắt cặp đấu</h3>
                <p>Tìm kiếm, giao lưu các đội thi đấu thể thao, kết nối, xây dựng cộng đồng thể thao sôi nổi, mạnh mẽ</p>
            </div>
        </div>
        <div class="view-more">
            <a href="San.php">Xem tất cả sân bóng</a>
        </div>
    </section>';
    }
     ?>
    <!-- <section id="banner">
        <div class="box-left">
            <h2>Hãy nhanh tay tìm các sân chơi Xịn Xò để cháy hết mình với đam mê!</h2>
            <button>
            <a style="color: white;" href="San.php">Xem ngay</a>
                
            </button>
            
        </div>
    </section>

    <section id="featured-fields">
        <div class="field-list">
            <div class="field-item">
                <img src="img/image_3.png">
                <h3>Tìm kiếm vị trí sân</h3>
                <p>Dữ liệu sân đấu dồi dào, liên tục cập nhật, giúp bạn dễ dàng tìm kiếm theo khu vực mong muốn</p>
            </div>
            <div class="field-item">
                <img src="img/image_4.png">
                <h3>Đặt lịch online</h3>
                <p>Không cần đến trực tiếp, không cần gọi điện đặt lịch, bạn hoàn toàn có thể đặt sân ở bất kì đâu có internet</p>
            </div>
            <div class="field-item">
                <img src="img/image_5.png">
                <h3>Tìm đối, bắt cặp đấu</h3>
                <p>Tìm kiếm, giao lưu các đội thi đấu thể thao, kết nối, xây dựng cộng đồng thể thao sôi nổi, mạnh mẽ</p>
            </div>
        </div>
        <div class="view-more">
            <a href="San.php">Xem tất cả sân bóng</a>
        </div>
    </section> -->

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
