<?php
session_start();
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sân bóng</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <header id="header">
        <div class="logo">
        <img src="img/logo.jpg" alt="Sport Logo" width="100px">
        </div>
        <nav id="menu">
            <ul>
                <li class="item active"><a href="trangchu.php" id="trangchu">Trang Chủ</a></li>
                <li class="item" id="dropdown">
                    <button class="dropbtn">Danh sách sân</button>
                    <div class="dropdown-content">
                        <?php
                            include_once("view/listLoaiSan.php");
                            echo "<a href='San.php'>Tất cả sân</a>";
                        ?>
                    </div>
                </li>
                <?php
                    if(isset($_SESSION['MaNhanVien']) || isset($_SESSION['MaChuSan']) || isset($_SESSION['MaQuanTri']))
                    echo '<li class="item"><a href="admin.php">Quản lý</a></li>';
                ?>
                <li class="item"><a href="timkiem.php">Tìm Kiếm</a></li>
            </ul>
        </nav>
        <div id="actions">
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
            <?php
                // if(isset($_SESSION["dangnhap"]) && isset($_SESSION['loaiNguoiDung']) && $_SESSION['loaiNguoiDung'] == 'khachhang'){
                //     echo '<button class="btn-login"><a style="color: white;" href="?lichsudatsan">Danh sách đơn đặt sân</a></button>';
                // }
            ?>
        </div>
    </header>

    <section id="product-list">
        <?php
            if (isset($_REQUEST["idsan"])) {
                include_once("View/chiTietSan.php");
            } else if (isset($_REQUEST["idloai"])) {
                include_once("View/listSan.php");
            } else if (isset($_REQUEST["btnTim"])) {
                include_once("View/timkiem.php");
            }   elseif(isset($_REQUEST["datsan"])){
                    if(isset($_SESSION['dangnhap'])){
                        // header("Location: view/datsan.php");
                        include_once("view/datsan.php");
                    }else{
                        echo"<script>alert('Bạn cần đăng nhập để có thể đặt sân!')</script>";
                        header("refresh: 0.5; url=view/dangnhap.php");
                    }
            } else if (isset($_REQUEST["lichsudatsan"])) {
                if (isset($_SESSION['loaiNguoiDung']) && $_SESSION['loaiNguoiDung'] == 'khachhang') {
                    include_once("View/listDonDatSan.php");
                }
            }else if (isset($_REQUEST["huyDonDatSan"])) {
                include_once("View/huyDonDatSan.php");
            }else if (isset($_REQUEST["viewDetail"])) {
                include_once("View/viewDetail.php");
            }else {
                include_once("view/listSan.php");
            }
        ?>
        <?php
                    
                 ?>
    </section>

    <!-- Footer Section -->
    <footer id="footer">
            <div class="box">
                <h3>GIỚI THIỆU</h3>
                <div class="logo">
                    <img src="img/logo.jpg" alt="Logo">
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
    </div>
    <script src="script.js"></script>
</body>

</html>
